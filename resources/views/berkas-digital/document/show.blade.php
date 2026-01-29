@extends('layouts.administrator.master')

@section('content')
    <x-content-card>
        <div style="height: 150vh; overflow-y: auto; display: flex; flex-direction: column; gap: 50px;">
            @if ($asesmen)
                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.print', [
                    'asesmen' => $asesmen,
                    'triase' => $triase,
                    'riwayatAlergi' => $riwayatAlergi,
                    'laborData' => $laborData,
                    'radiologiData' => $radiologiData,
                    'riwayatObat' => $riwayatObat,
                    'retriaseData' => $retriaseData,
                ])
            @else
                <p>Data asesmen IGD tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($triaseIGD)
                @include('unit-pelayanan.rawat-inap.pelayanan.triase.print', [
                    'dataMedis' => $dataMedis,
                    'triase' => $triaseIGD,
                ])
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
                    ],
                ])
            @else
                <p>Data pengkajian awal medis tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if (!empty($resume))
                @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.print')
            @else
                <p>Data resume medis tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenKeperawatan)
                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.print-pdf')
            @else
                <p>Data asesmen keperawatan tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenNeurologi)
                @include('unit-pelayanan.rawat-inap.pelayanan.neurologi.print', [
                    'asesmen' => $asesmenNeurologi,
                    'dataMedis' => $dataMedis,
                    'rmeMasterDiagnosis' => $rmeMasterDiagnosisNeurologi,
                    'rmeMasterImplementasi' => $rmeMasterImplementasiNeurologi,
                    'satsetPrognosis' => $satsetPrognosisNeurologi,
                    'alergiPasien' => $alergiPasienNeurologi,
                    'itemFisik' => $itemFisik,
                ])
            @else
                <p>Data asesmen neurologi tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenOpthamology)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.print', [
                    'data' => [
                        'asesmen' => $asesmenOpthamology,
                        'faktorpemberat' => $faktorpemberatOpthamology,
                        'menjalar' => $menjalarOpthamology,
                        'frekuensinyeri' => $frekuensinyeriOpthamology,
                        'kualitasnyeri' => $kualitasnyeriOpthamology,
                        'faktorperingan' => $faktorperinganOpthamology,
                        'efeknyeri' => $efeknyeriOpthamology,
                        'jenisnyeri' => $jenisnyeriOpthamology,
                        'itemFisik' => $itemFisikOpthamology,
                        'rmeMasterDiagnosis' => $rmeMasterDiagnosisOpthamology,
                        'rmeMasterImplementasi' => $rmeMasterImplementasiOpthamology,
                        'satsetPrognosis' => $satsetPrognosisOpthamology,
                        'dataMedis' => $dataMedis,
                    ],
                ])
            @else
                <p>Data asesmen opthamology tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenMedisAnak)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-anak.print', [
                    'data' => [
                        'asesmen' => $asesmenMedisAnak,
                        'dataMedis' => $dataMedis,
                        'rmeMasterDiagnosis' => $rmeMasterDiagnosisMedisAnak,
                        'rmeMasterImplementasi' => $rmeMasterImplementasiMedisAnak,
                        'satsetPrognosis' => $satsetPrognosisMedisAnak,
                        'alergiPasien' => $alergiPasienMedisAnak,
                    ],
                ])
            @else
                <p>Data asesmen medis anak tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenObstetri)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.print', [
                    'asesmen' => $asesmenObstetri,
                    'dataMedis' => $dataMedis,
                    'rmeMasterDiagnosis' => $rmeMasterDiagnosisObstetri,
                    'rmeMasterImplementasi' => $rmeMasterImplementasiObstetri,
                    'satsetPrognosis' => $satsetPrognosisObstetri,
                    'alergiPasien' => $alergiPasienObstetri,
                ])
            @else
                <p>Data asesmen obstetri tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenTht)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.print', [
                    'asesmen' => $asesmenTht,
                    'dataMedis' => $dataMedis,
                    'rmeMasterDiagnosis' => $rmeMasterDiagnosisTht,
                    'rmeMasterImplementasi' => $rmeMasterImplementasiTht,
                    'satsetPrognosis' => $satsetPrognosisTht,
                    'alergiPasien' => $alergiPasienTht,
                    'itemFisik' => $itemFisikTht,
                ])
            @else
                <p>Data asesmen THT tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenParu)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.print', [
                    'asesmen' => $asesmenParu,
                    'dataMedis' => $dataMedis,
                    'satsetPrognosis' => $satsetPrognosisParu,
                    'KebiasaanData' => $KebiasaanData,
                ])
            @else
                <p>Data asesmen paru tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenGinekologik)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.print', [
                    'asesmen' => $asesmenGinekologik,
                    'pasien' => $pasien,
                    'dataMedis' => $dataMedis,
                    'rmeAsesmenGinekologik' => $rmeAsesmenGinekologik,
                    'rmeAsesmenGinekologikTandaVital' => $rmeAsesmenGinekologikTandaVital,
                    'rmeAsesmenGinekologikPemeriksaanFisik' => $rmeAsesmenGinekologikPemeriksaanFisik,
                    'rmeAsesmenGinekologikEkstremitasGinekologik' => $rmeAsesmenGinekologikEkstremitasGinekologik,
                    'rmeAsesmenGinekologikPemeriksaanDischarge' => $rmeAsesmenGinekologikPemeriksaanDischarge,
                    'rmeAsesmenGinekologikDiagnosisImplementasi' => $rmeAsesmenGinekologikDiagnosisImplementasi,
                    'satsetPrognosis' => $satsetPrognosisGinekologik,
                ])
            @else
                <p>Data asesmen ginekologik tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenPsikiatri)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-psikiatri.print', [
                    'asesmen' => $asesmenPsikiatri,
                    'asesmenPsikiatri' => $asesmenPsikiatriMain,
                    'asesmenPsikiatriDtl' => $asesmenPsikiatriDtl,
                    'alergiPasien' => $alergiPasienPsikiatri,
                    'pasien' => $pasien,
                    'dataMedis' => $dataMedis,
                ])
            @else
                <p>Data asesmen psikiatri tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenGeriatriData)
                @include(
                    'unit-pelayanan.rawat-inap.pelayanan.asesmen-geriatri.print',
                    $asesmenGeriatriData)
            @else
                <p>Data asesmen geriatri tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenMedisNeonatologi)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-neonatologi.print', [
                    'asesmen' => $asesmenMedisNeonatologi,
                    'dataMedis' => $dataMedis,
                    'rmeMasterDiagnosis' => $rmeMasterDiagnosisMedisNeonatologi,
                    'rmeMasterImplementasi' => $rmeMasterImplementasiMedisNeonatologi,
                    'satsetPrognosis' => $satsetPrognosisMedisNeonatologi,
                    'alergiPasien' => $alergiPasienMedisNeonatologi,
                ])
            @else
                <p>Data asesmen medis neonatologi tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenKepAnak)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.print', [
                    'data' => [
                        'asesmen' => $asesmenKepAnak,
                        'dataMedis' => $dataMedis,
                    ],
                ])
            @else
                <p>Data asesmen keperawatan anak tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenKepPerinatology)
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.print', [
                    'data' => [
                        'asesmen' => $asesmenKepPerinatology,
                        'dataMedis' => $dataMedis,
                    ],
                ])
            @else
                <p>Data asesmen keperawatan perinatology tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenKeperawatanTerminal['asesmen'])
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-terminal.print', [
                    'data' => $asesmenKeperawatanTerminal,
                ])
            @else
                <p>Data asesmen keperawatan terminal tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($asesmenAwalKeperawatanDewasa['asesmen'])
                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.print-pdf', [
                    'data' => $asesmenAwalKeperawatanDewasa,
                ])
            @else
                <p>Data asesmen awal keperawatan dewasa tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($ewsRecords->isNotEmpty())
                @include('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.print', [
                    'ewsRecords' => $ewsRecords,
                    'ewsPasienDewasa' => $ewsPasienDewasa,
                    'dataMedis' => $dataMedis,
                ])
            @else
                <p>Data EWS Pasien Dewasa tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($ewsRecordsAnak->isNotEmpty())
                @include('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-anak.print', [
                    'ewsRecords' => $ewsRecordsAnak,
                    'eWSPasienAnak' => $ewsPasienAnak,
                    'dataMedis' => $dataMedis,
                ])
            @else
                <p>Data EWS Pasien Anak tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($ewsRecordsObstetrik->isNotEmpty())
                @include('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-obstetrik.print', [
                    'ewsRecords' => $ewsRecordsObstetrik,
                    'ewsPsienObstetrik' => $ewsPasienObstetrik,
                    'dataMedis' => $dataMedis,
                ])
            @else
                <p>Data EWS Pasien Obstetrik tidak ditemukan untuk kunjungan ini.</p>
            @endif


            {{-- Surat-surat menu lainnya --}}
            @if ($suratKematian)
                @include('unit-pelayanan.rawat-inap.pelayanan.surat-kematian.print', [
                    'suratKematian' => $suratKematian,
                    'dataMedis' => $dataMedis,
                ])
            @else
                <p>Data surat kematian tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($pernyataanDPJP->isNotEmpty())
                @foreach ($pernyataanDPJP as $dpjpItem)
                    @include('unit-pelayanan.rawat-inap.pelayanan.pernyataan-bpjp.print', [
                        'pernyataanDPJP' => $dpjpItem,
                        'dataMedis' => $dataMedis,
                        'tanggalLengkap' => \Illuminate\Support\Carbon::now()->locale('id')->translatedFormat('d F Y'),
                    ])
                @endforeach
            @else
                <p>Data pernyataan DPJP tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($penundaanPelayanan->isNotEmpty())
                @foreach ($penundaanPelayanan as $penundaanItem)
                    @include('unit-pelayanan.rawat-inap.pelayanan.penundaan.pdf', [
                        'penundaan' => $penundaanItem,
                        'dataMedis' => $dataMedis,
                    ])
                @endforeach
            @else
                <p>Data penundaan pelayanan tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($paps->isNotEmpty())
                @foreach ($paps as $papsItem)
                    @include('unit-pelayanan.rawat-inap.pelayanan.paps.pdf', [
                        'paps' => $papsItem,
                        'dataMedis' => $dataMedis,
                    ])
                @endforeach
            @else
                <p>Data PAPS tidak ditemukan untuk kunjungan ini.</p>
            @endif
            @if (isset($meninggalkanPerawatan) && $meninggalkanPerawatan->isNotEmpty())
                @foreach ($meninggalkanPerawatan as $pernyataan)
                    @include('unit-pelayanan.rawat-inap.pelayanan.meninggalkan-perawatan.pdf', [
                        'pernyataan' => $pernyataan,
                        'dataMedis' => $dataMedis,
                    ])
                @endforeach
            @else
                <p>Data surat meninggalkan perawatan tidak ditemukan untuk kunjungan ini.</p>
            @endif

            @if ($rohani->isNotEmpty())
                @foreach ($rohani as $rohaniItem)
                    @include('unit-pelayanan.rawat-inap.pelayanan.rohani.pdf', [
                        'rohani' => $rohaniItem,
                        'dataMedis' => $dataMedis,
                    ])
                @endforeach
            @else
                <p>Data permintaan pelayanan rohani tidak ditemukan untuk kunjungan ini.</p>
            @endif
            @if ($privasi->isNotEmpty())
                @foreach ($privasi as $privasiItem)
                    @include('unit-pelayanan.rawat-inap.pelayanan.privasi.pdf', [
                        'privasi' => $privasiItem,
                        'dataMedis' => $dataMedis,
                    ])
                @endforeach
            @else
                <p>Data permintaan privasi tidak ditemukan untuk kunjungan ini.</p>
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
