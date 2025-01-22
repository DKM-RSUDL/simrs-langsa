<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link text-dark" href="#">Persetujuan Tindakan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark"
            href="{{ route('operasi.pelayanan', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">Asesmen
            Pra Operasi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark"
            href="{{ route('operasi.pelayanan.asesmen-pra-anestesi', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">Asesmen
            Pra Anestesi dan Sedasi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark"
            href="{{ route('operasi.pelayanan.asesmen-pra-operasi', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">Asesmen
            Pra Operasi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark"
            href="{{ route('operasi.pelayanan.ceklist-keselamatan-operasi', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">Ceklist
            Keselamatan Pasien Operasi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark"
            href="{{ route('operasi.pelayanan.laporan-operasi', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">Laporan
            Operasi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-dark"
            href="{{ route('operasi.pelayanan.catatan-intra-operasi', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">Catatan
            Intra dan Pasca Operasi</a>
    </li>
</ul>
