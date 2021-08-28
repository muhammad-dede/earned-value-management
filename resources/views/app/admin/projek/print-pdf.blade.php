<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Print PDF</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
</head>
<style type="text/css">
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background: rgb(204, 204, 204);
        font: 11pt "Times New Roman";
    }

    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .page {
        width: 210mm;
        min-height: 297mm;
        /* padding: 20mm; */
        padding-top: 5mm;
        padding-bottom: 5mm;
        padding-left: 10mm;
        padding-right: 10mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    @page {
        size: A4;
        margin: 0;
    }

    @media print {

        html,
        body {
            width: 210mm;
            height: 297mm;
        }

        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

    .column-1 {
        text-align: center;
        /* float: left; */
        max-width: 100%;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    img {
        width: 100%;
        /* height: 100px; */
    }

    .list {
        border: 0.1px solid #181717;
        margin-left: 17px;
        padding-left: 15px;
        padding-right: 15px;
    }

    .info {
        padding-left: 50px;
        padding-right: 50px;
        margin-bottom: 30px;
    }

    .pegawai {
        padding-left: 50px;
        padding-right: 50px;
    }

    footer {
        padding-left: 50px;
        padding-right: 50px;
        margin-top: 100px;
        text-align: right;
    }

    /* .footer {
        padding-left:
    } */

    .footer:after {
        content: "";
        display: table;
        clear: both;
    }

</style>

<body>
    <div class="print">
        <div class="page">
            <header>
                <div class="row">
                    <div class="column-1">
                        <img src="{{ asset('assets/kop-surat/kop.jpeg') }}" alt="logo">
                    </div>
                </div>
            </header>
            <section>
                <h2 style="text-align: center; text-decoration: underline; margin-top: 50px; margin-bottom: 30px;">
                    DAFTAR TENAGA KERJA</h2>
                <div class="info">
                    <table style="margin-left: auto; margin-right: auto;">
                        <tbody>
                            <tr>
                                <td>PEKERJAAN</td>
                                <td>&nbsp;:&nbsp;</td>
                                <td>{{ Str::upper($projek->nama) }}</td>
                            </tr>
                            <tr>
                                <td>NO KONTRAK</td>
                                <td>&nbsp;:&nbsp;</td>
                                <td>{{ Str::upper($projek->no_kontrak) }}</td>
                            </tr>
                            <tr>
                                <td>TANGGAL KONTRAK</td>
                                <td>&nbsp;:&nbsp;</td>
                                <td>{{ \Carbon\Carbon::parse($projek->tgl_kontrak)->translatedFormat('d F Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pegawai">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black;">NO</th>
                                <th style="border: 1px solid black;">NAMA</th>
                                <th style="border: 1px solid black;">JABATAN</th>
                                <th style="border: 1px solid black;">ASURANSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projek->projek_pegawai as $pegawai)
                                <tr style="padding: 2px;">
                                    <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}
                                    </td>
                                    <td style="border: 1px solid black;">{{ Str::upper($pegawai->pegawai->nama) }}
                                    </td>
                                    <td style="border: 1px solid black; text-align: center;">
                                        {{ Str::upper($pegawai->pegawai->ref_jabatan->jabatan) }}</td>
                                    <td style="border: 1px solid black; text-align: center;">
                                        <img src="{{ asset('assets/file-pegawai') }}/{{ $pegawai->pegawai->file_asuransi }}"
                                            alt="asuransi" style="height: 75px; width: 125px;">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <footer>
                <table>
                    <tbody>
                        <tr style="text-align:center;">
                            <td style="width: 65%"></td>
                            <td style="width: 35%;">
                                <div class="footer">
                                    <span>Cilegon,
                                        {{ \Carbon\Carbon::parse(now())->translatedFormat('d F Y') }}</span><br>
                                    <strong>PT. TRISTAN ENGINEERING</strong>
                                    <br><br><br><br><br><br>
                                    <strong
                                        style="text-decoration: underline;">{{ $projek->approve->nama }}</strong><br>
                                    <span>{{ $projek->approve->ref_jabatan->jabatan }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </footer>
        </div>
    </div>
</body>

</html>
{{-- <script type="text/javascript">
    window.print();
</script> --}}
