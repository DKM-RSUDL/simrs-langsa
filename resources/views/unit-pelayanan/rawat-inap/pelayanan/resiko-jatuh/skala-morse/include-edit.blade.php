@push('css')
    <style>
        .form-check.selected {
            background-color: #cfe2ff !important;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('resikoJatuh_form');
            let lastChecked = {}; // Untuk menyimpan radio button yang terakhir diklik

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
                    const checked = document.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        lengkap = false;
                        return;
                    }
                    skor += parseInt(checked.value || '0', 10);
                });

                // Update skor total
                const skorEl = document.getElementById('resikoJatuh_skorTotal');
                const skorInput = document.getElementById('resikoJatuh_skorTotalInput');
                skorEl.textContent = isNaN(skor) ? 0 : skor;
                skorInput.value = isNaN(skor) ? '' : String(skor);

                // Set kategori (0–24 RR, 25–44 RS, >=45 RT)
                const kategoriEl = document.getElementById('resikoJatuh_kategoriResiko');
                const kategoriInput = document.getElementById('resikoJatuh_kategoriResikoInput');
                const hasilResikoEl = document.getElementById('resikoJatuh_hasilResiko');

                let kategori = '';
                let kategoriLengkap = '';
                if (lengkap && !isNaN(skor)) {
                    if (skor <= 24) {
                        kategori = 'RESIKO RENDAH (RR)';
                        kategoriLengkap = 'RR';
                        hasilResikoEl.className =
                            'card resiko_jatuh__card resiko_jatuh__result-card bg-success text-white';
                    } else if (skor <= 44) {
                        kategori = 'RESIKO SEDANG (RS)';
                        kategoriLengkap = 'RS';
                        hasilResikoEl.className =
                            'card resiko_jatuh__card resiko_jatuh__result-card bg-warning text-dark';
                    } else {
                        kategori = 'RESIKO TINGGI (RT)';
                        kategoriLengkap = 'RT';
                        hasilResikoEl.className =
                            'card resiko_jatuh__card resiko_jatuh__result-card bg-danger text-white';
                    }
                } else {
                    kategori = 'Belum Dinilai';
                    hasilResikoEl.className = 'card resiko_jatuh__card resiko_jatuh__result-card';
                }

                kategoriEl.textContent = kategori;
                kategoriInput.value = kategoriLengkap;

                // Tampilkan intervensi sesuai kategori
                const rr = document.getElementById('resikoJatuh_intervensiRR');
                const rs = document.getElementById('resikoJatuh_intervensiRS');
                const rt = document.getElementById('resikoJatuh_intervensiRT');
                if (rr) rr.style.display = kategoriLengkap === 'RR' ? 'block' : 'none';
                if (rs) rs.style.display = kategoriLengkap === 'RS' ? 'block' : 'none';
                if (rt) rt.style.display = kategoriLengkap === 'RT' ? 'block' : 'none';
            }

            // Event listener untuk radio button dengan fitur uncheck
            document.querySelectorAll('input[type="radio"][name="riwayat_jatuh"],\
                            input[type="radio"][name="diagnosa_sekunder"],\
                            input[type="radio"][name="bantuan_ambulasi"],\
                            input[type="radio"][name="terpasang_infus"],\
                            input[type="radio"][name="gaya_berjalan"],\
                            input[type="radio"][name="status_mental"]').forEach(radio => {

                radio.addEventListener('click', function(e) {
                    const groupName = this.name;

                    // Jika radio button yang sama diklik lagi, uncheck
                    if (lastChecked[groupName] === this && this.checked) {
                        this.checked = false;
                        lastChecked[groupName] = null;

                        // Update visual state
                        const group = this.name;
                        document.querySelectorAll(`[data-group="${group}"]`).forEach(item => {
                            item.classList.remove('selected');
                        });

                        // Recalculate
                        hitungSkorDanKategori();
                        return;
                    }

                    // Simpan radio button yang diklik sebagai yang terakhir
                    lastChecked[groupName] = this;

                    // Update visual selected state
                    $(`[data-group="${groupName}"]`).removeClass('selected');
                    $(this).closest('.form-check').addClass('selected'); // Recalculate
                    hitungSkorDanKategori();
                });
            });

            form.addEventListener('submit', function(e) {
                // Hanya validasi field yang wajib diisi: Tanggal, Hari ke, Shift
                const tanggal = document.getElementById('tanggal').value;
                const hariKe = document.querySelector('input[name="hari_ke"]').value;
                const shift = document.getElementById('shift').value;

                // Cek field wajib
                if (!tanggal || !hariKe || !shift) {
                    e.preventDefault();
                    alert('Mohon lengkapi data pengkajian (Tanggal, Hari ke, dan Shift) terlebih dahulu!');
                    return;
                }

                // Validasi nilai hari ke harus positif
                if (parseInt(hariKe) < 1) {
                    e.preventDefault();
                    alert('Hari ke harus berisi angka yang valid (minimal 1)!');
                    return;
                }
            });

            // Handle checkbox intervensi
            document.querySelectorAll('input[name^="intervensi_"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const formCheck = checkbox.closest('.form-check');
                    if (checkbox.checked) {
                        formCheck.classList.add('selected');
                    } else {
                        formCheck.classList.remove('selected');
                    }
                });
            });

            // Buat seluruh area item bisa di-klik (kecuali input/label agar tidak double-toggle)
            document.querySelectorAll('.resiko_jatuh__criteria-form-check').forEach(item => {
                item.addEventListener('click', function(e) {
                    const tag = e.target.tagName.toLowerCase();
                    if (tag === 'input' || tag === 'label') return; // biar label handler yang urus

                    const input = item.querySelector('input[type="radio"], input[type="checkbox"]');
                    if (!input) return;

                    if (input.type === 'radio') {
                        // Trigger click event pada radio button untuk menggunakan logika uncheck
                        input.click();
                    } else if (input.type === 'checkbox') {
                        input.checked = !input.checked;
                        input.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    }
                });
            });

            // Bikin klik pada label juga toggle input terkait
            document.querySelectorAll('.resiko_jatuh__criteria-form-check label').forEach(label => {
                label.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const forId = label.getAttribute('for');
                    let input = forId ? document.getElementById(forId) : label.closest(
                        '.resiko_jatuh__criteria-form-check')?.querySelector(
                        'input[type="radio"], input[type="checkbox"]');
                    if (!input) return;

                    if (input.type === 'radio') {
                        // Trigger click event pada radio button untuk menggunakan logika uncheck
                        input.click();
                    } else {
                        input.checked = !input.checked;
                        input.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    }
                });
            });

            // Set initial visual state berdasarkan data yang sudah ada
            document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                radio.closest('.form-check').classList.add('selected');
                // Set sebagai lastChecked untuk radio yang sudah terpilih saat load
                lastChecked[radio.name] = radio;
            });

            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                checkbox.closest('.form-check').classList.add('selected');
            });

            // Inisialisasi
            const skorTotalInput = document.getElementById('resikoJatuh_skorTotalInput').value;
            const kategoriInput = document.getElementById('resikoJatuh_kategoriResikoInput').value;
            if (skorTotalInput && kategoriInput) {
                // Jika ada data skor dan kategori, gunakan dari sana
                document.getElementById('resikoJatuh_skorTotal').textContent = skorTotalInput;
                document.getElementById('resikoJatuh_kategoriResiko').textContent = kategoriInput;
                // Tampilkan intervensi sesuai kategori
                const rr = document.getElementById('resikoJatuh_intervensiRR');
                const rs = document.getElementById('resikoJatuh_intervensiRS');
                const rt = document.getElementById('resikoJatuh_intervensiRT');
                if (rr) rr.style.display = kategoriInput === 'RR' ? 'block' : 'none';
                if (rs) rs.style.display = kategoriInput === 'RS' ? 'block' : 'none';
                if (rt) rt.style.display = kategoriInput === 'RT' ? 'block' : 'none';
            } else {
                // Jika tidak ada, hitung dari penilaian
                hitungSkorDanKategori();
            }
        });
    </script>
@endpush
