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
                        <a href="{{ URL::previous() }}" class="btn btn-danger float-sm-right">Kembali</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Form Surat</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('projek.update-surat-jalan', $surat_jalan) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label for="keterangan"><code>Keterangan</code></label>
                                        <textarea name="keterangan" id="keterangan" cols="30" rows="3"
                                            class="form-control rounded-0 @error('keterangan') is-invalid @enderror">{{ $surat_jalan->keterangan }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_surat"><code>Tanggal</code></label>
                                        <input name="tgl_surat" type="date"
                                            class="form-control rounded-0 @error('tgl_surat') is-invalid @enderror"
                                            id="tgl_surat" value="{{ $surat_jalan->tgl_surat }}">
                                        @error('tgl_surat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="file_surat"><code>File Surat</code></label>
                                        <input name="file_surat" type="file" accept="application/pdf"
                                            class="form-control rounded-0 @error('file_surat') is-invalid @enderror"
                                            id="file_surat">
                                        @error('file_surat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-0">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
