@extends('layouts.administrator.master-v2')

@section('content')
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="accordion accordion-space" id="accordionExample2">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                            <span class="fw-bold">Detail Order</span>
                        </button>
                    </h2>
                    <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne1"
                        data-bs-parent="#accordionExample2" style="">
                        <div class="accordion-body">

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Tipe</th>
                                                    <td>
                                                        @if ($order->tipe == 0)
                                                            Biasa
                                                        @endif

                                                        @if ($order->tipe == 1)
                                                            Cito
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Unit Order</th>
                                                    <td>{{ $order->unit->nama_unit }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Dokter</th>
                                                    <td>{{ $order->dokter->nama_lengkap }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Nama OS</th>
                                                    <td>{{ str()->title($order->pasien->nama) ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Jenis Kelamin</th>
                                                    <td>{{ $order->pasien->jenis_kelamin == '0' ? 'Perempuan' : 'Laki-Laki' ?? '-' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>No RM</th>
                                                    <td>{{ $order->kd_pasien ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Alamat</th>
                                                    <td>{{ $order->pasien->alamat ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <th>No. HP</th>
                                                    <td>{{ $order->pasien->telepon ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr align="middle" class="bg-light">
                                                    <th colspan="2">DARAH LENGKAP (WHOLEBLOOD)</th>
                                                </tr>

                                                <tr>
                                                    <th>WB Segar/Biasa</th>
                                                    <td>{{ $order->wb ?? 0 }} ml</td>
                                                </tr>

                                                <tr align="middle" class="bg-light">
                                                    <th colspan="2">DARAH MERAHPEKAT (PACKED RED CELL)</th>
                                                </tr>

                                                <tr>
                                                    <th>PRC Biasa</th>
                                                    <td>{{ $order->prc ?? 0 }} ml</td>
                                                </tr>

                                                <tr>
                                                    <th>PRC Pediatric Leukodepleted</th>
                                                    <td>{{ $order->prc_pediactric ?? 0 }} ml</td>
                                                </tr>

                                                <tr>
                                                    <th>PRC Leukodepleted (dengan filter)</th>
                                                    <td>{{ $order->prc_leukodepleted ?? 0 }} ml</td>
                                                </tr>

                                                <tr>
                                                    <th>Washed Erythroyte (WE)</th>
                                                    <td>{{ $order->washed_erythroyte ?? 0 }} ml</td>
                                                </tr>

                                                <tr>
                                                    <th>Lain-lain</th>
                                                    <td>{{ $order->lainnya ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Waktu Pengambilan Sampel</th>
                                                    <td>{{ date('d M Y H:i', strtotime($order->waktu_pengambilan_sampel)) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Petugas</th>
                                                    <td>{{ $order->petugas_pengambilan_sampel }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Tgl Order</th>
                                                    <td>{{ date('d M Y', strtotime($order->tgl_pengiriman)) }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Tgl Diperlukan</th>
                                                    <td>{{ date('d M Y', strtotime($order->tgl_diperlukan)) }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Diagnosa Kimia</th>
                                                    <td>{{ $order->diagnosa_kimia }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Gol. Darah</th>
                                                    <td>{{ $order->golDarah->jenis }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Alasan Transfusi</th>
                                                    <td>{{ $order->alasan_transfusi }}</td>
                                                </tr>

                                                <tr>
                                                    <th>HB</th>
                                                    <td>{{ $order->hb }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Transfusi Sebelumnya</th>
                                                    <td>{{ $order->tranfusi_sebelumnya ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Gejala Reaksi Transfusi</th>
                                                    <td>{{ $order->reaksi_tranfusi ?? '-' }}</td>
                                                </tr>

                                                @if ($order->pasien->jenis_kelamin == 0)
                                                    <tr>
                                                        <th>Pernah Hamil</th>
                                                        <td>{{ $order->pernah_hamil ?? '-' }}</td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <th>Pernah Abortus</th>
                                                    <td>{{ $order->abortus_hdn || $order->abortus_hdn == 0 ? 'Tidak pernah' : 'Pernah' }}
                                                    </td>
                                                </tr>

                                                <tr align="middle" class="bg-light">
                                                    <th colspan="2">SEROLOGI</th>
                                                </tr>

                                                <tr>
                                                    <th>Tempat</th>
                                                    <td>{{ $order->serologi_dimana ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Waktu</th>
                                                    <td>{{ $order->serologi_kapan ?? '-' }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Hasil</th>
                                                    <td>{{ $order->serologi_hasil ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr align="middle" class="bg-light">
                                                    <th colspan="2">THROMBOCYTE CONCENTRATE (TC)</th>
                                                </tr>

                                                <tr>
                                                    <th>TC Biasa</th>
                                                    <td>{{ $order->tc_biasa ?? 0 }} unit</td>
                                                </tr>

                                                <tr>
                                                    <th>TC Apheresis</th>
                                                    <td>{{ $order->tc_apheresis ?? 0 }} unit</td>
                                                </tr>

                                                <tr>
                                                    <th>TC Pooled (Leukodepleted)</th>
                                                    <td>{{ $order->tc_pooled ?? 0 }} unit</td>
                                                </tr>

                                                <tr align="middle" class="bg-light">
                                                    <th colspan="2">PLASMA</th>
                                                </tr>

                                                <tr>
                                                    <th>Plasma Cair (liquid Palsma)</th>
                                                    <td>{{ $order->plasma_cair ?? 0 }} ml</td>
                                                </tr>

                                                <tr>
                                                    <th>Plasma Segar Beku (FFP)</th>
                                                    <td>{{ $order->plasma_segar_beku ?? 0 }} ml</td>
                                                </tr>

                                                <tr>
                                                    <th>Ciyoprecipitate AHF</th>
                                                    <td>{{ $order->ciyoprecipitate ?? 0 }} unit</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($order->status == 0)
                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#prosesModal">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                            Terima / Proses
                                        </button>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                @if ($order->status == 1 || $order->status == 2)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                                <span class="fw-bold">Penerimaan Sampel Darah</span>
                            </button>
                        </h2>
                        <div id="collapseTwo2" class="accordion-collapse collapse" aria-labelledby="headingTwo2"
                            data-bs-parent="#accordionExample2" style="">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Petugas Penerima</th>
                                                        <td>{{ $order->petugas_penerima_sampel ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Waktu Diterima</th>
                                                        <td>{{ date('d M Y', strtotime($order->tgl_terima_sampel)) . ' ' . date('H:i', strtotime($order->jam_terima_sampel)) }}
                                                            WIB</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ABO</th>
                                                        <td>{{ $order->abo }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Rhesus</th>
                                                        <td>{{ $order->rhesus->jenis ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                                <span class="fw-bold">Pemeriksaan dan Pemberian Darah</span>
                            </button>
                        </h2>
                        <div id="collapseThree3" class="accordion-collapse collapse" aria-labelledby="headingThree3"
                            data-bs-parent="#accordionExample2" style="">
                            <div class="accordion-body">
                                @if ($order->status == 1)
                                    <form
                                        action="{{ route('transfusi-darah.permintaan.handover', [encrypt($order->id)]) }}"
                                        method="post">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 mx-auto">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="petugas_pemeriksa">Petugas Pemeriksa</label>
                                                            <input type="text" name="petugas_pemeriksa"
                                                                id="petugas_pemeriksa" class="form-control" required>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="tgl_periksa">Tgl Periksa</label>
                                                            <input type="date" name="tgl_periksa" id="tgl_periksa"
                                                                class="form-control" value="{{ date('Y-m-d') }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="jam_periksa">Jam Periksa</label>
                                                            <input type="time" name="jam_periksa" id="jam_periksa"
                                                                class="form-control" value="{{ date('H:i') }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="hasil_pemeriksaan">Hasil Pemeriksaan</label>
                                                            <select name="hasil_pemeriksaan" id="hasil_pemeriksaan"
                                                                class="form-select" required>
                                                                <option value="">--Pilih--</option>
                                                                <option value="0">Tidak Cocok</option>
                                                                <option value="1">Cocok</option>
                                                                <option value="2">Tanpa Cross</option>
                                                                <option value="3">Emergency</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="petugas_ambil">Petugas yang mengambil</label>
                                                            <input type="text" name="petugas_ambil" id="petugas_ambil"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="produk-list-wrap">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div
                                                        class="card-header border-bottom d-flex justify-content-between align-items-center">
                                                        <p class="m-0 fww-semibold">Produk</p>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-group mt-3">
                                                            <label for="no_kantong">No. Kantong</label>
                                                            <input type="text" name="no_kantong[]" id="no_kantong"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="jenis_darah">Jenis Darah</label>
                                                            <select name="jenis_darah[]" id="jenis_darah"
                                                                class="form-select" required>
                                                                <option value="">--Pilih--</option>
                                                                <option value="1">WB</option>
                                                                <option value="2">PRC</option>
                                                                <option value="3">TC</option>
                                                                <option value="4">PLASMA</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label for="kd_golda">Gol. Darah</label>
                                                            <select name="kd_golda[]" id="kd_golda" class="form-select"
                                                                required>
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($golDarah as $gol)
                                                                    <option value="{{ $gol->kode }}">
                                                                        {{ $gol->jenis }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label for="tgl_pengambilan">Tanggal Pengambilan</label>
                                                            <input type="date" name="tgl_pengambilan[]"
                                                                id="tgl_pengambilan" class="form-control"
                                                                value="{{ date('Y-m-d') }}" required>
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label for="vol_kantong">Vol (ML) CC Kantong</label>
                                                            <input type="number" name="vol_kantong[]" id="vol_kantong"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <button type="button" class="btn btn-success" id="btn-add-produk-list">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                @if ($order->status == 2)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Petugas Pemeriksa</th>
                                                        <td>{{ $order->petugas_pemeriksa ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Waktu Periksa</th>
                                                        <td>
                                                            {{ date('d M Y', strtotime($order->tgl_periksa)) . ' ' . date('H:i', strtotime($order->jam_periksa)) }}
                                                            WIB
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Hasil Pemeriksaan</th>
                                                        <td>
                                                            @if ($order->hasil_pemeriksaan == 0)
                                                                Tidak Cocok
                                                            @endif

                                                            @if ($order->hasil_pemeriksaan == 1)
                                                                Cocok
                                                            @endif

                                                            @if ($order->hasil_pemeriksaan == 2)
                                                                Tanpa Cross
                                                            @endif

                                                            @if ($order->hasil_pemeriksaan == 3)
                                                                Emergency
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Petugas yang Mengambil</th>
                                                        <td>{{ $order->petugas_ambil }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr align="middle">
                                                        <th>No</th>
                                                        <th>No Kantong</th>
                                                        <th>Jenis Darah</th>
                                                        <th>Gol. Darah</th>
                                                        <th>Tanggal Pengambilan</th>
                                                        <th>Vol (ML) CC Kantong</th>
                                                    </tr>

                                                    @foreach ($order->detail as $detail)
                                                        <tr>
                                                            <td align="middle">{{ $loop->iteration }}</td>
                                                            <td align="middle">{{ $detail->no_kantong ?? '-' }}</td>
                                                            <td align="middle">
                                                                @if ($detail->jenis_darah == 1)
                                                                    WB
                                                                @endif

                                                                @if ($detail->jenis_darah == 2)
                                                                    PRC
                                                                @endif

                                                                @if ($detail->jenis_darah == 3)
                                                                    TC
                                                                @endif

                                                                @if ($detail->jenis_darah == 4)
                                                                    PLASMA
                                                                @endif
                                                            </td>
                                                            <td align="middle">{{ $detail->golDarah->jenis ?? '-' }}</td>
                                                            <td align="middle">
                                                                {{ date('d M Y', strtotime($detail->tgl_pengambilan)) }}
                                                            </td>
                                                            <td align="middle">{{ $detail->vol_kantong }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>


    <!-- Prosess Modal -->
    <div class="modal fade" id="prosesModal" tabindex="-1" aria-labelledby="prosesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="prosesModalLabel">Penerimaan Sampel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('transfusi-darah.permintaan.proses', [encrypt($order->id)]) }}" method="post">
                    @csrf
                    @method('put')

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="petugas_penerima_sampel">Petugas Penerima</label>
                            <input type="text" name="petugas_penerima_sampel" id="petugas_penerima_sampel"
                                class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="tgl_terima_sampel">Tgl Penerimaan Sampel</label>
                            <input type="date" name="tgl_terima_sampel" id="tgl_terima_sampel" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="jam_terima_sampel">Jam Penerimaan Sampel</label>
                            <input type="time" name="jam_terima_sampel" id="jam_terima_sampel" class="form-control"
                                value="{{ date('H:i') }}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="abo">ABO</label>
                            <input type="text" name="abo" id="abo" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="kd_rhesus">Rhesus</label>
                            <select name="kd_rhesus" id="kd_rhesus" class="form-select" required>
                                <option value="">--Pilih--</option>
                                <option value="0">Negatif</option>
                                <option value="1">Positif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Proses</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#btn-add-produk-list').on('click', function() {
            // Clone the original card row
            var $originalRow = $('#produk-list-wrap .col-md-6:first-of-type');
            var $newRow = $originalRow.clone();

            // Add delete button to the cloned card
            var $deleteBtn = $(
                '<button type="button" class="btn btn-sm btn-danger mt-2"><i class="fa-solid fa-trash"></i></button>'
            );
            $newRow.find('.card-header').append($deleteBtn);

            // Add click event to delete button
            $deleteBtn.on('click', function() {
                $(this).closest('.col-md-6').remove();
            });

            // Reset form values in the cloned card
            $newRow.find('input, select').each(function() {
                var $input = $(this);
                if ($input.attr('type') === 'date') {
                    $input.val(new Date().toISOString().split('T')[0]); // Set current date
                } else {
                    $input.val(''); // Clear other inputs
                }
            });

            // Generate unique IDs for form elements in the clone
            var timestamp = new Date().getTime();
            $newRow.find('input, select').each(function() {
                var $input = $(this);
                var originalId = $input.attr('id');
                var newId = originalId + '_' + timestamp;

                // Update ID
                $input.attr('id', newId);

                // Update corresponding label
                $newRow.find('label[for="' + originalId + '"]').attr('for', newId);

                // Update name attribute to make it an array
                var originalName = $input.attr('name');
                $input.attr('name', originalName);
            });

            // Insert the cloned row after the original row
            // $newRow.append($originalRow);
            $('#produk-list-wrap').append($newRow);
        });
    </script>
@endpush
