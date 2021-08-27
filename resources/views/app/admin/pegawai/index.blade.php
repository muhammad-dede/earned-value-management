@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('pegawai.create') }}"
                            class="btn btn-primary float-sm-right rounded-0">Tambah</a>
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
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Tempat, Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>KTP</th>
                                            <th>Asuransi</th>
                                            <th>Pass Foto</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_pegawai as $pegawai)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $pegawai->nama }}</strong> <br>
                                                    <small>Jabatan: {{ $pegawai->ref_jabatan->jabatan }}</small><br>
                                                    <small>Jenis Kelamin: {{ $pegawai->jk }}</small>
                                                </td>
                                                <td>{{ $pegawai->tempat_lahir }},&nbsp;
                                                    {{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->translatedFormat('d F Y') }}
                                                </td>
                                                <td>{{ $pegawai->alamat }}</td>
                                                <td>
                                                    <img src="{{ asset('assets/file-pegawai') }}/{{ $pegawai->file_ktp }}"
                                                        alt="ktp" class="img-fluid" style="height: 75px;">
                                                </td>
                                                <td>
                                                    <img src="{{ asset('assets/file-pegawai') }}/{{ $pegawai->file_asuransi }}"
                                                        alt="ktp" class="img-fluid" style="height: 75px;">
                                                </td>
                                                <td>
                                                    <img src="{{ asset('assets/file-pegawai') }}/{{ $pegawai->file_foto }}"
                                                        alt="ktp" class="img-fluid" style="height: 75px;">
                                                </td>
                                                <td>
                                                    <a href="{{ route('pegawai.edit', $pegawai) }}"
                                                        class="btn btn-warning btn-sm rounded-0">Edit</a>
                                                    <form action="{{ route('pegawai.destroy', $pegawai) }}"
                                                        class="d-inline" role="alert" alert-title="Hapus"
                                                        alert-text="Yakin ingin menghapus?" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-0">Hapus</button>
                                                    </form>
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
