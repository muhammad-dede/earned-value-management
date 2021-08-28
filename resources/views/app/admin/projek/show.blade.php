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
                            @if ($projek->status->status == 'Belum Approve')
                                @if (auth()->user()->role->role == 'Super Admin' || auth()->user()->role->role == 'Direktur')
                                    <form action="{{ route('projek.update', $projek) }}" class="d-inline" role="alert"
                                        alert-title="Approve Projek" alert-text="Yakin ingin approve projek ini?"
                                        method="POST">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn btn-{{ $projek->status->color }}">Approve
                                            Projek</button>
                                    </form>
                                @endif
                            @elseif ($projek->status->status == 'Sudah Approve')
                                @if (auth()->user()->role->role == 'Super Admin' || auth()->user()->role->role == 'Manager')
                                    <form action="{{ route('projek.update', $projek) }}" class="d-inline" role="alert"
                                        alert-title="Start Project" alert-text="Projek akan dimulai?" method="POST">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn btn-{{ $projek->status->color }}">Mulai
                                            Pekerjaan</button>
                                    </form>
                                @endif
                            @elseif ($projek->status->status == 'Dalam Pengerjaan')
                                @if (auth()->user()->role->role == 'Super Admin' || auth()->user()->role->role == 'Manager')
                                    <form action="{{ route('projek.update', $projek) }}" class="d-inline" role="alert"
                                        alert-title="Projek Selesai" alert-text="Pengerjaan Sudah Selesai?" method="POST">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn btn-{{ $projek->status->color }}">Projek
                                            Selesai</button>
                                        <a href="{{ route('projek.tambah-surat-jalan', $projek) }}"
                                            class="btn btn-secondary">
                                            Upload Surat Jalan
                                        </a>
                                    </form>
                                @endif
                            @endif
                            @if ($projek->status->status == 'Dalam Pengerjaan' || $projek->status->status == 'Projek Selesai')
                                <a href="{{ route('print-pdf', $projek) }}" class="btn btn-outline-danger"
                                    target="_blank">Print PDF</a>
                            @endif
                            <a href="{{ route('projek.index') }}" class="btn btn-danger">Kembali</a>
                            {{-- <a href="{{ route('projek.index') }}" class="btn btn-danger float-sm-right">Kembali</a> --}}
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
                            <h5><i class="fas fa-info"></i> Status Projek:</h5>
                            <span
                                class="badge badge-{{ $projek->status->color }}">{{ $projek->status->status }}</span>
                        </div>
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> No Kontrak: {{ $projek->no_kontrak }}
                                        <small class="float-right">Tanggal Kontrak:
                                            {{ \Carbon\Carbon::parse($projek->tgl_kontrak)->translatedFormat('d F Y') }}</small>
                                    </h4>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <span class="border-bottom">Perusahan Vendor</span>
                                    <address>
                                        <strong>{{ $projek->vendor_pt->vendor }}</strong><br>
                                        Telepon: {{ $projek->vendor_pt->telp }}<br>
                                        Alamat: {{ $projek->vendor_pt->alamat }}<br>
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <span class="border-bottom">Kontrak</span>
                                    <address>
                                        <strong>{{ $projek->nama }}</strong><br>
                                        Tanggal Pekerjaan:
                                        {{ \Carbon\Carbon::parse($projek->tgl_mulai)->translatedFormat('d F Y') }} -
                                        {{ \Carbon\Carbon::parse($projek->tgl_selesai)->translatedFormat('d F Y') }}<br>
                                        Durasi Pengerjaan:
                                        {{ date_diff(date_create($projek->tgl_mulai), date_create($projek->tgl_selesai))->days }}&nbsp;hari<br>
                                        Nilai Kontrak: Rp. {{ number_format($projek->nilai_kontrak, 2, ',', '.') }}<br>
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    <span class="border-bottom">Penanggung Jawab</span>
                                    <address>
                                        <strong>{{ $projek->approve->nama }}</strong><br>
                                        File Izin Kerja: <a
                                            href="{{ asset('assets/projek') }}/{{ $projek->file_izin_kerja }}"
                                            target="_blank">{{ $projek->file_izin_kerja }}</a><br>
                                        File Kontrak: <a
                                            href="{{ asset('assets/projek') }}/{{ $projek->file_kontrak }}"
                                            target="_blank">{{ $projek->file_kontrak }}</a><br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>Pegawai</th>
                                                <th>Jabatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projek->projek_pegawai as $row)
                                                <tr class="text-center">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $row->pegawai->nama }}</td>
                                                    <td>{{ $row->pegawai->ref_jabatan->jabatan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($projek->status->status == 'Dalam Pengerjaan' || $projek->status->status == 'Projek Selesai')
                                <hr>
                                <div class="row">
                                    <div class="col-9">
                                        <h3>Laporan</h3>
                                    </div>
                                    <div class="col-3">
                                        <a href="{{ route('projek.kurva', $projek) }}"
                                            class="btn btn-primary btn-block float-right">Earned Value Analysis</a>
                                    </div>
                                </div>
                                <livewire:projek.proses :projek="$projek" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("form[role='alert']").submit(function(event) {
                event.preventDefault();
                Swal.fire({
                    title: $(this).attr('alert-title'),
                    text: $(this).attr('alert-text'),
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: "Batal",
                    reverseButtons: true,
                    confirmButtonText: "Ya",
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                });
            });
        });
    </script>
@endpush
