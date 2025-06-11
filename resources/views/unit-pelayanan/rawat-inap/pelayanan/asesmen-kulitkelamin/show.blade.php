@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="header-asesmen">Asesmen Medis Kulit dan Kelamin</h4>
                                        <p class="mb-0">
                                            Detail asesmen medis kulit dan kelamin pasien
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('rawat-inap.asesmen.medis.kulit-kelamin.edit', [
                                            'kd_unit' => $kd_unit,
                                            'kd_pasien' => $kd_pasien,
                                            'tgl_masuk' => $tgl_masuk,
                                            'urut_masuk' => $urut_masuk,
                                            'id' => $asesmen->id,
                                        ]) }}"
                                            class="btn btn-warning">
                                            <i class="ti-pencil"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-3">
                            <!-- 1. Data Masuk -->
                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data Masuk</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Tanggal Dan Jam Masuk</label>
                                        <p>{{ Carbon\Carbon::parse($asesmenKulitKelamin->waktu_masuk)->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kondisi Masuk</label>
                                        <p>{{ $asesmenKulitKelamin->kondisi_masuk ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Diagnosis Masuk</label>
                                        <p>{{ $asesmenKulitKelamin->diagnosis_masuk ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Anamnesis -->
                            <div class="section-separator" id="anamnesis">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Anamnesis</label>
                                        <p>{{ $asesmen->anamnesis ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Keluhan Utama/Alasan Masuk RS</label>
                                        <p class="text-justify">{{ $asesmenKulitKelamin->keluhan_utama ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Riwayat Kesehatan -->
                            <div class="section-separator" id="riwayat-kesehatan">
                                <h5 class="section-title">3. Riwayat Kesehatan</h5>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Penyakit Sekarang</label>
                                        <p class="text-justify">{{ $asesmenKulitKelamin->riwayat_penyakit_sekarang ?: '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Penyakit Terdahulu</label>
                                        <p>{{ $asesmenKulitKelamin->riwayat_penyakit_terdahulu ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Kesehatan Keluarga</label>
                                        @php
                                            $riwayatKeluarga = json_decode(
                                                $asesmenKulitKelamin->riwayat_penyakit_keluarga ?? '[]',
                                                true,
                                            );
                                        @endphp
                                        @if (!empty($riwayatKeluarga) && is_array($riwayatKeluarga) && count($riwayatKeluarga) > 0)
                                            <ol class="ps-3">
                                                @foreach ($riwayatKeluarga as $riwayat)
                                                    <li>{{ $riwayat }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada riwayat kesehatan keluarga</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Riwayat Penggunaan Obat -->
                            <div class="section-separator" id="riwayat-obat">
                                <h5 class="section-title">4. Riwayat Penggunaan Obat</h5>

                                @if (!empty($riwayatPenggunaanObat) && count($riwayatPenggunaanObat) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Obat</th>
                                                    <th>Dosis</th>
                                                    <th>Aturan Pakai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($riwayatPenggunaanObat as $index => $obat)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $obat['namaObat'] ?? '-' }}</td>
                                                        <td>{{ ($obat['dosis'] ?? '-') . ' ' . ($obat['satuan'] ?? '') }}
                                                        </td>
                                                        <td>
                                                            {{ $obat['frekuensi'] ?? '-' }}
                                                            @if (isset($obat['keterangan']) && $obat['keterangan'])
                                                                ({{ $obat['keterangan'] }})
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada riwayat penggunaan obat</p>
                                @endif
                            </div>

                            <!-- 5. Alergi -->
                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">5. Alergi</h5>

                                @if ($alergiPasien->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Jenis Alergi</th>
                                                    <th>Alergen</th>
                                                    <th>Reaksi</th>
                                                    <th>Tingkat Keparahan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($alergiPasien as $index => $alergi)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $alergi->jenis_alergi }}</td>
                                                        <td>{{ $alergi->nama_alergi }}</td>
                                                        <td>{{ $alergi->reaksi }}</td>
                                                        <td>{{ $alergi->tingkat_keparahan }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada data alergi</p>
                                @endif
                            </div>

                            <!-- 6. Pemeriksaan Fisik -->
                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">6. Pemeriksaan Fisik</h5>

                                <div class="row">
                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                        <div class="col-md-6">
                                            @foreach ($chunk as $item)
                                                <div class="border-bottom py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">{{ $item->nama }}</span>
                                                        @php
                                                            $pemeriksaan = $pemeriksaanFisik->get($item->id);
                                                        @endphp
                                                        @if ($pemeriksaan)
                                                            @if ($pemeriksaan->is_normal)
                                                                <span class="badge bg-success">Normal</span>
                                                            @else
                                                                <span class="badge bg-warning">Tidak Normal</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-secondary">Tidak Diperiksa</span>
                                                        @endif
                                                    </div>
                                                    @if ($pemeriksaan && !$pemeriksaan->is_normal && $pemeriksaan->keterangan)
                                                        <p class="text-muted mt-2 mb-0">{{ $pemeriksaan->keterangan }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 6.1. Site Marking - Penandaan Anatomi -->
                            @if (isset($asesmenKulitKelamin->site_marking_data) &&
                                    !empty($asesmenKulitKelamin->site_marking_data) &&
                                    $asesmenKulitKelamin->site_marking_data !== '[]')
                                <div class="section-separator" id="site-marking">
                                    <h5 class="section-title">6.1. Site Marking - Penandaan Anatomi</h5>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="site-marking-container position-relative">
                                                <img src="{{ asset('assets/images/sitemarking/kulit-kelamin.png') }}"
                                                    id="anatomyImageShow" class="img-fluid" style="max-width: 100%;">
                                                <canvas id="markingCanvasShow" class="position-absolute top-0 start-0"
                                                    style="z-index: 10; pointer-events: none;">
                                                </canvas>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="ti-info"></i> Penandaan anatomi yang telah dibuat saat asesmen
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="marking-info">
                                                <h6>Informasi Penandaan</h6>

                                                <!-- Daftar Penandaan -->
                                                <div class="marking-list">
                                                    <div class="fw-bold mb-2">Daftar Penandaan (<span
                                                            id="markingCountShow">0</span>):</div>
                                                    <div id="markingsListShow" class="list-group"
                                                        style="max-height: 350px; overflow-y: auto;">
                                                        <!-- Marking items will be loaded here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- 7. Discharge Planning -->
                            @if ($rencanaPulang)
                                <div class="section-separator" id="discharge-planning">
                                    <h5 class="section-title">7. Discharge Planning</h5>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Diagnosis Medis</label>
                                            <p>{{ $rencanaPulang->diagnosis_medis ?: '-' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Usia Lanjut</label>
                                            <p>{{ $rencanaPulang->usia_lanjut == 0 ? 'Ya' : 'Tidak' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Hambatan Mobilisasi</label>
                                            <p>{{ $rencanaPulang->hambatan_mobilisasi == 0 ? 'Ya' : 'Tidak' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Membutuhkan Pelayanan Medis
                                                Berkelanjutan</label>
                                            <p>{{ ucfirst($rencanaPulang->membutuhkan_pelayanan_medis ?: '-') }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Memerlukan Keterampilan Khusus</label>
                                            <p>{{ ucfirst($rencanaPulang->memerlukan_keterampilan_khusus ?: '-') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Memerlukan Alat Bantu</label>
                                            <p>{{ ucfirst($rencanaPulang->memerlukan_alat_bantu ?: '-') }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Memiliki Nyeri Kronis</label>
                                            <p>{{ ucfirst($rencanaPulang->memiliki_nyeri_kronis ?: '-') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Perkiraan Lama Dirawat</label>
                                            <p>{{ $rencanaPulang->perkiraan_lama_dirawat ? $rencanaPulang->perkiraan_lama_dirawat . ' hari' : '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Rencana Tanggal Pulang</label>
                                            <p>{{ $rencanaPulang->rencana_pulang ? Carbon\Carbon::parse($rencanaPulang->rencana_pulang)->format('d/m/Y') : '-' }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Kesimpulan</label>
                                            <p>{{ $rencanaPulang->kesimpulan ?: '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- 8. Diagnosis -->
                            <div class="section-separator" id="diagnosis">
                                <h5 class="section-title">8. Diagnosis</h5>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-primary">Diagnosis Banding</label>
                                        @if (!empty($diagnosisBanding) && count($diagnosisBanding) > 0)
                                            <ol class="ps-3">
                                                @foreach ($diagnosisBanding as $diagnosis)
                                                    <li>{{ $diagnosis }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada diagnosis banding</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-primary">Diagnosis Kerja</label>
                                        @if (!empty($diagnosisKerja) && count($diagnosisKerja) > 0)
                                            <ol class="ps-3">
                                                @foreach ($diagnosisKerja as $diagnosis)
                                                    <li>{{ $diagnosis }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada diagnosis kerja</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 9. Implementasi -->
                            <div class="section-separator" id="implementasi">
                                <h5 class="section-title">9. Implementasi</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Prognosis</label>
                                        @if (!empty($prognosis) && count($prognosis) > 0)
                                            <ol class="ps-3">
                                                @foreach ($prognosis as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data prognosis</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Observasi</label>
                                        @if (!empty($observasi) && count($observasi) > 0)
                                            <ol class="ps-3">
                                                @foreach ($observasi as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data observasi</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Terapeutik</label>
                                        @if (!empty($terapeutik) && count($terapeutik) > 0)
                                            <ol class="ps-3">
                                                @foreach ($terapeutik as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data terapeutik</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Edukasi</label>
                                        @if (!empty($edukasi) && count($edukasi) > 0)
                                            <ol class="ps-3">
                                                @foreach ($edukasi as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data edukasi</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Kolaborasi</label>
                                        @if (!empty($kolaborasi) && count($kolaborasi) > 0)
                                            <ol class="ps-3">
                                                @foreach ($kolaborasi as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data kolaborasi</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Info Tambahan -->
                            <div class="section-separator">
                                <h6 class="fw-bold">Informasi Asesmen</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Waktu Asesmen:
                                            {{ Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Dibuat oleh:
                                            {{ $asesmen->user->name ?? 'Unknown' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Site Marking Show
            initSiteMarkingShow();
        });

        function initSiteMarkingShow() {
            const image = document.getElementById('anatomyImageShow');
            const canvas = document.getElementById('markingCanvasShow');
            const markingsList = document.getElementById('markingsListShow');
            const markingCount = document.getElementById('markingCountShow');

            // Check if elements exist
            if (!image || !canvas || !markingsList || !markingCount) {
                console.log('Site marking elements not found - no marking data available');
                return;
            }

            const ctx = canvas.getContext('2d');
            let markings = [];

            // Load existing data from PHP
            try {
                const siteMarkingData = @json($asesmenKulitKelamin->site_marking_data ?? '[]');
                if (siteMarkingData && siteMarkingData !== '[]') {
                    markings = typeof siteMarkingData === 'string' ? JSON.parse(siteMarkingData) : siteMarkingData;
                }
            } catch (e) {
                console.error('Error parsing site marking data:', e);
                markings = [];
            }

            // Setup canvas
            setupCanvasShow();

            // Load and display markings
            loadMarkingsShow();

            function setupCanvasShow() {
                function updateCanvasSize() {
                    canvas.width = image.offsetWidth;
                    canvas.height = image.offsetHeight;
                    canvas.style.width = image.offsetWidth + 'px';
                    canvas.style.height = image.offsetHeight + 'px';

                    // Redraw all markings
                    redrawCanvasShow();
                }

                // Update canvas size when image loads
                image.onload = updateCanvasSize;

                // Update canvas size when window resizes
                window.addEventListener('resize', updateCanvasSize);

                // Initial setup
                if (image.complete) {
                    updateCanvasSize();
                }
            }

            function loadMarkingsShow() {
                // Clear current list
                markingsList.innerHTML = '';

                if (markings.length === 0) {
                    markingsList.innerHTML = `
                <div class="text-muted text-center py-3">
                    <i class="ti-info-alt"></i> Tidak ada penandaan anatomi
                </div>
            `;
                } else {
                    markings.forEach((marking, index) => {
                        addToMarkingsListShow(marking, index + 1);
                    });
                }

                // Update count
                markingCount.textContent = markings.length;

                // Draw markings on canvas
                setTimeout(() => {
                    redrawCanvasShow();
                }, 100);
            }

            function addToMarkingsListShow(marking, number) {
                const listItem = document.createElement('div');
                listItem.className = 'marking-list-item-show';

                const timeString = marking.timestamp ?
                    new Date(marking.timestamp).toLocaleString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '-';

                listItem.innerHTML = `
            <div class="d-flex align-items-start gap-2">
                <div class="marking-color-indicator" style="background-color: ${marking.color}; margin-top: 2px;"></div>
                <div class="flex-grow-1">
                    <div class="fw-semibold text-primary">${number}. ${marking.note || 'Penandaan ' + number}</div>
                    <div class="marking-detail text-muted">
                        <small>
                            <i class="ti-calendar me-1"></i>${timeString}<br>
                            <i class="ti-location-arrow me-1"></i>Posisi: ${marking.startX ? marking.startX.toFixed(1) : '0'}%, ${marking.startY ? marking.startY.toFixed(1) : '0'}%
                        </small>
                    </div>
                    <span class="badge marking-badge" style="background-color: ${marking.color}; color: white;">PANAH</span>
                </div>
            </div>
        `;

                markingsList.appendChild(listItem);
            }

            function drawArrowShow(ctx, startX, startY, endX, endY, color) {
                ctx.strokeStyle = color;
                ctx.fillStyle = color;
                ctx.lineWidth = 3;
                ctx.lineCap = 'round';

                // Draw line
                ctx.beginPath();
                ctx.moveTo(startX, startY);
                ctx.lineTo(endX, endY);
                ctx.stroke();

                // Calculate arrow head
                const angle = Math.atan2(endY - startY, endX - startX);
                const arrowLength = 15;
                const arrowAngle = Math.PI / 6;

                // Draw arrow head
                ctx.beginPath();
                ctx.moveTo(endX, endY);
                ctx.lineTo(
                    endX - arrowLength * Math.cos(angle - arrowAngle),
                    endY - arrowLength * Math.sin(angle - arrowAngle)
                );
                ctx.moveTo(endX, endY);
                ctx.lineTo(
                    endX - arrowLength * Math.cos(angle + arrowAngle),
                    endY - arrowLength * Math.sin(angle + arrowAngle)
                );
                ctx.stroke();
            }

            function redrawCanvasShow() {
                // Clear canvas
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // Draw all markings
                markings.forEach(marking => {
                    if (marking.startX !== undefined && marking.startY !== undefined &&
                        marking.endX !== undefined && marking.endY !== undefined) {

                        const startX = (marking.startX / 100) * canvas.width;
                        const startY = (marking.startY / 100) * canvas.height;
                        const endX = (marking.endX / 100) * canvas.width;
                        const endY = (marking.endY / 100) * canvas.height;

                        drawArrowShow(ctx, startX, startY, endX, endY, marking.color || '#dc3545');
                    }
                });
            }

            console.log('Site Marking Show Mode: Initialized with', markings.length, 'markings');
        }
    </script>
@endpush

@push('css')
    <style>
        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-label.fw-bold {
            font-weight: 600 !important;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .text-justify {
            text-align: justify;
        }

        .badge {
            font-size: 0.75rem;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        /* Site Marking Show Styles */
        .site-marking-container {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            position: relative;
        }

        .marking-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
        }

        .marking-list-item-show {
            padding: 12px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 8px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .marking-badge {
            font-size: 10px;
            padding: 4px 8px;
        }

        #anatomyImageShow {
            display: block;
            max-width: 100%;
            height: auto;
        }

        #markingCanvasShow {
            pointer-events: none;
        }

        .marking-detail {
            font-size: 0.875rem;
        }

        .marking-color-indicator {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            border: 2px solid #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
    </style>
@endpush
