<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a wire:click.prevent="nav_schedule" class="nav-link {{ $nav == 'schedule' ? 'active' : '' }}"
                    id="schedule-tab" data-toggle="tab" href="#schedule" role="tab" aria-controls="schedule"
                    aria-selected="{{ $nav == 'schedule' ? 'true' : 'false' }}">Schedule</a>
            </li>
            <li class="nav-item" role="presentation">
                <a wire:click.prevent="nav_laporan" class="nav-link {{ $nav == 'laporan' ? 'active' : '' }}"
                    id="laporan-tab" data-toggle="tab" href="#laporan" role="tab" aria-controls="laporan"
                    aria-selected="{{ $nav == 'laporan' ? 'true' : 'false' }}">Laporan</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade {{ $nav == 'schedule' ? 'show active' : '' }}" id="schedule" role="tabpanel"
                aria-labelledby="schedule-tab">
                <div class="alert alert-info my-3">
                    Data rencana kerja yang akan dilaksanakan
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Pekerjaan</th>
                                <th>Tgl Mulai</th>
                                <th>Tgl Selesai</th>
                                <th>Durasi (Hari)</th>
                                <th>Biaya (Rp.)</th>
                                <th>Bobot Total</th>
                                <th>Bobot Hari</th>
                                <th>
                                    <button wire:click.prevent="tambah_schedule" type="button"
                                        class="btn btn-sm btn-success" data-toggle="modal" data-target="#scheduleModal">
                                        <i class="fas fa-plus-square"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data_schedule as $schedule)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $schedule->pekerjaan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->tgl_mulai)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->tgl_selesai)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ $schedule->durasi_hari }}</td>
                                    <td>{{ number_format($schedule->biaya, 0, ',', '.') }}</td>
                                    <td>{{ round($schedule->bobot_total, 2) }} %</td>
                                    <td>{{ round($schedule->bobot_hari, 2) }} %</td>
                                    <td>
                                        <button wire:click.prevent="ubah_schedule({{ $schedule }})"
                                            class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#scheduleModal"><i class="fas fa-info"></i></button>
                                        <button wire:click.prevent="hapus_schedule({{ $schedule }})"
                                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada plan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade {{ $nav == 'laporan' ? 'show active' : '' }}" id="laporan" role="tabpanel"
                aria-labelledby="laporan-tab">
                <div class="laporan-pekerjaan">
                    <div class="alert alert-info my-3">
                        Laporan Pekerjaan Projek
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Pekerjaan</th>
                                    <th>Tanggal</th>
                                    <th>
                                        <button wire:click.prevent="tambah_laporan" type="button"
                                            class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#laporanModal">
                                            Tambah
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_laporan_pekerjaan as $pekerjaan)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pekerjaan->schedule->pekerjaan }}</td>
                                        <td>{{ $pekerjaan->tgl }}</td>
                                        <td>
                                            <button wire:click.prevent="ubah_laporan({{ $pekerjaan }})"
                                                class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#laporanModal">Ubah</button>
                                            <a href="{{ route('projek.laporan-pengeluaran', $pekerjaan) }}"
                                                class="btn btn-sm btn-info">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada laporan pekerjaan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Schedule --}}
    <div wire:ignore.self class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">{{ $modal_schedule }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pekerjaan"><code>Nama Pekerjaan</code></label>
                        <input wire:model="pekerjaan" name="pekerjaan" type="text"
                            class="form-control rounded-0 @error('pekerjaan') is-invalid @enderror" id="pekerjaan">
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl_mulai"><code>Tanggal Mulai</code></label>
                        <input wire:model="tgl_mulai" name="tgl_mulai" type="date"
                            class="form-control rounded-0 @error('tgl_mulai') is-invalid @enderror" id="tgl_mulai">
                        @error('tgl_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl_selesai"><code>Tanggal Selesai</code></label>
                        <input wire:model="tgl_selesai" name="tgl_selesai" type="date"
                            class="form-control rounded-0 @error('tgl_selesai') is-invalid @enderror" id="tgl_selesai">
                        @error('tgl_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="biaya"><code>Biaya</code></label>
                        <input wire:model="biaya" name="biaya" type="number"
                            class="form-control rounded-0 @error('biaya') is-invalid @enderror" id="biaya">
                        @error('biaya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click.prevent="save_schedule" type="button" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Laporan --}}
    <div wire:ignore.self class="modal fade" id="laporanModal" tabindex="-1" aria-labelledby="laporanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="laporanModalLabel">{{ $modal_laporan }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_schedule"><code>Schedule</code></label>
                        <select wire:model="id_schedule" name="id_schedule" id="id_schedule"
                            class="form-control rounded-0 @error('id_schedule') is-invalid @enderror">
                            <option value=""></option>
                            @foreach ($data_schedule as $schedule)
                                <option value="{{ $schedule->id_schedule }}">{{ $schedule->pekerjaan }}</option>
                            @endforeach
                        </select>
                        @error('id_schedule')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl"><code>Tanggal</code></label>
                        <input wire:model="tgl" name="tgl" type="date"
                            class="form-control rounded-0 @error('tgl') is-invalid @enderror" id="tgl">
                        @error('tgl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jam_mulai"><code>Jam Mulai</code></label>
                        <input wire:model="jam_mulai" name="jam_mulai" type="time"
                            class="form-control rounded-0 @error('jam_mulai') is-invalid @enderror" id="jam_mulai">
                        @error('jam_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jam_selesai"><code>Jam Selesai</code></label>
                        <input wire:model="jam_selesai" name="jam_selesai" type="time"
                            class="form-control rounded-0 @error('jam_selesai') is-invalid @enderror" id="jam_selesai">
                        @error('jam_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bobot_actual"><code>Bobot Actual</code></label>
                        <input wire:model="bobot_actual" name="bobot_actual" type="number"
                            class="form-control rounded-0 @error('bobot_actual') is-invalid @enderror"
                            id="bobot_actual">
                        @error('bobot_actual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bobot_actual"><code>Keterangan</code></label>
                        <textarea wire:model="keterangan" name="keterangan" id="keterangan" cols="30" rows="3"
                            class="form-control rounded-0 @error('keterangan') is-invalid @enderror"></textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="foto">
                            <code>Foto Laporan</code>
                            &nbsp;|&nbsp; <button wire:click.prevent="tambah_laporan_foto"
                                class="btn btn-link btn-sm">Tambah Foto</button>
                        </label>
                        @foreach ($laporan_foto as $index => $foto)
                            @if ($foto['foto'] == null)
                                <div class="row mb-2">
                                    <div class="col-11">
                                        <input wire:model="laporan_foto.{{ $index }}.input_foto"
                                            name="laporan_foto[{{ $index }}][input_foto]" type="file"
                                            class="form-control rounded-0 @error('laporan_foto.' . $index . '.input_foto') is-invalid @enderror">
                                        @if ($errors->has('laporan_foto.' . $index . '.input_foto'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('laporan_foto.' . $index . '.input_foto') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-1">
                                        @if ($index > 0 && $foto['id_foto'] == null)
                                            <button wire:click.prevent="hapus_laporan_foto({{ $index }})"
                                                class="btn btn-danger">Hapus</button>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input wire:model="laporan_foto.{{ $index }}.input_foto"
                                            name="laporan_foto[{{ $index }}][input_foto]" type="file"
                                            class="form-control rounded-0 @error('laporan_foto.' . $index . '.input_foto') is-invalid @enderror">
                                        @if ($errors->has('laporan_foto.' . $index . '.input_foto'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('laporan_foto.' . $index . '.input_foto') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                        <a href="{{ asset('assets/laporan-foto') }}/{{ $foto['foto'] }}"
                                            target="_blank">{{ $foto['foto'] }}</a>
                                    </div>
                                    <div class="col-1">
                                        <button wire:click.prevent="hapus_laporan_foto({{ $index }})"
                                            class="btn btn-danger">Hapus</button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <label for="laporan-pengeluaran">
                        <code>Laporan Pengeluaran</code>
                    </label>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 50px;">#</th>
                                <th class="w-50">Rincian</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <th>Biaya</th>
                                <th>
                                    <button wire:click.prevent="tambah_laporan_pengeluaran"
                                        class="btn btn-sm btn-success">Tambah</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan_pengeluaran as $index => $row)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <input wire:model="laporan_pengeluaran.{{ $index }}.rincian"
                                            name="laporan_pengeluaran[{{ $index }}][rincian]" type="text"
                                            class="form-control @error('laporan_pengeluaran.' . $index . '.rincian') is-invalid @enderror">
                                        @if ($errors->has('laporan_pengeluaran.' . $index . '.rincian'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('laporan_pengeluaran.' . $index . '.rincian') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <select wire:model="laporan_pengeluaran.{{ $index }}.id_satuan"
                                            name="laporan_pengeluaran[{{ $index }}][id_satuan]"
                                            class="form-control @error('laporan_pengeluaran.' . $index . '.id_satuan') is-invalid @enderror">
                                            <option value=""></option>
                                            @foreach ($data_satuan as $satuan)
                                                <option value="{!! $satuan->id_satuan !!}"
                                                    wire:key="{{ $satuan->id_satuan }}">
                                                    {{ $satuan->satuan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('laporan_pengeluaran.' . $index . '.id_satuan'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('laporan_pengeluaran.' . $index . '.id_satuan') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <input wire:model="laporan_pengeluaran.{{ $index }}.qty"
                                            name="laporan_pengeluaran[{{ $index }}][qty]" type="number"
                                            class="form-control @error('laporan_pengeluaran.' . $index . '.qty') is-invalid @enderror">
                                        @if ($errors->has('laporan_pengeluaran.' . $index . '.qty'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('laporan_pengeluaran.' . $index . '.qty') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <input wire:model="laporan_pengeluaran.{{ $index }}.biaya"
                                            name="laporan_pengeluaran[{{ $index }}][biaya]" type="number"
                                            class="form-control @error('laporan_pengeluaran.' . $index . '.biaya') is-invalid @enderror">
                                        @if ($errors->has('laporan_pengeluaran.' . $index . '.biaya'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('laporan_pengeluaran.' . $index . '.biaya') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click.prevent="hapus_laporan_pengeluaran({{ $index }})"
                                            class="btn btn-sm btn-danger">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button wire:click.prevent="save_laporan" type="button" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            window.livewire.on('closeModal', () => {
                $('.modal').modal('hide').data('bs.modal', null);
            });
            window.addEventListener('swal', function(e) {
                Swal.fire(e.detail);
            });
        })
    </script>

@endpush
