{{-- @extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            
            <form id="asesmenForm" method="POST" action="{{ route('asesmen-keperawatan.update', [
                'kd_pasien' => $dataMedis->kd_pasien,
                'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'),
                'id' => $asesmen->id
            ]) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="urut_masuk" value="{{ $asesmen->urut_masuk }}">
                
                <!-- The rest of the form fields remain similar but use the $asesmen object to populate values -->
                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <div class="px-3">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Asesmen</label>
                                            <input type="date" name="tgl_masuk" id="tgl_asesmen_keperawatan"
                                                class="form-control" value="{{ old('tgl_masuk', $asesmen->tgl_masuk) }}">
                                        </div>
                                    </div>
                                    <!-- Continue with all other form fields, populating with $asesmen values -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="simpan">Update</button>
                </div>
            </form>
        </div>
    </div>

    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.modal-tindakankeperawatan')
@endsection --}}