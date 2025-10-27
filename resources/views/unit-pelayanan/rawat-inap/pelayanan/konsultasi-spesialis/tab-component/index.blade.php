<ul class= "nav d-flex"id="myTab" role="tablist">
    <li class="nav-item">
       <form action="{{ route('rawat-inap.konsultasi-spesialis.index',[ $dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk ]) }}">
            @method('get')  
            <button class="nav-link {{ $active == 1 ? 'active' : '' }} fw-bold" id="PermintaanKonsul" data-bs-toggle="tab" data-bs-target="#resep"
                type="submit" role="tab" aria-controls="resep" aria-selected="true" name="category" value="Minta">
                Permintaan
            </button>
       </form>
    </li>
    <li class="nav-item">
       <form action="{{ route('rawat-inap.konsultasi-spesialis.index',[ $dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk ]) }}">
            @method('get') 
            <button class="nav-link {{ $active == 2 ? 'active' : '' }} fw-bold" id="TerimaKonsul" data-bs-toggle="tab" data-bs-target="#resep"
                type="submit" role="tab" aria-controls="resep" aria-selected="true" name="category" value="Terima">
                Terima
            </button>
       </form>
    </li>
</ul>

