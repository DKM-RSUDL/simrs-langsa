@extends('layouts.administrator.master')

@section('content')
	@push('css')
		<link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
	@endpush

	<div class="row">
		<div class="col-md-3">
			@include('components.patient-card')
		</div>

		<div class="col-md-9">
			<x-content-card>
				<x-button-previous />

				<div class="form-section">
					<form id="ProsesUbah"
						action="{{ route('ubah-pasien.ubah-pasien', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
						method="post">
						@csrf

						@include('components.page-header', [
							'title' => 'Data Pasien Aktual',
							'description' => 'Cari dan perbarui data menjadi data aktual.',
						])
						<div class="row g-3 mb-3">
							<div class="col-12">
								<div class="form-group -mb-1">
									<label for="nik_pasien" class="form-label">NIK/No. RM Pasien</label>
									<div class="input-group" style="margin-bottom: 0px">
										<input type="text" name="nik_pasien" id="nik_pasien" class="form-control"
											placeholder="NIK/No RM Pasien (Cth: 0-00-00-00)" aria-label="Nik Pasien" aria-describedby="button-nik-pasien"
											value="{{ old('nik_pasien') }}">
										<button class="btn btn-outline-secondary" type="button" id="button-nik-pasien">
											<i class="ti ti-search"></i>
										</button>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="nama" class="form-label">Nama Pasien</label>
									<input class="form-control" name="nama" type="text" id="nama" value="" disabled>

									<input type="hidden" name="kd_pasien_asli" id="kd_pasien_asli" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
									<select name="jenis_kelamin" id="jenis_kelamin" class="form-select" disabled>
										<option value="">--Pilih Jenis Kelamin--</option>
										<option value="1">Laki-laki</option>
										<option value="0">Perempuan</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
									<input class="form-control" name="tanggal_lahir" type="text" id="tanggal_lahir" placeholder="yyyy-mm-dd"
										disabled>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="usia" class="form-label">Usia</label>
									<input class="form-control" name="usia" id="usia" value="0" disabled>
								</div>
							</div>
						</div>

						<div class="row g-3 mb-3">
							<div class="col">
								<div class="form-group">
									<label for="alamat" class="form-label">Alamat</label>
									<textarea class="form-control" name="alamat" id="alamat" placeholder="Masukkan alamat asli pasien" disabled></textarea>
								</div>
							</div>
							<div class="col">
								<div class="form-group">
									<label for="alamat" class="form-label">Asuransi</label>
									<select class="form-select select2 @error('kd_customer') is-invalid @enderror" id="kd_customer"
										name="kd_customer" required>
										<option value=""></option>
										@foreach ($penanggungAsuransi as $customer)
											<option value="{{ $customer->kd_customer }}"
												{{ $dataMedis->kd_customer === $customer->kd_customer ? 'selected' : '' }}>
												{{ $customer->customer }}
											</option>
										@endforeach
									</select>
									@error('asuransi')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>

						<div class="row g-3 mb-4">
							<div class="col-md-6">
								<div class="form-group">
									<label for="jenis_peserta" class="form-label">Jenis Peserta</label>
									<input readonly class="form-control" name="jenis_peserta" type="text" id="jenis_peserta"
										placeholder="Jenis peserta BPJS">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="kelas_tanggung" class="form-label">Kelas Tanggung</label>
									<input readonly class="form-control" name="kelas_tanggung" id="kelas_tanggung" value="0">
								</div>
							</div>
						</div>
						{{-- END: DATA UPDATE --}}

						<hr style="border: none; height: 3px; background-color: blue;">

						{{-- START: DATA ASLI --}}
						@include('components.page-header', [
							'title' => 'Identitas Pasien Sebelumnya',
							'description' => 'Identitas pasien sebelum diubah menjadi data aktual.',
						])
						<div class="d-flex mb-1 gap-4">
							<div style="width: auto; height:150px">
								<div style="border: 1px solid #ced4da; padding: 5px; border-radius: 5px;" class="p-2 text-center">
									<img src="{{ asset('assets/images/avatar1.png') }}" width="150" height="150" alt="Foto Pasien"
										class="img-fluid">
								</div>
							</div>
							<div class="w-100">
								<div class="form-group">
									<label for="kd_transaksi" class="form-label">No. Transaksi</label>
									<input readonly class="form-control" name="kd_transaksi" type="text" id="kd_transaksi"
										value="{{ $dataMedis->no_transaksi ?? '0' }}">
								</div>
							</div>
						</div>
						<div class="row g-3 mb-3">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nama_sebelumnya" class="form-label">Nama Pasien</label>
									<input readonly class="form-control" name="nama_sebelumnya" type="text" id="nama_sebelumnya"
										value="{{ $dataMedis->pasien->nama ?? 'OKOK' }}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="jenis_kelamin_sebelumnya" class="form-label">Jenis Kelamin</label>
									<select readonly name="jenis_kelamin_sebelumnya" id="jenis_kelamin_sebelumnya" class="form-select" disabled>
										<option value="" disabled>--Pilih Jenis Kelamin--</option>
										<option value="1" {{ ($dataMedis->pasien->jenis_kelamin ?? '1') == '1' ? 'selected' : '' }}>
											Laki-laki</option>
										<option value="0" {{ ($dataMedis->pasien->jenis_kelamin ?? '1') == '0' ? 'selected' : '' }}>
											Perempuan</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="tanggal_lahir_sebelumnya" class="form-label">Tanggal Lahir</label>
									<input readonly class="form-control" name="tanggal_lahir_sebelumnya" type="date"
										id="tanggal_lahir_sebelumnya" value="{{ date('Y-m-d', strtotime($dataMedis->pasien->tgl_lahir)) }}"
										disabled>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="usia_sebelumnya" class="form-label">Usia</label>

									<input readonly class="form-control" name="usia_sebelumnya" id="usia_sebelumnya"
										value="{{ \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->age ?? \Carbon\Carbon::parse('2007-04-27')->age }}">
								</div>
							</div>
						</div>
						<div class="row g-3 mb-4">
							<div class="col">
								<div class="form-group">
									<label for="alamat_sebelumnya" class="form-label">Alamat</label>
									<textarea readonly class="form-control" name="alamat_sebelumnya" id="alamat_sebelumnya">{{ $dataMedis->pasien->alamat ?? '' }}</textarea>
								</div>
							</div>
						</div>
						{{-- END: DATA ASLI --}}

						<div class="text-end">
							<x-button-submit id="submit-button">
								Mulai Ubah
							</x-button-submit>
						</div>
					</form>
				</div>
			</x-content-card>
		</div>
	</div>
@endsection

@push('js')
	<script>
		$(document).ready(function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Handler khusus tombol submit-button
			$(document).on('submit', '#ProsesUbah', function() {
				let $submitBtn = $(this).find('button[type="submit"]');
				$submitBtn.prop('disabled', true).text('Memproses...');
			});


			// Handler form ProsesUbah
			$(document).on('click', '#button-nik-pasien', function(e) {

				var nik = $('#nik_pasien').val().trim();

				// SweetAlert Toast config
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true
				});

				// Validasi input kosong
				if (!nik) {
					Toast.fire({
						icon: 'warning',
						title: 'Silakan masukkan NIK atau No. RM pasien.'
					});
					return;
				}

				// Validasi panjang karakter 10–16
				if (nik.length < 10 || nik.length > 16) {
					Toast.fire({
						icon: 'error',
						title: 'NIK/No. RM harus 10-16 karakter.'
					});
					return;
				}

				// 🔹 Tampilkan popup loading
				Swal.fire({
					title: 'Memproses...',
					text: 'Mohon tunggu sebentar',
					allowOutsideClick: false,
					didOpen: () => {
						Swal.showLoading();
					}
				});

				$.ajax({
					method: 'GET',
					url: "{{ route('bpjs.vclaim', ['identifier' => 'PLACEHOLDER']) }}".replace(
						'PLACEHOLDER', nik),
					success: function(response) {
						$('#submit-button').attr('disabled', false);
						Swal.close(); // tutup popup loading

						if (response.status === 'success') {
							var pasien = response.data;
							console.log(pasien);

							$('#nama').val(pasien.nama || '');
							$('#jenis_kelamin').val(pasien.jenis_kelamin ?? '');
							$('#tanggal_lahir').val(pasien.tgl_lahir || '');
							$('#alamat').val(pasien.alamat || '');
							$('#kd_pasien_asli').val(pasien.kd_pasien || '');
							$('#jenis_peserta').val(pasien.jenis_peserta?.keterangan ?? '');
							$('#kelas_tanggung').val(pasien.kelas_tanggung?.keterangan ?? '');

							// Hitung usia
							if (pasien.tgl_lahir) {
								var dob = new Date(pasien.tgl_lahir);
								var today = new Date();
								var age = today.getFullYear() - dob.getFullYear();
								var monthDiff = today.getMonth() - dob.getMonth();
								if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob
										.getDate())) {
									age--;
								}
								$('#usia').val(age || 0);
							} else {
								$('#usia').val(0);
							}

							Toast.fire({
								icon: 'success',
								title: response.metaData.message
							});
						} else {
							resetForm();
							Toast.fire({
								icon: 'error',
								title: response.message
							});
						}
					},
					error: function(xhr) {
						console.log(xhr.responseJSON?.metaData.message);
						Swal.close(); // tutup popup loading

						var errorMessage = xhr.responseJSON?.metaData.message ??
							'Terjadi kesalahan saat mengambil data pasien.';

						resetForm();

						Toast.fire({
							icon: 'error',
							title: errorMessage
						});
					}
				});

				function resetForm() {
					$('#nama, #tanggal_lahir, #usia, #alamat').val('').prop('readonly', true);
					$('#jenis_kelamin').val('').prop('disabled', true);
				}
			});

		});
	</script>
@endpush
{{-- @push('js')
<script>
    $('#kd_spesial').change(function (e) {
        let $this = $(this);
        let kdSpesial = $this.val();

        $.ajax({
            type: "post",
            url: "{{ route('transfer-rwi.get-dokter-spesial-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
            data: {
                _token: "{{ csrf_token() }}",
                kd_spesial: kdSpesial
            },
            dataType: "json",
            success: function (res) {
                let status = res.status;
                let msg = res.message;
                let data = res.data;

                if (status == 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: msg
                    });

                    return false;
                }

                $('#kd_dokter').html(data.dokterOption);
                $('#kd_kelas').html(data.kelasOption);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: 'Dokter dan Kelas gagal di cari !'
                });
            }
        });
    });

    $('#kd_kelas').change(function (e) {
        let $this = $(this);
        let kdKelas = $this.val();

        $.ajax({
            type: "post",
            url: "{{ route('transfer-rwi.get-ruang-kelas-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
            data: {
                _token: "{{ csrf_token() }}",
                kd_kelas: kdKelas
            },
            dataType: "json",
            success: function (res) {
                let status = res.status;
                let msg = res.message;
                let data = res.data;

                if (status == 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: msg
                    });

                    return false;
                }

                $('#kd_unit').html(data);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: 'Ruangan gagal di cari !'
                });
            }
        });
    });


    $('#kd_unit').change(function (e) {
        let $this = $(this);
        let kdUnit = $this.val();

        $.ajax({
            type: "post",
            url: "{{ route('transfer-rwi.get-kamar-ruang-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
            data: {
                _token: "{{ csrf_token() }}",
                kd_unit: kdUnit
            },
            dataType: "json",
            success: function (res) {
                let status = res.status;
                let msg = res.message;
                let data = res.data;

                if (status == 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: msg
                    });

                    return false;
                }

                $('#no_kamar').html(data);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: 'Kamar gagal di cari !'
                });
            }
        });
    });


    $('#no_kamar').change(function (e) {
        let $this = $(this);
        let noKamar = $this.val();

        $.ajax({
            type: "post",
            url: "{{ route('transfer-rwi.get-sisa-bed-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
            data: {
                _token: "{{ csrf_token() }}",
                no_kamar: noKamar
            },
            dataType: "json",
            success: function (res) {
                let status = res.status;
                let msg = res.message;
                let data = res.data;

                if (status == 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: msg
                    });

                    return false;
                }

                $('#sisa_bed').val(data);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: 'Sisa Bed gagal di cari !'
                });
            }
        });
    });

    @cannot('is-admin')
    $('#petugas_menyerahkan').on('mousedown focusin touchstart', function (e) {
        e.preventDefault();
    });
    @endcannot
</script>
@endpush --}}
