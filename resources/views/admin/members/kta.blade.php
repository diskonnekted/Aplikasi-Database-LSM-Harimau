<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 0;
            size: 85.6mm 53.98mm;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #550000;
        }
        .card {
            width: 85.6mm;
            height: 53.98mm;
            position: relative;
            background-color: #550000; /* Dark Maroon */
            color: white;
            overflow: hidden;
        }
        
        .logo-section {
            text-align: center;
            padding-top: 10px;
        }
        .logo-img {
            width: 55px;
            height: 55px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .content {
            padding: 0 25px;
            margin-top: 25px;
        }
        
        .field-label {
            color: #cccccc;
            font-size: 7pt;
            margin-bottom: 2px;
        }
        .field-value {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .row {
            width: 100%;
            clear: both;
        }
        .col-left {
            float: left;
            width: 65%;
        }
        .col-right {
            float: right;
            width: 35%;
            text-align: right;
        }

        .signature-line {
            display: inline-block;
            width: 100%;
            border-bottom: 1.5pt solid white;
            margin-top: 15px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background-color: #fcd34d; /* Solid Gold/Yellow for better PDF support */
            text-align: center;
            line-height: 20px;
        }
        .footer-text {
            color: #3a0000;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo-section">
            <img src="{{ public_path('images/logo.png') }}" class="logo-img">
        </div>

        <div class="content">
            <div class="row">
                <div class="col-left">
                    <div class="field-label">Member Name</div>
                    <div class="field-value">{{ $member->full_name }}</div>
                    
                    <div class="field-label">Membership Validity Period</div>
                    <div class="field-value">SEUMUR HIDUP</div>
                </div>
                <div class="col-right">
                    <div class="field-label">ID Number</div>
                    <div class="field-value">{{ $member->kta_number ?? 'PENDING' }}</div>
                    
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="footer-text">LSM HARIMAU</div>
        </div>
    </div>
</body>
</html>