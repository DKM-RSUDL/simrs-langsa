<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Pengantar Rawat Inap</title>
  <style>
    @page {
      size: A4;
      margin: 2.5cm 2cm;
    }

    body {
      font-family: "Times New Roman", serif;
      font-size: 12pt;
      line-height: 1.4;
      color: #000;
    }

    .header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .header img {
      width: 70px;
      height: 70px;
    }

    .header-text {
      flex-grow: 1;
      text-align: center;
    }

    .header-text h2 {
      margin: 0;
      font-size: 16pt;
      font-weight: bold;
    }

    .header-text p {
      margin: 0;
      font-size: 11pt;
    }

    .document-no {
      text-align: right;
      font-size: 11pt;
      margin-bottom: 10px;
    }

    .title {
      text-align: center;
      font-weight: bold;
      font-size: 14pt;
      text-decoration: underline;
      margin-bottom: 15px;
    }

    .flex {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
    }

    .label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }

    .textarea {
      border: 1px solid #000;
      height: 80px;
      margin-bottom: 15px;
    }

    .signature {
      text-align: left;
      margin-top: 30px;
    }

    .footer {
      text-align: center;
      font-weight: bold;
      font-size: 13pt;
      margin-top: 40px;
      border-top: 2px solid #000;
      padding-top: 10px;
    }
  </style>
</head>
<body>

  <div class="header">
    <img src="logo-rs.png" alt="Logo Rumah Sakit">
    <div class="header-text">
      <h2>RUMAH SAKIT UMUM DAERAH SEHAT SELALU</h2>
      <p>Jl. Kesehatan No.10, Jakarta • Telp. (021) 555-1234</p>
    </div>
  </div>

  <div class="document-no">No: A.4/IRM/Rev 0/2017</div>

  <div class="title">PENGANTAR</div>

  <div class="flex">
    <div>Kepada Admision Center</div>
    <div>Tanggal Masuk: __________________</div>
  </div>

  <div class="section">
    <span class="label">DOKTER:</span>
    <div class="textarea"></div>
    <div>Nama terang dan ttd</div>
  </div>

  <div class="section">
    <span class="label">Keluhan utama dari riwayat penyakit (yang positif):</span>
    <div class="textarea"></div>
  </div>

  <div class="section">
    <span class="label">Pemeriksaan fisik dan laboratorium (yang positif):</span>
    <div class="textarea"></div>
  </div>

  <div class="section">
    <span class="label">Jalannya penyakit selama perawatan (konsultasi / pemeriksaan khusus):</span>
    <div class="textarea"></div>
  </div>

  <div class="section">
    <span class="label">Diagnosa kerja (satu atau lebih):</span>
    <div class="textarea"></div>
  </div>

  <div class="section">
    <span class="label">Tindakan / terapi yang telah diberikan:</span>
    <div class="textarea"></div>
  </div>

  <div class="section">
    <span class="label">Anjuran:</span>
    <div class="textarea"></div>
  </div>

  <div class="footer">RAWAT INAP</div>

</body>
</html>
