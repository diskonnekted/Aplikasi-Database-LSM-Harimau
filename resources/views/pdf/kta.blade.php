<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KTA LSM Harimau</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }
        .card {
            width: 85.6mm;
            height: 53.98mm;
            border: 1px solid #000;
            border-radius: 8px;
            position: relative;
            background: linear-gradient(135deg, #cc0000 0%, #000000 100%);
            color: white;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .header {
            padding: 10px;
            display: flex;
            align-items: center;
        }
        .logo {
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
        }
        .content {
            padding: 0 15px;
            position: relative;
            z-index: 2;
        }
        .photo {
            position: absolute;
            right: 15px;
            top: 45px;
            width: 80px;
            height: 100px;
            background: #fff;
            border: 2px solid white;
        }
        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .details {
            margin-top: 10px;
            font-size: 10px;
            width: 65%;
        }
        .details div {
            margin-bottom: 4px;
        }
        .label {
            color: #ccc;
            font-size: 8px;
        }
        .value {
            font-weight: bold;
            font-size: 11px;
        }
        .footer {
            position: absolute;
            bottom: 10px;
            left: 15px;
            font-size: 8px;
            color: #ddd;
        }
        .card-back {
            background: white;
            color: black;
            border: 1px solid #000;
        }
        .back-content {
            padding: 15px;
            font-size: 8px;
            text-align: center;
            position: relative;
        }
        .qrcode {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="logo">LSM HARIMAU</div>
        </div>
        
        <div class="photo">
            @if($member->image_path)
                <img src="{{ public_path('storage/' . $member->image_path) }}" alt="Photo">
            @endif
        </div>

        <div class="content">
            <div class="details">
                <div>
                    <div class="label">NAMA</div>
                    <div class="value">{{ strtoupper($member->full_name) }}</div>
                </div>
                <div>
                    <div class="label">NOMOR KTA</div>
                    <div class="value">{{ $member->kta_number }}</div>
                </div>
                <div>
                    <div class="label">WILAYAH</div>
                    <div class="value">{{ strtoupper($member->region->name) }}</div>
                </div>
            </div>


        <div class="footer">
            KARTU TANDA ANGGOTA
        </div>
    </div>

    <div class="card card-back">
        <div class="back-content">
            <h3>VISI MISI LSM HARIMAU</h3>
            <p>1. Menjaga kedaulatan NKRI.</p>
            <p>2. Membantu masyarakat dalam bidang sosial dan hukum.</p>
            <br>
            <p><strong>KETENTUAN:</strong></p>
            <p>Kartu ini adalah milik LSM Harimau. Jika ditemukan harap dikembalikan ke sekretariat terdekat.</p>
            
            <div class="qrcode">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(80)->generate(route('public.member.verify', $member->uuid))) }} " alt="QR Code">
                <br>
                <span style="font-size: 7px;">Scan untuk validasi anggota</span>
            </div>
        </div>
    </div>
</body>
</html>
