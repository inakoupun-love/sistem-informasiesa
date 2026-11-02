<!DOCTYPE html>
<html lang="id">
@php
    $kades = \App\Models\User::where('role', 'kepala_desa')->first();
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Pengajuan - {{ $pengajuan->user->name ?? 'Pemohon' }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 21cm;
            min-height: 29.7cm;
            padding: 2cm;
            margin: 1cm auto;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            position: relative;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }
        .header-text h1, .header-text h2, .header-text h3 {
            margin: 0;
            font-weight: bold;
        }
        .header-text h1 { font-size: 14pt; }
        .header-text h2 { font-size: 16pt; }
        .header-text h3 { font-size: 18pt; letter-spacing: 1px; }
        .header-text p {
            margin: 0;
            font-size: 10pt;
        }
        .divider {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-bottom: 20px;
        }
        .surat-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .surat-title h4 {
            margin: 0;
            font-size: 14pt;
            text-decoration: underline;
            font-weight: bold;
        }
        .surat-title p {
            margin: 0;
            font-size: 12pt;
        }
        .content {
            margin-bottom: 30px;
            text-align: justify;
        }
        .content p {
            text-indent: 40px;
            margin-bottom: 15px;
        }
        table.biodata {
            width: 100%;
            margin-left: 40px;
            margin-bottom: 15px;
        }
        table.biodata td {
            vertical-align: top;
            padding-bottom: 5px;
        }
        table.biodata td:first-child {
            width: 200px;
        }
        table.biodata td:nth-child(2) {
            width: 20px;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            text-align: center;
        }
        .signature-box {
            width: 300px;
        }
        .signature-box .date {
            margin-bottom: 5px;
        }
        .signature-box .role {
            margin-bottom: 10px;
            font-weight: bold;
        }
        .signature-image {
            display: block;
            width: 180px;
            height: 60px;
            object-fit: contain;
            margin: 0 auto 0;
        }
        .signature-placeholder {
            height: 60px;
        }
        .signature-box .name {
            font-weight: bold;
            text-decoration: underline;
        }
        @media print {
            body { background: none; }
            .container {
                margin: 0;
                box-shadow: none;
                width: 100%;
                padding: 1cm;
            }
        }
        @media screen and (max-width: 800px) {
            .container {
                width: 100%;
                min-height: auto;
                padding: 16px;
                margin: 0 auto;
            }
            table.biodata {
                margin-left: 0;
            }
            table.biodata td:first-child {
                width: auto;
            }
            .signature-section {
                flex-wrap: wrap;
                justify-content: center;
                gap: 24px;
            }
            .signature-box {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body onload="window.print()">

<div class="container">
    <div class="header">
        <div class="header-text">
            <h1>PEMERINTAH KABUPATEN MINAHASA UTARA</h1>
            <h2>KECAMATAN KALAWAT</h2>
            <h3>DESA KALINAUN</h3>
            <p>Jl. Raya Desa No. 1, Kode Pos 95371 | Email: desakalinaun@gmail.com</p>
        </div>
    </div>
    
    <div class="divider"></div>

    <div class="surat-title">
        <h4>{{ strtoupper($pengajuan->jenisSurat->nama_surat ?? 'SURAT KETERANGAN') }}</h4>
        <p>Nomor: 003/SK/DESKAL/{{ date('Y') }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala Desa Kalinaun Kecamatan Kalawat Kabupaten Minahasa Utara, menerangkan dengan sesungguhnya bahwa:</p>

        <table class="biodata">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><strong>{{ strtoupper($pengajuan->user->name ?? '-') }}</strong></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $pengajuan->user->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tempat, Tgl Lahir</td>
                <td>:</td>
                <td>{{ $pengajuan->user->tempat_lahir ?? '-' }}, {{ $pengajuan->user->tanggal_lahir?->format('d-m-Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $pengajuan->user->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kewarganegaraan</td>
                <td>:</td>
                <td>Indonesia</td>
            </tr>
            <tr>
                <td>Pendidikan</td>
                <td>:</td>
                <td>{{ $pengajuan->user->pendidikan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $pengajuan->user->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nomor NIK / KTP</td>
                <td>:</td>
                <td>{{ $pengajuan->user->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $pengajuan->user->alamat ?? '-' }}</td>
            </tr>
        </table>

        <p>Adalah benar-benar penduduk Desa Kalinaun, Kecamatan Kalawat, Kabupaten Minahasa Utara dan saat ini yang bersangkutan berada di wilayah kami.</p>

        <p>Surat keterangan ini diberikan untuk keperluan <strong>{{ ucfirst($pengajuan->keperluan ?? '-') }}</strong>.</p>

        <p>Demikian surat keterangan ini dibuat dengan sebenar-benarnya dan hendaknya yang berkepentingan menjadikan periksa adanya.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <div class="date">&nbsp;</div>
            <div class="role">Pemegang Surat</div>
            <div class="name">{{ strtoupper($pengajuan->user->name ?? '-') }}</div>
            <div class="nik">NIK. {{ $pengajuan->user->nik ?? '-' }}</div>
        </div>
        <div class="signature-box">
            <div class="date">Kalinaun, {{ date('d F Y') }}</div>
            <div class="role">Kepala Desa Kalinaun</div>
            @if($kades?->signature_path)
                <img class="signature-image" src="{{ asset('storage/' . $kades->signature_path) }}" alt="Tanda tangan Kepala Desa">
            @else
                <div class="signature-placeholder"></div>
            @endif
            <div class="name">{{ $kades ? strtoupper($kades->name) : 'Bapak Siamto Ruyat' }}</div>
            <div class="nik">NIP. {{ $kades ? $kades->nik : '19700101 199803 1 001' }}</div>
        </div>
    </div>
</div>

</body>
</html>
