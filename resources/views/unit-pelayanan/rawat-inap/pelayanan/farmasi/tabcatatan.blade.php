<div>
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row g-3 w-100">
            <div class="col-md-2">
                <input type="date" name="start_date" id="startDate" class="form-control" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" id="endDate" class="form-control" placeholder="S.d Tanggal">
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari" aria-label="Cari"
                        aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-2">
                <button id="btnTambahCatatan" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#tambahObatCatatan" type="button">
                    <i class="ti-plus"></i> Tambah
                </button>
                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.modalcatatan')
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="resepTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal dan Jam</th>
                    <th>Nama Obat</th>
                    <th>Frekuensi</th>
                    <th>Dosis</th>
                    <th>Petugas</th>
                    <th>Keterangan</th>
                    <th>Catatan</th>
                    <th>Perlu Validasi</th>
                    <th>Petugas Validasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($riwayatCatatanObat) && count($riwayatCatatanObat) > 0)
                    @foreach ($riwayatCatatanObat as $index => $catatan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($catatan->tanggal)->format('d/m/Y H:i') }}</td>
                            <td>{{ $catatan->nama_obat }}</td>
                            <td>{{ $catatan->frekuensi }}</td>
                            <td>{{ $catatan->dosis }} {{ $catatan->satuan }}</td>
                            <td>
                                {{ $catatan->petugas->karyawan->nama ?? ($catatan->kd_petugas ?? 'Tidak Diketahui') }}
                            </td>
                            <td>{{ $catatan->keterangan }}</td>
                            <td>{{ $catatan->catatan }}</td>
                            <td align="middle">
                                @if ($catatan->is_validasi == 1)
                                    <p class="m-0 p-0 text-success">Ya</p>
                                @else
                                    <p class="m-0 p-0 text-secondary">Tidak</p>
                                @endif
                            </td>
                            <td align="middle">
                                {{ $catatan->petugasValidasi->karyawan->nama ?? ($catatan->petugas_validasi ?? '-') }}
                            </td>
                            <td>
                                @if (
                                    $catatan->kd_petugas != (auth()->user()->karyawan->kd_karyawan ?? '0000000') &&
                                        empty($catatan->petugas_validasi) &&
                                        $catatan->is_validasi == 1)
                                    <button class="btn btn-primary btn-sm btn-validasi-catatan"
                                        data-id="{{ encrypt($catatan->id) }}">
                                        <i class="bi bi-check"></i> Validasi
                                    </button>
                                @endif

                                @if ($catatan->kd_petugas == (auth()->user()->karyawan->kd_karyawan ?? '0000000'))
                                    <button class="btn btn-danger btn-sm btn-delete-catatan"
                                        data-id="{{ $catatan->id }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada catatan pemberian obat</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if (isset($error))
        <div class="alert alert-warning">{{ $error }}</div>
    @elseif(!isset($riwayatCatatanObat) || $riwayatCatatanObat->isEmpty())
        <div class="alert alert-info">
            Tidak ada riwayat pemberian obat untuk pasien ini.
        </div>
    @endif
</div>

@push('js')
    <script>
        $('.btn-validasi-catatan').click(function() {
            let $this = jQuery(this);
            let catatan = $this.attr('data-id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Obat ini akan divalidasi dan tidak dapat dibatalkan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, validasi!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery.ajax({
                        type: "POST",
                        url: "{{ route('rawat-inap.farmasi.catatanObat.validasi', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                        data: {
                            "catatan": catatan,
                            "_method": 'PUT',
                            "_token": "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Proses',
                                text: 'Sedang memproses...',
                                allowOutsideClick: false, // Tidak bisa diklik di luar
                                allowEscapeKey: false, // Tidak bisa ditutup dengan ESC
                                showConfirmButton: false, // Tidak ada tombol
                                showCancelButton: false, // Tidak ada tombol cancel
                                didOpen: () => {
                                    Swal
                                        .showLoading(); // Menampilkan loading spinner bawaan SweetAlert2
                                }
                            });
                        },
                        success: function(res) {
                            let status = res.status;
                            let msg = res.message;
                            let data = res.data;

                            if (status == 'error') {
                                showToast('error', msg);
                                return false;
                            }

                            showToast('success', 'Catatan pemberian obat berhasil divalidasi');
                            location.reload();
                        },
                        error: function() {
                            showToast('error', 'Internal Server Error');
                        }
                    });
                }
            });


        });

        // Open E-Resep in a new tab when Tambah is clicked while Catatan pane is active
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                const btnTambah = document.getElementById('btnTambahCatatan');
                if (!btnTambah) return;

                btnTambah.addEventListener('click', function(event) {
                    try {
                        // Determine if Catatan tab pane is currently active/visible
                        const catatanPane = document.getElementById('catatanTab');
                        const isActive = catatanPane && catatanPane.classList.contains('show') &&
                            catatanPane.classList.contains('active');

                        if (isActive) {
                            // Build URL to open resep tab in new tab
                            const url = new URL(window.location.href);
                            url.searchParams.set('open', 'resep');
                            // Open synchronously on click to avoid popup blocking
                            window.open(url.toString(), '_blank');
                        }
                    } catch (e) {
                        console.error('Error opening E-Resep tab:', e);
                    }
                    // Do not prevent default — let Bootstrap open the modal as well
                });
            });
        })();

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete-catatan').forEach(button => {
                button.removeEventListener('click', handleDeleteCatatan); // Hindari duplikasi
                button.addEventListener('click', handleDeleteCatatan);
            });

            function handleDeleteCatatan() {
                const id = this.getAttribute('data-id');
                console.log('ID yang akan dihapus (Catatan):', id);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Catatan ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url =
                            "{{ route('rawat-inap.farmasi.hapusCatatanObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}"
                            .replace(':id', id);
                        console.log('URL yang dikirim (Catatan):', url);

                        fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Response (Catatan):', data);
                                if (data.message.includes('berhasil')) {
                                    Swal.fire(
                                        'Terhapus!',
                                        'Catatan berhasil dihapus.',
                                        'success'
                                    ).then(() => {
                                        this.closest('tr').remove();
                                        document.querySelectorAll('#resepTable tbody tr')
                                            .forEach((row, index) => {
                                                row.cells[0].textContent = index + 1;
                                            });
                                    });
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Gagal menghapus: ' + data.error,
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error('Error (Catatan):', error);
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus.',
                                    'error'
                                );
                            });
                    }
                });
            }
        });
    </script>
@endpush
