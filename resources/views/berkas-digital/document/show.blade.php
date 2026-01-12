@extends('layouts.administrator.master')

@section('content')
    <x-content-card>
        <div style="height: 100vh; overflow-y: auto;">
            @if ($asesmen)
                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.print')
            @else
                <p>Data asesmen tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($pengkajianAsesmen)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.print', [
                    'data' => [
                        'asesmen' => $pengkajianAsesmen,
                        'dataMedis' => $dataMedis,
                        'rmeMasterDiagnosis' => $rmeMasterDiagnosis,
                        'rmeMasterImplementasi' => $rmeMasterImplementasi,
                        'satsetPrognosis' => $satsetPrognosis,
                        'alergiPasien' => $alergiPasien,
                    ]
                ])
            @else
                <p>Data pengkajian awal medis tidak ditemukan untuk kunjungan ini.</p>
            @endif
        </div>
    </x-content-card>
    <x-content-card>
        <h4>Riwayat Akses Berkas Digital</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Jenis Kertas</th>
                    <th>Nama File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($listDokumen as $i => $dokumen)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $dokumen->jenisBerkas->nama_berkas ?? '-' }}</td>
                        <td>
                            @if ($dokumen->file)
                                <a href="{{ asset('storage/' . $dokumen->file) }}"
                                    target="_blank">{{ basename($dokumen->file) }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($dokumen->file)
                                <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank"
                                    class="btn btn-primary btn-sm">Lihat</a>
                                <form action="{{ route('berkas-digital.dokumen.destroy', $dokumen->id) }}" method="post"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm" data-confirm
                                        data-confirm-title="Anda yakin?"
                                        data-confirm-text="Data yang dihapus tidak dapat dikembalikan" title="Hapus berkas"
                                        aria-label="Hapus berkas">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-content-card>
@endsection

@push('js')
    <script src="{{ asset('js/helpers/confirm.js') }}"></script>
@endpush
