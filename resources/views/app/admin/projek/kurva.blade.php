@extends('layouts.app')
@push('styles')
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

    </style>
@endpush
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
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Progres Kinerja Projek: </h5>
                            <figure class="highcharts-figure">
                                <div id="kurva-s"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="callout callout-info">
                            <h5>Earned Value Analysis: </h5>
                            <figure class="highcharts-figure">
                                <div id="eva"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="callout callout-info">
                            <div class="row">
                                <div class="col-6">
                                    <h5>Keterangan: </h5>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>CV (Cost Varian)</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">Rp.
                                                    {{ number_format($projek->earned_value->sum('cv'), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SV (Schedule Varian)</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">Rp.
                                                    {{ number_format($projek->earned_value->sum('sv'), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>CPI (Cost Performance Index)</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ round($cpi, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>SPI (Shedule Performance Index)</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ round($spi, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>ETC (Estimate To Complete)</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ number_format($etc, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>EAC (Estimate At Complete)</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ number_format($eac, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>TE (Time Estimate)</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td class="font-weight-bold">
                                                    {{ round($te, 2) }} hari</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <p class="font-weight-bold">Note:</p>
                                    <ul>
                                        <li>{{ $projek->earned_value->sum('cv') >= 0 ? 'CV : Biaya Proyek Lebih Kecil Dari Rencana' : 'CV =  Biaya Proyek Lebih Besar Dari Rencana' }}
                                        </li>
                                        <li>{{ $projek->earned_value->sum('sv') >= 0 ? 'SV : Penyelesaian Proyek Tepat Waktu' : 'SV =  Penyelesaian Proyek Tidak Tepat Waktu' }}
                                        </li>
                                        <li>{{ $cpi >= 0 ? 'CPI : Biaya Proyek Lebih Kecil Dari Rencana' : 'CPI = Biaya Proyek Libih Besar Rencana' }}
                                        </li>
                                        <li>{{ $spi >= 1 ? 'SPI : Penyelesaian Proyek Tepat Waktu' : 'SPI = Penyelesaian Proyek Tidak Tepat Waktu' }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        Highcharts.chart('kurva-s', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Kurva S'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: {!! json_encode($categories) !!}
            },
            yAxis: {
                title: {
                    text: 'Persentase (%)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Progres Aktual',
                data: {!! json_encode($bobot_actual) !!}
            }, {
                name: 'Progres Schedule',
                data: {!! json_encode($bobot_schedule) !!}
            }]
        });
        Highcharts.chart('eva', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Earned Value Analysis'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: {!! json_encode($categories) !!}
            },
            yAxis: {
                title: {
                    text: 'Biaya (Rp)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'ACWP',
                data: {!! json_encode($acwp) !!}
            }, {
                name: 'BCWP',
                data: {!! json_encode($bcwp) !!}
            }, {
                name: 'BCWS',
                data: {!! json_encode($bcws) !!}
            }]
        });
    </script>
@endpush
