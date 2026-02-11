import argparse
import json
import os
from datetime import datetime, timezone


def _iso_utc_now() -> str:
    return datetime.now(timezone.utc).replace(microsecond=0).isoformat()


def _jsonable(value):
    if value is None:
        return None
    if isinstance(value, (str, int, float, bool)):
        return value
    if isinstance(value, bytes):
        try:
            return value.decode("utf-8", errors="replace")
        except Exception:
            return repr(value)
    if isinstance(value, dict):
        return {str(k): _jsonable(v) for k, v in value.items()}
    if isinstance(value, (list, tuple, set)):
        return [_jsonable(v) for v in value]
    return str(value)


def _safe_filename(value: str) -> str:
    value = (value or "").strip()
    if not value:
        return "file"
    allowed = set("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.")
    cleaned = "".join(ch if ch in allowed else "_" for ch in value)
    cleaned = cleaned.strip("._")
    return cleaned or "file"


def _infer_image_ext(name: str) -> str:
    name = (name or "").lower()
    if "." in name:
        ext = name.rsplit(".", 1)[-1]
        if ext in {"jpg", "jpeg", "png", "gif", "tif", "tiff", "bmp", "jp2"}:
            return ext
    return "bin"


def _sql_escape(value: str) -> str:
    return (
        (value or "")
        .replace("\\", "\\\\")
        .replace("\0", "\\0")
        .replace("\n", "\\n")
        .replace("\r", "\\r")
        .replace("\t", "\\t")
        .replace("\x1a", "\\Z")
        .replace("'", "\\'")
    )


def _sql_value(value) -> str:
    if value is None:
        return "NULL"
    if isinstance(value, bool):
        return "1" if value else "0"
    if isinstance(value, (int, float)):
        return str(value)
    return f"'{_sql_escape(str(value))}'"


def _iso_to_mysql_datetime(value: str | None) -> str | None:
    if not value:
        return None
    try:
        dt = datetime.fromisoformat(value)
        if dt.tzinfo is not None:
            dt = dt.astimezone(timezone.utc).replace(tzinfo=None)
        return dt.strftime("%Y-%m-%d %H:%M:%S")
    except Exception:
        return None


def export_mysql_sql(result: dict, sql_output_path: str) -> str:
    os.makedirs(os.path.dirname(os.path.abspath(sql_output_path)) or os.getcwd(), exist_ok=True)

    source = result.get("source", {})
    data = result.get("data", {})
    text = result.get("text", {})

    extracted_at = _iso_to_mysql_datetime(source.get("extracted_at"))
    full_text = text.get("full", "")

    lines: list[str] = []
    lines.append("SET NAMES utf8mb4;")
    lines.append("SET time_zone = '+00:00';")
    lines.append("")
    lines.append("DROP TABLE IF EXISTS pdf_images;")
    lines.append("DROP TABLE IF EXISTS pdf_pages;")
    lines.append("DROP TABLE IF EXISTS pdf_metadata;")
    lines.append("DROP TABLE IF EXISTS pdf_documents;")
    lines.append("")
    lines.append(
        "CREATE TABLE pdf_documents (\n"
        "  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,\n"
        "  source_path TEXT NULL,\n"
        "  filename VARCHAR(255) NULL,\n"
        "  bytes BIGINT UNSIGNED NULL,\n"
        "  extracted_at DATETIME NULL,\n"
        "  page_count INT UNSIGNED NULL,\n"
        "  total_char_count INT UNSIGNED NULL,\n"
        "  total_word_count INT UNSIGNED NULL,\n"
        "  image_count INT UNSIGNED NULL,\n"
        "  full_text LONGTEXT NULL,\n"
        "  PRIMARY KEY (id)\n"
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
    )
    lines.append("")
    lines.append(
        "CREATE TABLE pdf_metadata (\n"
        "  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,\n"
        "  document_id BIGINT UNSIGNED NOT NULL,\n"
        "  meta_key VARCHAR(255) NOT NULL,\n"
        "  meta_value LONGTEXT NULL,\n"
        "  PRIMARY KEY (id),\n"
        "  KEY idx_pdf_metadata_document_id (document_id),\n"
        "  CONSTRAINT fk_pdf_metadata_document FOREIGN KEY (document_id) REFERENCES pdf_documents(id) ON DELETE CASCADE\n"
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
    )
    lines.append("")
    lines.append(
        "CREATE TABLE pdf_pages (\n"
        "  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,\n"
        "  document_id BIGINT UNSIGNED NOT NULL,\n"
        "  page_number INT UNSIGNED NOT NULL,\n"
        "  text LONGTEXT NULL,\n"
        "  char_count INT UNSIGNED NULL,\n"
        "  word_count INT UNSIGNED NULL,\n"
        "  PRIMARY KEY (id),\n"
        "  UNIQUE KEY uq_pdf_pages_document_page (document_id, page_number),\n"
        "  KEY idx_pdf_pages_document_id (document_id),\n"
        "  CONSTRAINT fk_pdf_pages_document FOREIGN KEY (document_id) REFERENCES pdf_documents(id) ON DELETE CASCADE\n"
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
    )
    lines.append("")
    lines.append(
        "CREATE TABLE pdf_images (\n"
        "  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,\n"
        "  document_id BIGINT UNSIGNED NOT NULL,\n"
        "  page_number INT UNSIGNED NOT NULL,\n"
        "  image_index INT UNSIGNED NOT NULL,\n"
        "  name VARCHAR(255) NULL,\n"
        "  file_path TEXT NULL,\n"
        "  bytes INT UNSIGNED NULL,\n"
        "  PRIMARY KEY (id),\n"
        "  UNIQUE KEY uq_pdf_images_document_page_index (document_id, page_number, image_index),\n"
        "  KEY idx_pdf_images_document_id (document_id),\n"
        "  CONSTRAINT fk_pdf_images_document FOREIGN KEY (document_id) REFERENCES pdf_documents(id) ON DELETE CASCADE\n"
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
    )
    lines.append("")

    lines.append(
        "INSERT INTO pdf_documents (source_path, filename, bytes, extracted_at, page_count, total_char_count, total_word_count, image_count, full_text) VALUES ("
        f"{_sql_value(source.get('path'))}, "
        f"{_sql_value(source.get('filename'))}, "
        f"{_sql_value(source.get('bytes'))}, "
        f"{_sql_value(extracted_at)}, "
        f"{_sql_value(data.get('page_count'))}, "
        f"{_sql_value(data.get('total_char_count'))}, "
        f"{_sql_value(data.get('total_word_count'))}, "
        f"{_sql_value(data.get('image_count'))}, "
        f"{_sql_value(full_text)}"
        ");"
    )
    lines.append("SET @doc_id = LAST_INSERT_ID();")
    lines.append("")

    metadata = data.get("metadata")
    if isinstance(metadata, dict):
        for k in sorted(metadata.keys(), key=lambda x: str(x)):
            v = metadata.get(k)
            lines.append(
                "INSERT INTO pdf_metadata (document_id, meta_key, meta_value) VALUES ("
                f"@doc_id, {_sql_value(k)}, {_sql_value(v)}"
                ");"
            )
        lines.append("")

    pages = text.get("pages") or []
    if isinstance(pages, list):
        for p in pages:
            if not isinstance(p, dict):
                continue
            page_number = p.get("page")
            page_text = p.get("text", "")
            char_count = p.get("char_count")
            word_count = p.get("word_count")
            lines.append(
                "INSERT INTO pdf_pages (document_id, page_number, text, char_count, word_count) VALUES ("
                f"@doc_id, {_sql_value(page_number)}, {_sql_value(page_text)}, {_sql_value(char_count)}, {_sql_value(word_count)}"
                ");"
            )
            images = p.get("images") or []
            if isinstance(images, list):
                for img in images:
                    if not isinstance(img, dict):
                        continue
                    lines.append(
                        "INSERT INTO pdf_images (document_id, page_number, image_index, name, file_path, bytes) VALUES ("
                        f"@doc_id, {_sql_value(page_number)}, {_sql_value(img.get('index'))}, {_sql_value(img.get('name'))}, {_sql_value(img.get('file'))}, {_sql_value(img.get('bytes'))}"
                        ");"
                    )

    sql_text = "\n".join(lines) + "\n"
    with open(sql_output_path, "w", encoding="utf-8", newline="\n") as f:
        f.write(sql_text)
    return os.path.abspath(sql_output_path)


def extract_pdf(
    input_path: str,
    extract_images: bool,
    images_dir: str | None,
    relpath_base_dir: str,
) -> dict:
    from pypdf import PdfReader

    reader = PdfReader(input_path)
    metadata = _jsonable(getattr(reader, "metadata", None))

    pages = []
    full_text_parts = []

    images_output_dir = None
    if extract_images:
        base = os.path.abspath(relpath_base_dir)
        target = images_dir or "images"
        images_output_dir = target if os.path.isabs(target) else os.path.join(base, target)
        os.makedirs(images_output_dir, exist_ok=True)

    for i, page in enumerate(reader.pages, start=1):
        text = None
        try:
            text = page.extract_text(extraction_mode="layout")
        except TypeError:
            text = page.extract_text()
        except Exception:
            try:
                text = page.extract_text()
            except Exception:
                text = None

        text = text or ""
        normalized = text.replace("\r\n", "\n").replace("\r", "\n")
        page_item = {
            "page": i,
            "text": normalized,
            "char_count": len(normalized),
            "word_count": len([w for w in normalized.split() if w.strip()]),
        }

        if images_output_dir is not None:
            images = []
            page_images = getattr(page, "images", None) or []
            for img_index, img in enumerate(page_images, start=1):
                img_name = getattr(img, "name", None) or f"page_{i:03d}_img_{img_index:03d}"
                ext = _infer_image_ext(str(img_name))
                img_name_str = str(img_name)
                if img_name_str.lower().endswith(f".{ext}"):
                    img_name_str = img_name_str[: -(len(ext) + 1)]
                safe_base = _safe_filename(
                    f"page_{i:03d}_img_{img_index:03d}_{img_name_str}"
                )
                filename = f"{safe_base}.{ext}"
                output_path = os.path.join(images_output_dir, filename)
                data = getattr(img, "data", None)
                if isinstance(data, (bytes, bytearray)):
                    with open(output_path, "wb") as f:
                        f.write(data)
                    images.append(
                        {
                            "index": img_index,
                            "name": str(img_name),
                            "file": os.path.relpath(output_path, os.path.abspath(relpath_base_dir)),
                            "bytes": len(data),
                        }
                    )
            page_item["images"] = images

        pages.append(page_item)
        if normalized.strip():
            full_text_parts.append(normalized)

    full_text = "\n\n\f\n\n".join(full_text_parts)

    return {
        "source": {
            "path": os.path.abspath(input_path),
            "filename": os.path.basename(input_path),
            "bytes": os.path.getsize(input_path),
            "extracted_at": _iso_utc_now(),
        },
        "data": {
            "page_count": len(reader.pages),
            "metadata": metadata,
            "image_count": sum(len(p.get("images", [])) for p in pages),
            "total_char_count": sum(p["char_count"] for p in pages),
            "total_word_count": sum(p["word_count"] for p in pages),
        },
        "text": {
            "full": full_text,
            "pages": pages,
        },
    }


def main() -> int:
    parser = argparse.ArgumentParser(
        description="Ekstrak metadata/teks dari PDF ke satu file JSON (opsional: gambar)."
    )
    parser.add_argument(
        "--input",
        default="harimau.pdf",
        help="Path PDF input (default: harimau.pdf)",
    )
    parser.add_argument(
        "--output",
        default="harimau_extracted.json",
        help="Path file output JSON (default: harimau_extracted.json)",
    )
    parser.add_argument(
        "--extract-images",
        action="store_true",
        help="Ekstrak objek gambar pada PDF (jika ada)",
    )
    parser.add_argument(
        "--images-dir",
        default="harimau_images",
        help="Folder output gambar (default: harimau_images)",
    )
    parser.add_argument(
        "--sql-output",
        default=None,
        help="Path file output SQL MySQL/MariaDB (contoh: harimau.sql)",
    )
    args = parser.parse_args()

    if not os.path.exists(args.input):
        raise FileNotFoundError(f"PDF tidak ditemukan: {args.input}")

    output_abs = os.path.abspath(args.output)
    output_dir = os.path.dirname(output_abs) or os.getcwd()
    if output_dir and not os.path.exists(output_dir):
        os.makedirs(output_dir, exist_ok=True)

    result = extract_pdf(
        args.input,
        extract_images=bool(args.extract_images),
        images_dir=args.images_dir if args.extract_images else None,
        relpath_base_dir=output_dir,
    )

    with open(output_abs, "w", encoding="utf-8") as f:
        json.dump(result, f, ensure_ascii=False, indent=2)
        f.write("\n")

    sql_abs = None
    if args.sql_output:
        sql_abs = export_mysql_sql(result, args.sql_output)

    print(f"OK: {output_abs}")
    if sql_abs:
        print(f"SQL: {sql_abs}")
    print(
        "pages=", result["data"]["page_count"],
        "chars=", result["data"]["total_char_count"],
        "words=", result["data"]["total_word_count"],
        sep="",
    )
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
