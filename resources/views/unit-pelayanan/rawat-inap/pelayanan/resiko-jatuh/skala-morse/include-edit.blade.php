@push('css')
    <style>
        .resiko_jatuh__header-asesmen {
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .resiko_jatuh__section-separator {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .resiko_jatuh__section-separator h5 {
            display: flex;
            font-weight: 600;
            align-items: center;
        }

        .resiko_jatuh__form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .resiko_jatuh__form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .resiko_jatuh__form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .resiko_jatuh__form-check {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .resiko_jatuh__form-check:hover {
            border-color: #0d6efd;
            background: #f0f3ff;
            transform: translateX(5px);
        }

        .resiko_jatuh__form-check-input:checked~.resiko_jatuh__form-check-label {
            color: #0d6efd;
            font-weight: 600;
        }

        .resiko_jatuh__form-check input:checked+label {
            color: #0d6efd !important;
        }

        .resiko_jatuh__form-check.selected {
            border-color: #0d6efd;
            background: #e8f0fe;
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
        }

        .resiko_jatuh__criteria-form-check {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .resiko_jatuh__criteria-form-check:hover {
            border-color: #0d6efd;
            background: #f0f3ff;
            transform: translateX(5px);
        }

        .resiko_jatuh__criteria-form-check-input:checked~.resiko_jatuh__criteria-form-check-label {
            color: #0d6efd;
            font-weight: 600;
        }

        .resiko_jatuh__criteria-form-check input:checked+label {
            color: #0d6efd !important;
        }

        .resiko_jatuh__criteria-form-check.selected {
            border-color: #0d6efd;
            background: #e8f0fe;
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
        }

        .resiko_jatuh__badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .resiko_jatuh__badge-info {
            color: white;
        }

        .resiko_jatuh__badge-success {
            background: #28a745;
            color: white;
        }

        .resiko_jatuh__badge-warning {
            background: #ffc107;
            color: #212529;
        }

        .resiko_jatuh__badge-danger {
            background: #dc3545;
            color: white;
        }

        .resiko_jatuh__font-weight-bold {
            color: #495057;
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .resiko_jatuh__card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .resiko_jatuh__card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .resiko_jatuh__score-total {
            font-size: 3rem;
            font-weight: bold;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            animation: resiko_jatuh__pulse 2s infinite;
        }

        @keyframes resiko_jatuh__pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .resiko_jatuh__result-card {
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .resiko_jatuh__result-card h5 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        .resiko_jatuh__btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .resiko_jatuh__btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background-color: #0d6efd;
        }

        .resiko_jatuh__criteria-section {
            background: #fafbfc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .resiko_jatuh__score-badge {
            float: right;
            margin-top: 2px;
        }

        .resiko_jatuh__fade-in {
            animation: resiko_jatuh__fadeIn 0.6s ease-in;
        }

        @keyframes resiko_jatuh__fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .resiko_jatuh__btn-outline-primary {
            border-color: #0d6efd;
            color: #0d6efd;
            transition: all 0.3s ease;
        }

        .resiko_jatuh__btn-outline-primary:hover {
            background: #0d6efd;
            border-color: #0d6efd;
            transform: translateX(-3px);
        }

        .resiko_jatuh__keterangan-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        .resiko_jatuh__keterangan-title {
            color: #0d6efd;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .resiko_jatuh__keterangan-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
        }

        .resiko_jatuh__keterangan-list li {
            margin-bottom: 8px;
        }

        /* Style khusus untuk section intervensi */
        .resiko_jatuh__intervensi-rr {
            border-left: 4px solid #28a745;
        }

        .resiko_jatuh__intervensi-rr h5 {
            color: #28a745;
        }

        .resiko_jatuh__intervensi-rs {
            border-left: 4px solid #ffc107;
        }

        .resiko_jatuh__intervensi-rs h5 {
            color: #856404;
        }

        .resiko_jatuh__intervensi-rt {
            border-left: 4px solid #dc3545;
        }

        .resiko_jatuh__intervensi-rt h5 {
            color: #dc3545;
        }

        .resiko_jatuh__criteria-form-check {
            cursor: pointer;
        }

        .resiko_jatuh__criteria-form-check .form-check-label {
            display: block;
            width: 100%;
            cursor: pointer;
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
                    const group = this.name;
                    document.querySelectorAll(`[data-group="${group}"]`).forEach(item => {
                        item.classList.remove('selected');
                    });
                    this.closest('.resiko_jatuh__criteria-form-check').classList.add('selected');

                    // Recalculate
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
                    const formCheck = this.closest('.resiko_jatuh__criteria-form-check');
                    if (this.checked) {
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
                radio.closest('.resiko_jatuh__criteria-form-check').classList.add('selected');
                // Set sebagai lastChecked untuk radio yang sudah terpilih saat load
                lastChecked[radio.name] = radio;
            });

            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                checkbox.closest('.resiko_jatuh__criteria-form-check').classList.add('selected');
            });

            // Inisialisasi
            hitungSkorDanKategori();
        });
    </script>
@endpush
