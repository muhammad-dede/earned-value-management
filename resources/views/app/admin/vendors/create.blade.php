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
                        <a href="{{ route('vendors.index') }}" class="btn btn-danger float-sm-right">Kembali</a>
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
                                <h3 class="card-title">Form Vendor</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('vendors.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="id_vendor_pt"><code>Perusahaan</code></label>
                                        <select name="id_vendor_pt" id="id_vendor_pt"
                                            class="form-control rounded-0 @error('id_vendor_pt') is-invalid @enderror">
                                            <option value="" selected></option>
                                            @foreach ($data_vendor_pt as $vendor_pt)
                                                <option value="{{ $vendor_pt->id_vendor_pt }}"
                                                    {{ old('id_vendor_pt') == $vendor_pt->id_vendor_pt ? 'selected' : '' }}>
                                                    {{ $vendor_pt->vendor }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_vendor_pt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
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
                                        <label for="telp"><code>Telepon</code></label>
                                        <input name="telp" type="text"
                                            class="form-control rounded-0 @error('telp') is-invalid @enderror" id="telp"
                                            value="{{ old('telp') }}">
                                        @error('telp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><code>Email</code></label>
                                        <input name="email" type="email"
                                            class="form-control rounded-0 @error('email') is-invalid @enderror" id="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><code>Password</code></label>
                                        <input name="password" type="password"
                                            class="form-control rounded-0 @error('password') is-invalid @enderror"
                                            id="password">
                                        @error('password')
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
