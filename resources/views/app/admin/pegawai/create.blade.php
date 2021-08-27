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
                        <a href="{{ route('pegawai.index') }}" class="btn btn-danger float-sm-right">Kembali</a>
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
                                <h3 class="card-title">Form Pegawai</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nama"><code>Nama</code></label>
                                        <input name="nama" type="text"
                                            class="form-control rounded-0 @error('nama') is-invalid @enderror" id="nama"
                                            value="{{ old('nama') }}">
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jk"><code>Jenis Kelamin</code></label>
                                        <select name="jk" id="jk"
                                            class="form-control rounded-0 @error('jk') is-invalid @enderror">
                                            <option value="" selected></option>
                                            <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('jk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_lahir"><code>Tempat Lahir</code></label>
                                        <input name="tempat_lahir" type="text"
                                            class="form-control rounded-0 @error('tempat_lahir') is-invalid @enderror"
                                            id="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                        @error('tempat_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_lahir"><code>Tanggal Lahir</code></label>
                                        <input name="tgl_lahir" type="date"
                                            class="form-control rounded-0 @error('tgl_lahir') is-invalid @enderror"
                                            id="tgl_lahir" value="{{ old('tgl_lahir') }}">
                                        @error('tgl_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat"><code>Alamat</code></label>
                                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                            id="alamat" cols="30" rows="3">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="id_jabatan"><code>Jabatan</code></label>
                                        <select name="id_jabatan" id="id_jabatan"
                                            class="form-control rounded-0 @error('id_jabatan') is-invalid @enderror">
                                            <option value="" selected></option>
                                            @foreach ($data_jabatan as $jabatan)
                                                <option value="{{ $jabatan->id_jabatan }}"
                                                    {{ old('id_jabatan') == $jabatan->id_jabatan ? 'selected' : '' }}>
                                                    {{ $jabatan->jabatan }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_jabatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="file_ktp"><code>KTP</code></label>
                                        <input name="file_ktp" type="file"
                                            class="form-control rounded-0 @error('file_ktp') is-invalid @enderror"
                                            id="file_ktp">
                                        @error('file_ktp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="file_asuransi"><code>Asuransi</code></label>
                                        <input name="file_asuransi" type="file"
                                            class="form-control rounded-0 @error('file_asuransi') is-invalid @enderror"
                                            id="file_asuransi">
                                        @error('file_asuransi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="file_foto"><code>Pass Foto</code></label>
                                        <input name="file_foto" type="file"
                                            class="form-control rounded-0 @error('file_foto') is-invalid @enderror"
                                            id="file_foto">
                                        @error('file_foto')
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
