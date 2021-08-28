@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No Kontrak</th>
                                            <th>Nama Projek</th>
                                            <th>Tanggal Kontrak</th>
                                            <th>Nilai Kontrak</th>
                                            <th>Direktur</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_projek as $projek)
                                            <tr class="text-center">
                                                <td>
                                                    <strong>{{ $projek->no_kontrak }}</strong> <br>
                                                </td>
                                                <td>{{ $projek->nama }}</td>
                                                <td>{{ \Carbon\Carbon::parse($projek->tgl_kontrak)->translatedFormat('d F Y') }}
                                                </td>
                                                <td>Rp. {{ number_format($projek->nilai_kontrak, 0, ',', '.') }}</td>
                                                <td>{{ $projek->approve->nama }}</td>
                                                <td>
                                                    <span
                                                        class="text-{{ $projek->status->color }}">{{ $projek->status->status }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
