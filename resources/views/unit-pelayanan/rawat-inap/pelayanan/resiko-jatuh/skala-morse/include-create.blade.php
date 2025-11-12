@push('css')
    <style>
        .form-check.selected {
            background-color: #cfe2ff !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            let lastChecked = {};

            // Fungsi untuk menghitung skor dan kategori
            function hitungSkorDanKategori() {
                const groups = [
                    'riwayat_jatuh',
                    'diagnosa_sekunder',
                    'bantuan_ambulasi',
                    'terpasang_infus',
                    'gaya_berjalan',
                    'status_mental'
                ];

                let skor = 0;
                let lengkap = true;

                groups.forEach(name => {
                    const checked = $(`input[name="${name}"]:checked`);
                    if (checked.length === 0) {
                        lengkap = false;
                        return;
                    }
                    skor += parseInt(checked.val() || '0', 10);
                });

                // Update skor total
                $('#resikoJatuh_skorTotal').text(isNaN(skor) ? 0 : skor);
                $('#resikoJatuh_skorTotalInput').val(isNaN(skor) ? '' : String(skor));

                // Set kategori (0–24 RR, 25–44 RS, >=45 RT)
                let kategori = '';
                if (lengkap && !isNaN(skor)) {
                    if (skor <= 24) kategori = 'RR';
                    else if (skor <= 44) kategori = 'RS';
                    else kategori = 'RT';
                }

                $('#resikoJatuh_kategoriResiko').text(kategori ? kategori : 'Belum Dinilai');
                $('#resikoJatuh_kategoriResikoInput').val(kategori);

                // Tampilkan intervensi sesuai kategori
                tampilkanIntervensi(kategori);
            }

            // Fungsi untuk menampilkan intervensi berdasarkan kategori
            function tampilkanIntervensi(kategori) {
                $('#resikoJatuh_intervensiRR, #resikoJatuh_intervensiRS, #resikoJatuh_intervensiRT').hide();

                if (kategori === 'RR') {
                    $('#resikoJatuh_intervensiRR').show();
                } else if (kategori === 'RS') {
                    $('#resikoJatuh_intervensiRS').show();
                } else if (kategori === 'RT') {
                    $('#resikoJatuh_intervensiRT').show();
                }
            }

            // Event listener untuk checkbox enable penilaian
            $('#enableResikoJatuh').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#penilaianSection, #hasilSection').show();
                } else {
                    $('#penilaianSection, #hasilSection').hide();
                    // Reset semua radio button
                    $('input[type="radio"]').prop('checked', false);
                    // Reset visual state
                    $('.form-check[data-group]').removeClass('selected');
                    lastChecked = {};
                    hitungSkorDanKategori();
                }
            });

            // Event listener untuk radio button dengan fitur uncheck
            $('input[type="radio"][name="riwayat_jatuh"], input[type="radio"][name="diagnosa_sekunder"], input[type="radio"][name="bantuan_ambulasi"], input[type="radio"][name="terpasang_infus"], input[type="radio"][name="gaya_berjalan"], input[type="radio"][name="status_mental"]')
                .on('click', function(e) {
                    const groupName = $(this).attr('name');

                    // Jika radio button yang sama diklik lagi, uncheck
                    if (lastChecked[groupName] === this && $(this).is(':checked')) {
                        $(this).prop('checked', false);
                        lastChecked[groupName] = null;

                        // Update visual state
                        $(`[data-group="${groupName}"]`).removeClass('selected');

                        hitungSkorDanKategori();
                        return;
                    }

                    // Simpan radio button yang diklik sebagai yang terakhir
                    lastChecked[groupName] = this;

                    // Update visual selected state
                    $(`[data-group="${groupName}"]`).removeClass('selected');
                    $(this).closest('.form-check').addClass('selected');

                    hitungSkorDanKategori();
                });

            // Handle checkbox intervensi
            $('input[name^="intervensi_"]').on('change', function() {
                const formCheck = $(this).closest('.form-check');
                if ($(this).is(':checked')) {
                    formCheck.addClass('selected');
                } else {
                    formCheck.removeClass('selected');
                }
            });

            // Set initial visual state berdasarkan data yang sudah ada
            $('input[type="radio"]:checked').each(function() {
                $(this).closest('.form-check').addClass('selected');
                lastChecked[$(this).attr('name')] = this;
            });

            $('input[type="checkbox"]:checked').each(function() {
                $(this).closest('.form-check').addClass('selected');
            });

            // Inisialisasi
            const skorTotalInput = $('#resikoJatuh_skorTotalInput').val();
            const kategoriInput = $('#resikoJatuh_kategoriResikoInput').val();
            if (skorTotalInput && kategoriInput) {
                // Jika ada lastAssessment, gunakan skor dan kategori dari sana
                $('#resikoJatuh_skorTotal').text(skorTotalInput);
                $('#resikoJatuh_kategoriResiko').text(kategoriInput);
                tampilkanIntervensi(kategoriInput);
                $('#hasilSection').show();
            } else {
                // Jika tidak ada, hitung dari penilaian
                hitungSkorDanKategori();
                if ($('#enableResikoJatuh').is(':checked')) {
                    $('#hasilSection').show();
                } else {
                    $('#hasilSection').hide();
                }
            }
        });
    </script>
@endpush
