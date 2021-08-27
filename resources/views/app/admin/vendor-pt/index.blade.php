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
                        <a href="{{ route('vendor-pt.create') }}"
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
                                            <th>Vendor</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
                                            <th>Logo</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_vendor_pt as $vendor_pt)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $vendor_pt->vendor }}</strong>
                                                </td>
                                                <td>{{ $vendor_pt->alamat }}</td>
                                                <td>{{ $vendor_pt->telp }}</td>
                                                <td>
                                                    <img src="{{ asset('assets/vendor-pt') }}/{{ $vendor_pt->logo }}"
                                                        alt="ktp" class="img-fluid" style="height: 75px;">
                                                </td>
                                                <td>
                                                    <a href="{{ route('vendor-pt.edit', $vendor_pt) }}"
                                                        class="btn btn-warning btn-sm rounded-0">Edit</a>
                                                    <form action="{{ route('vendor-pt.destroy', $vendor_pt) }}"
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
