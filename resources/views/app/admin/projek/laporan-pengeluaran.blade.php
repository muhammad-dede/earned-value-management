@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-8">
                        <div class="float-sm-right">
                            <a href="{{ URL::previous() }}" class="btn btn-danger">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice p-3 mb-3">
                            <div class="row my-2">
                                <div class="col-12">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>Tanggal Pengerjaan</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($laporan_pekerjaan->tgl)->translatedFormat('d F Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jam Mulai</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ $laporan_pekerjaan->jam_mulai }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jam Selesai</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ $laporan_pekerjaan->jam_mulai }}</td>
                                            </tr>
                                            <tr>
                                                <td>Keterangan</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ $laporan_pekerjaan->keterangan }}</td>
                                            </tr>
                                            <tr>
                                                <td>Bobot Actual</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ round($laporan_pekerjaan->bobot_actual, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Bobot Schedule</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ round($laporan_pekerjaan->bobot_schedule, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (auth()->user()->role->role !== 'Vendor')
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>#</th>
                                                    <th>Rincian</th>
                                                    <th>Satuan</th>
                                                    <th>Qty</th>
                                                    <th>Biaya</th>
                                                    <th>Total Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data_laporan_pengeluaran as $pengeluaran)
                                                    <tr class="text-center">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $pengeluaran->rincian }}</td>
                                                        <td>{{ $pengeluaran->ref_satuan->satuan }}</td>
                                                        <td>{{ $pengeluaran->qty }}</td>
                                                        <td>{{ $pengeluaran->biaya }}</td>
                                                        <td>{{ $pengeluaran->total_biaya }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Bukti Pekerjaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td>
                                                    @foreach ($laporan_pekerjaan->laporan_foto as $laporan_foto)
                                                        <a href="{{ asset('assets/laporan-foto') }}/{{ $laporan_foto->foto }}"
                                                            target="_blank">
                                                            <img src="{{ asset('assets/laporan-foto') }}/{{ $laporan_foto->foto }}"
                                                                alt="bukti" class="img-fluid mx-3" style="height: 200px;">
                                                        </a>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
