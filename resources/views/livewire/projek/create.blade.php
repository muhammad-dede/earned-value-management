<div class="card-body">
    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_kontrak"><code>No Kontrak</code></label>
                    <input wire:model="no_kontrak" name="no_kontrak" type="text"
                        class="form-control rounded-0 @error('no_kontrak') is-invalid @enderror" id="no_kontrak"
                        value="{{ old('no_kontrak') }}">
                    @error('no_kontrak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama"><code>Nama Projek</code></label>
                    <input wire:model="nama" name="nama" type="text"
                        class="form-control rounded-0 @error('nama') is-invalid @enderror" id="nama"
                        value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="id_vendor_pt"><code>Vendor</code></label>
            <select wire:model="id_vendor_pt" name="id_vendor_pt" id="id_vendor_pt"
                class="form-control rounded-0 @error('id_vendor_pt') is-invalid @enderror" style="width: 100%;">
                <option value="" selected></option>
                @foreach ($data_vendor_pt as $vendor)
                    <option value="{{ $vendor->id_vendor_pt }}">
                        {{ $vendor->vendor }}</option>
                @endforeach
            </select>
            @error('id_vendor_pt')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tgl_kontrak"><code>Tanggal Kontrak</code></label>
                    <input wire:model="tgl_kontrak" name="tgl_kontrak" type="date"
                        class="form-control rounded-0 @error('tgl_kontrak') is-invalid @enderror" id="tgl_kontrak"
                        value="{{ old('tgl_kontrak') }}">
                    @error('tgl_kontrak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tgl_mulai"><code>Tanggal Mulai</code></label>
                    <input wire:model="tgl_mulai" name="tgl_mulai" type="date"
                        class="form-control rounded-0 @error('tgl_mulai') is-invalid @enderror" id="tgl_mulai"
                        value="{{ old('tgl_mulai') }}">
                    @error('tgl_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tgl_selesai"><code>Tanggal Selesai</code></label>
                    <input wire:model="tgl_selesai" name="tgl_selesai" type="date"
                        class="form-control rounded-0 @error('tgl_selesai') is-invalid @enderror" id="tgl_selesai"
                        value="{{ old('tgl_selesai') }}">
                    @error('tgl_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="durasi_kontrak"><code>Durasi Kontrak</code></label>
                    <input wire:model="durasi_kontrak" name="durasi_kontrak" type="number"
                        class="form-control rounded-0 @error('durasi_kontrak') is-invalid @enderror"
                        id="durasi_kontrak">
                    @error('durasi_kontrak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nilai_kontrak"><code>Nilai Kontrak</code></label>
                    <input wire:model="nilai_kontrak" name="nilai_kontrak" type="number"
                        class="form-control rounded-0 @error('nilai_kontrak') is-invalid @enderror" id="nilai_kontrak">
                    @error('nilai_kontrak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="file_izin_kerja"><code>File Izin Kerja</code></label>
                    <input wire:model="file_izin_kerja" name="file_izin_kerja" type="file"
                        class="form-control rounded-0 @error('file_izin_kerja') is-invalid @enderror"
                        id="file_izin_kerja">
                    @error('file_izin_kerja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="file_kontrak"><code>File Kontrak</code></label>
                    <input wire:model="file_kontrak" name="file_kontrak" type="file"
                        class="form-control rounded-0 @error('file_kontrak') is-invalid @enderror" id="file_kontrak">
                    @error('file_kontrak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="approved_by"><code>Disetujui Oleh</code></label>
            <select wire:model="approved_by" name="approved_by" id="approved_by"
                class="form-control rounded-0 @error('approved_by') is-invalid @enderror">
                <option value="" selected></option>
                @foreach ($data_pegawai as $pegawai)
                    <option value="{{ $pegawai->id_pegawai }}"
                        {{ old('approved_by') == $pegawai->id_pegawai ? 'selected' : '' }}>
                        {{ $pegawai->nama }}</option>
                @endforeach
            </select>
            @error('approved_by')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <hr>
        <label>Pegawai Projek</label>
        <table class="table table-bordered">
            <thead>
                <tr class="text-center">
                    <th style="width: 50px;">#</th>
                    <th class="w-75">Pegawai</th>
                    <th>
                        <button wire:click.prevent="tambah_pegawai" class="btn btn-sm btn-success">Tambah</button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projek_pegawai as $index => $row)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <select wire:model="projek_pegawai.{{ $index }}.id_pegawai"
                                name="projek_pegawai[{{ $index }}][id_pegawai]"
                                id="projek_pegawai[{{ $index }}][id_pegawai]"
                                class="form-control @error('projek_pegawai.' . $index . '.id_pegawai') is-invalid @enderror">
                                <option value=""></option>
                                @foreach ($data_projek_pegawai as $pegawai)
                                    <option value="{{ $pegawai->id_pegawai }}">{{ $pegawai->nama }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('projek_pegawai.' . $index . '.id_pegawai'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('projek_pegawai.' . $index . '.id_pegawai') }}</div>
                            @endif
                        </td>
                        <td>
                            <button wire:click.prevent="hapus_pegawai({{ $index }})"
                                class="btn btn-sm btn-danger">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button wire:click.prevent="save" class="btn btn-primary rounded-0">Simpan</button>
    </form>
</div>

@push('scripts')
    <script>
        $(document).on('livewire:load', function() {
            $('#id_vendor').select2({
                placeholder: "",
                theme: "bootstrap4"
            });
            $('#approved_by').select2({
                placeholder: "",
                theme: "bootstrap4"
            });

            $('#id_vendor').on('change', function() {
                @this.id_vendor = $(this).val();
            });
            $('#approved_by').on('change', function() {
                @this.approved_by = $(this).val();
            });


            Livewire.hook('message.processed', (message, component) => {
                $('#id_vendor').select2({
                    theme: "bootstrap4"
                })
                $('#approved_by').select2({
                    theme: "bootstrap4"
                })
            });
        });
    </script>
@endpush
