<script>
    $(document).ready(function() {

        ///===============================================================================================//
        // Add random data generation button to the form
        ///===============================================================================================//
        $('.row .col-12.text-end').prepend(`
            <button type="button" id="generateRandomData" class="btn btn-warning me-2">
                <i class="bi bi-shuffle me-1"></i> Isi Data Random
            </button>
        `);

        // Random data generation functionality
        $('#generateRandomData').on('click', function() {
            // Helper function to get random number within range
            function randomNumber(min, max, decimals = 0) {
                const factor = Math.pow(10, decimals);
                return Math.round((Math.random() * (max - min) + min) * factor) / factor;
            }

            // Helper function to get random item from array
            function randomItem(array) {
                return array[Math.floor(Math.random() * array.length)];
            }

            // Random date within the last 7 days
            function randomDate() {
                const today = new Date();
                const pastDays = randomNumber(0, 7);
                const date = new Date(today);
                date.setDate(today.getDate() - pastDays);
                return date.toISOString().split('T')[0]; // Format: YYYY-MM-DD
            }

            // Set date and time
            $('[name="tgl_implementasi"]').val(randomDate());

            // Random time
            const hours = String(randomNumber(0, 23)).padStart(2, '0');
            const minutes = String(randomNumber(0, 59)).padStart(2, '0');
            $('[name="jam_implementasi"]').val(`${hours}:${minutes}`);

            // Patient information
            const indications = [
                "Acute Coronary Syndrome",
                "Kardiomiopati",
                "Post Cardiac Arrest",
                "Aritmia yang tidak stabil",
                "Gagal jantung akut",
                "Tamponade jantung",
                "Shock kardiogenik"
            ];

            const diagnoses = [
                "STEMI Anterior",
                "NSTEMI",
                "Unstable Angina",
                "Aritmia Ventrikular",
                "Congestive Heart Failure",
                "Takikardia Supraventrikular",
                "Atrial Fibrillation"
            ];

            const allergies = ["Tidak ada", "Penisilin", "Sulfa", "Seafood", "Kontras", "Aspirin",
                "Morfin", ""
            ];

            $('[name="indikasi_iccu"]').val(randomItem(indications));
            $('[name="diagnosa"]').val(randomItem(diagnoses));
            $('[name="alergi"]').val(randomItem(allergies));
            $('[name="berat_badan"]').val(randomNumber(45, 95, 1));
            $('[name="tinggi_badan"]').val(randomNumber(150, 185));

            // Output
            $('[name="bab"]').val(randomNumber(0, 3) + " x");
            $('[name="urine"]').val(randomNumber(500, 2000) + " ml");
            $('[name="iwl"]').val(randomNumber(300, 800) + " ml");
            $('[name="muntahan_cms"]').val(randomNumber(0, 200) + " ml");
            $('[name="drain"]').val(randomNumber(0, 150) + " ml");

            // Vital signs
            const sistolik = randomNumber(90, 180);
            const diastolik = randomNumber(60, 110);
            const map = Math.round((sistolik + 2 * diastolik) / 3);

            $('[name="sistolik"]').val(sistolik);
            $('[name="diastolik"]').val(diastolik);
            $('[name="map"]').val(map);
            $('[name="hr"]').val(randomNumber(60, 120));
            $('[name="rr"]').val(randomNumber(12, 30));
            $('[name="temp"]').val(randomNumber(36, 39, 1));

            // GCS - Glasgow Coma Scale
            const eyeValues = ["", "1", "2", "3", "4"];
            const verbalValues = ["", "1", "2", "3", "4", "5"];
            const motorValues = ["", "1", "2", "3", "4", "5", "6"];

            const eyeValue = randomItem(eyeValues);
            const verbalValue = randomItem(verbalValues);
            const motorValue = randomItem(motorValues);

            $('#gcs_eye').val(eyeValue);
            $('#gcs_verbal').val(verbalValue);
            $('#gcs_motor').val(motorValue);

            // Calculate GCS total if all values are selected
            if (eyeValue && verbalValue && motorValue) {
                const totalGCS = parseInt(eyeValue) + parseInt(verbalValue) + parseInt(motorValue);
                $('#gcs_total').val(totalGCS);
            }

            // Pupil status
            const pupilStatus = ["", "isokor", "anisokor", "midriasis", "miosis", "pinpoint"];
            $('[name="pupil_kanan"]').val(randomItem(pupilStatus));
            $('[name="pupil_kiri"]').val(randomItem(pupilStatus));

            // AGD - Analisis Gas Darah
            $('[name="ph"]').val(randomNumber(7.30, 7.50, 2));
            $('[name="po2"]').val(randomNumber(80, 100, 1));
            $('[name="pco2"]').val(randomNumber(35, 45, 1));
            $('[name="be"]').val(randomNumber(-3, 3, 1));
            $('[name="hco3"]').val(randomNumber(22, 28, 1));
            $('[name="saturasi_o2"]').val(randomNumber(90, 99, 1));

            // Elektrolit
            $('[name="na"]').val(randomNumber(135, 145, 1));
            $('[name="k"]').val(randomNumber(3.5, 5.5, 1));
            $('[name="cl"]').val(randomNumber(98, 108, 1));

            // Fungsi Ginjal
            $('[name="ureum"]').val(randomNumber(15, 40, 1));
            $('[name="creatinin"]').val(randomNumber(0.6, 1.3, 2));

            // Hematologi
            $('[name="hb"]').val(randomNumber(11, 17, 1));
            $('[name="ht"]').val(randomNumber(35, 50, 1));
            $('[name="leukosit"]').val(randomNumber(4, 11, 2));
            $('[name="trombosit"]').val(randomNumber(150, 400));

            // Fungsi Hati
            $('[name="sgot"]').val(randomNumber(10, 40, 1));
            $('[name="sgpt"]').val(randomNumber(10, 40, 1));

            // Parameter Tambahan
            $('[name="kdgs"]').val(randomNumber(80, 180));

            const terapiOksigen = ["Nasal Kanula 2 lpm", "Nasal Kanula 4 lpm",
                "Non-Rebreathing Mask 10 lpm", "Simple Mask 6 lpm", "Ventilator"
            ];
            $('[name="terapi_oksigen"]').val(randomItem(terapiOksigen));
            $('[name="albumin"]').val(randomNumber(3.5, 5.0, 1));

            const kesadaran = ["", "compos_mentis", "somnolence", "sopor", "coma", "delirium"];
            $('[name="kesadaran"]').val(randomItem(kesadaran));

            // Ventilator Parameters
            const ventModes = ["SIMV", "CPAP", "BiPAP", "AC", "PC", "PSV"];
            $('[name="ventilator_mode"]').val(randomItem(ventModes));
            $('[name="ventilator_mv"]').val(randomNumber(6, 12, 1));
            $('[name="ventilator_tv"]').val(randomNumber(350, 650));
            $('[name="ventilator_fio2"]').val(randomNumber(21, 80));

            const ieRatios = ["1:2", "1:1.5", "1:3", "1:4"];
            $('[name="ventilator_ie_ratio"]').val(randomItem(ieRatios));
            $('[name="ventilator_pmax"]').val(randomNumber(15, 30));
            $('[name="ventilator_peep_ps"]').val(randomNumber(5, 12));

            // Medical Devices
            const ettSizes = ["7.0", "7.5", "8.0", "8.5"];
            const ngtSizes = ["14", "16", "18"];
            const cvcTypes = ["Subclavian", "Jugularis", "Femoralis", ""];
            const ivLineTypes = ["Perifer", "Central", "PICC", ""];

            $('[name="ett_no"]').val(randomItem(ettSizes));
            $('[name="batas_bibir"]').val(randomNumber(19, 24, 1));
            $('[name="ngt_no"]').val(randomItem(ngtSizes));
            $('[name="cvc"]').val(randomItem(cvcTypes));
            $('[name="urine_catch_no"]').val(randomNumber(14, 18));
            $('[name="iv_line"]').val(randomItem(ivLineTypes));

            // Trigger input events to calculate derived values
            $('#sistolik, #diastolik').trigger('input');
            $('.gcs-component').trigger('change');
        });

        ///===============================================================================================//
        // Add random data generation button to the form
        ///===============================================================================================//


    });
</script>
