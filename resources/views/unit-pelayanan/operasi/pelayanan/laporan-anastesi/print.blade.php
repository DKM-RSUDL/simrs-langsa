@php use Illuminate\Support\Str; @endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catatan Keperawatan Intra Operasi</title>
    <style>
        @page {
            size: A4 portrait;

        }



        /* CHECKBOX RATA TENGAH DENGAN LABEL */
        input[type="checkbox"] {
            width: 13px;
            height: 13px;
            margin: 0 4px 0 5px !important;
            padding: 0;
            vertical-align: middle !important;
            position: relative;
            top: -1px;
            /* fine-tune biar 100% rata di semua browser */
        }

        input[type="text"] {
            border: none;
            border-bottom: 1px dotted #333;
            font-size: 9pt;
            padding: 1px 3px;
            background: transparent;
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <table>
                <tr>
                    <td>1.</td>
                    <td>Time Out</td>

                    <td>
                        {{ $laporanAnastesi->time_out == 1 ? 'Ya' : 'Tidak' }}
                        @if ($laporanAnastesi->jam_time_out)
                            ({{ date('H:i', strtotime($laporanAnastesi->jam_time_out)) }})
                        @endif
                    </td>

                    <td>
                        {{-- Jika butuh centang otomatis, bisa tambahkan di sini --}}
                    </td>
                </tr>

            </table>
        </tr>
        <tr>
            <table>
                <tr>
                    <td>2.</td>
                    <td>Cek ketersediaan peralatan dan fungsinya,</td>
                    <td></td>
                </tr>

                {{-- a. Instrument --}}
                <tr>
                    <td></td>
                    <td>a. Instrument</td>
                    <td>
                        <input type="checkbox" {{ $laporanAnastesiDtl->instrument == 1 ? 'checked' : '' }}>
                        Ya. Jam
                        @if ($laporanAnastesiDtl->instrument_time)
                            {{ date('H:i', strtotime($laporanAnastesiDtl->instrument_time)) }}
                        @else
                            <span>.........</span>
                        @endif
                    </td>
                    <td>
                        <input type="checkbox" {{ $laporanAnastesiDtl->instrument != 1 ? 'checked' : '' }}>
                        Tidak
                    </td>
                </tr>

                {{-- b. Prothese / Implant --}}
                <tr>
                    <td></td>
                    <td>b. Prothese/ Implant</td>
                    <td>
                        <input type="checkbox" {{ $laporanAnastesiDtl->prothese == 1 ? 'checked' : '' }}>
                        Ya. Jam
                        @if ($laporanAnastesiDtl->prothese_time)
                            {{ date('H:i', strtotime($laporanAnastesiDtl->prothese_time)) }}
                        @else
                            <span>.........</span>
                        @endif
                    </td>
                    <td>
                        <input type="checkbox" {{ $laporanAnastesiDtl->prothese != 1 ? 'checked' : '' }}>
                        Tidak
                    </td>
                </tr>

                {{-- Pukul --}}
                <tr>
                    <td></td>
                    <td>Pukul :</td>
                    <td><input type="text" style="width:70px;"></td>
                    <td>Selesai : <input type="text" style="width:70px;"></td>
                </tr>
            </table>

        </tr>

        <tr>
            <td colspan="4" style="padding:10px 0;">
                <strong>
                    Dilakukan Operasi / Jenis Operasi :
                    <span style="min-width:380px;display:inline-block;border-bottom:1px solid #000;">
                        {{ $laporanAnastesi->product?->deskripsi }} / {{ $laporanAnastesi->tipe_operasi }}
                    </span>
                </strong>
            </td>
        </tr>


        <tr>
            <table>
                <tr>
                    <td>Tipe Operasi</td>
                    <td></td>
                    <td><label>Efektif <input type="checkbox" {{ $laporanAnastesi->tipe_operasi == 'Efektif' ? 'checked' : '' }}></label></td>
                    <td></td>
                    <td><label>Darurat <input type="checkbox" {{ $laporanAnastesi->tipe_operasi == 'Darurat' ? 'checked' : '' }}></label></td>
                    <td></td>
                    <td><label>Operasi ADC <input type="checkbox" {{ $laporanAnastesi->tipe_operasi == 'Operasi ADC' ? 'checked' : '' }}></label></td>
                </tr>
            </table>
        </tr>

        <tr>
            <table border="1" style="width:100%; border-collapse:collapse; font-size:11px;">
                <tbody style="font-size:11px;">

                    <!-- 1–10 (punyamu yang sudah rapi) -->
                    <tr>
                        <td style="width:30px; padding:5px 2px;">1.</td>
                        <td style="width:200px; padding:5px 2px;">Tingkat Kesadaran Waktu Masuk Kamar Operasi</td>
                        <td style="width:150px; padding:5px 2px;"><input type="checkbox"> Terjaga</td>
                        <td style="width:170px; padding:5px 2px;"><input type="checkbox"> Mudah dibangunkan</td>
                        <td style="padding:5px 2px;"><input type="checkbox"> Lain-lain</td>
                    </tr>

                    <tr>
                        <td style="padding:5px 2px;">2.</td>
                        <td style="padding:5px 2px;">Tipe Pembiusan</td>
                        <td style="padding:5px 2px;"><input type="checkbox"> Umum</td>
                        <td style="padding:5px 2px;"><input type="checkbox"> Lokal</td>
                        <td style="padding:5px 2px;"><input type="checkbox"> Regional</td>
                    </tr>

                    <tr>
                        <td style="padding:5px 2px;">3.</td>
                        <td style="padding:5px 2px;">Posisi Kanula Intra Vena</td>

                        <!-- TANGAN -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ Str::contains($laporanAnastesi->posisi_kanula, 'tangan') || Str::contains($laporanAnastesi->posisi_kanula, 'Tangan') ? 'checked' : '' }}>
                            Tangan Kanan/Kiri
                        </td>

                        <!-- KAKI -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ Str::contains($laporanAnastesi->posisi_kanula, 'kaki') || Str::contains($laporanAnastesi->posisi_kanula, 'Kaki') ? 'checked' : '' }}>
                            Kaki Kanan/Kiri
                        </td>

                        <!-- ARTERIAL LINE -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ Str::contains($laporanAnastesi->posisi_kanula, 'arterial') || Str::contains($laporanAnastesi->posisi_kanula, 'Arterial') ? 'checked' : '' }}>
                            Arterial Line
                        </td>
                    </tr>


                    <tr>
                        <td style="padding:5px 2px;">4.</td>
                        <td style="padding:5px 2px;">Posisi Operasi (Diawasi Oleh ______)</td>
                        <td style="padding:5px 2px;"><input type="checkbox"> Telentang</td>
                        <td style="padding:5px 2px;"><input type="checkbox"> Lithotomy</td>
                        <td style="padding:5px 2px;"><input type="checkbox"> Tengkurap</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td style="padding-left:20px; padding:5px 2px;">Tambahan Posisi</td>
                        <td style="padding:5px 2px;"><input type="checkbox"> Lateral Ka/Ki</td>
                        <td colspan="2" style="padding:5px 2px;">
                            <input type="checkbox"> Lain-lain
                            <input type="text" style="width:120px; font-size:11px;">
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding:5px 2px;">5.</td>
                        <td style="padding:5px 2px;">Posisi Lengan</td>

                        <!-- Lengan Terentang -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ Str::contains($laporanAnastesi->posisi_pasien, ['Telentang','Terentang']) ? 'checked' : '' }}>
                            Lengan Terentang Ka/Ki
                        </td>

                        <!-- Lengan Terlipat -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ Str::contains($laporanAnastesi->posisi_pasien, ['Terlipat','Telipat']) ? 'checked' : '' }}>
                            Lengan Terlipat Ka/Ki
                        </td>
                        @php
                            $isElse = !Str::contains($laporanAnastesi->posisi_pasien, ['Terlipat','Telipat','Telentang','Terentang']);
                        @endphp
                        <!-- Lain-lain -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" >
                            Lain-lain : <span style="underline : display" {{ $isElse ? 'checked' : '' }}>{{$isElse ?? $laporanAnastesi->posisi_pasien }}</span>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding:5px 2px;">6.</td>
                        <td style="padding:5px 2px;">Posisi Alat Bantu Yang Digunakan</td>
                        <td colspan="2" style="padding:5px 2px;"><input type="checkbox"> Papan Lengan Penyanggah</td>
                        <td style="padding:5px 2px;">
                            <input type="checkbox"> Lain-lain
                            <input type="text" style="font-size:11px;">
                        </td>
                    </tr>

                                    <tr>
                        <td style="padding:5px 2px;">7.</td>
                        <td style="padding:5px 2px;">Memakai Kateter Urin</td>

                        <!-- YA -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox"
                                {{ $laporanAnastesi->pemasangan_kater_urin == 1 ? 'checked' : '' }}>
                            Ya
                        </td>

                        <!-- TIDAK -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox"
                                {{ $laporanAnastesi->pemasangan_kater_urin == 0 ? 'checked' : '' }}>
                            Tidak
                        </td>

                        <!-- Pilihan lokasi jika YA -->
                       
                        <td style="padding:5px 2px;">
                            Jika Ya:
                            <input type="checkbox"
                                {{ $laporanAnastesi->dilakukan_kater === 'Kamar Operasi' ? 'checked' : '' }}>
                            Kamar Operasi

                            <input type="checkbox"
                                {{ $laporanAnastesi->dilakukan_kater === 'Ruangan' ? 'checked' : '' }}>
                            Ruangan
                        </td>
                    </tr>


                                    <tr>
                        <td style="padding:5px 2px;">8.</td>
                        <td style="padding:5px 2px;">Persiapan Kulit</td>

                        <!-- Chlorhexidine / 70% -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox"
                                {{ Str::contains($laporanAnastesi->persiapan_kulit, ['Chlorhexidine','70%']) ? 'checked' : '' }}>
                            Chlorhexidine / 70%
                        </td>

                        <!-- Povidone-Iodine / Hibiscrub -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox"
                                {{ Str::contains($laporanAnastesi->persiapan_kulit, ['Povidone','Hibiscrub']) ? 'checked' : '' }}>
                            Povidone-Iodine / Hibiscrub
                        </td>

                        @php
                            $isElsePK = !Str::contains($laporanAnastesi->persiapan_kulit, [
                                'Chlorhexidine','70%','Povidone','Hibiscrub'
                            ]);
                        @endphp

                        <!-- Lain-lain -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isElsePK ? 'checked' : '' }}>
                            Lain-lain :
                            <span style="text-decoration: underline;">
                                {{ $isElsePK ? $laporanAnastesi->persiapan_kulit : '' }}
                            </span>
                        </td>
                    </tr>
                   


                   <tr>
                        <td style="padding:5px 2px;">9.</td>
                        <td style="padding:5px 2px;">Pemakaian Diathermy</td>

                        <!-- Tidak -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" 
                                {{ $laporanAnastesiDtl->pemakaian_diathermy == 'Tidak' ? 'checked' : '' }}>
                            Tidak
                        </td>

                        <!-- Monopolar -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" 
                                {{  $laporanAnastesiDtl->pemakaian_diathermy == 1 && $laporanAnastesiDtl->lokasi_diathermy == 'Monopolar' ? 'checked' : '' }}>
                            Monopolar
                        </td>

                        <!-- Bipolar -->
                        <td>
                            <div>
                                
                                 <div style="padding:5px 2px;">
                                    <input type="checkbox" 
                                        {{  $laporanAnastesiDtl->pemakaian_diathermy == 1 && $laporanAnastesiDtl->lokasi_diathermy == 'Bipolar' ? 'checked' : '' }}>
                                    Bipolar
                                 </div>
                                <div style="padding:5px 2px;">
                                    <input type="checkbox" 
                                        {{  $laporanAnastesiDtl->pemakaian_diathermy == 1 && !Str::contains($laporanAnastesiDtl->lokasi_diathermy,['Bipolar','Monopolar']) ? 'checked' : '' }}>
                                    Lainya : <span>{{ $laporanAnastesiDtl->lokasi_diathermy }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>


                  @php
                        $val = $laporanAnastesiDtl->kode_elektrosurgical;

                        $isBokong = Str::contains($val, ['Bokong']);
                        $isPaha   = Str::contains($val, ['Paha']);

                        // jika bukan Bokong dan bukan Paha → berarti Lain-lain
                        $isLain = !$isBokong && !$isPaha;
                    @endphp

                    <tr>
                        <td></td>
                        <td style="padding-left:20px; padding:5px 2px;">• Lokasi Dispersive Electrode</td>

                        <!-- Bokong Ka/Ki -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isBokong ? 'checked' : '' }}>
                            Bokong Ka/Ki
                        </td>

                        <!-- Paha Ka/Ki -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isPaha ? 'checked' : '' }}>
                            Paha Ka/Ki
                        </td>

                        <!-- Lain-lain -->
                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isLain ? 'checked' : '' }}>
                            Lain-lain
                            <input type="text" style="font-size:11px; width:120px;"
                                value="{{ $isLain ? $val : '' }}">
                        </td>
                    </tr>


                                    @php
                        $valPra = $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pra_operasi;

                        $isUtuhPra = Str::contains($valPra, ['Utuh']);
                        $isBengkakPra = Str::contains($valPra, ['Menggelembung','Bengkak']);
                        $isLainPra = !$isUtuhPra && !$isBengkakPra;
                    @endphp

                    <tr>
                        <td></td>
                        <td style="padding-left:20px; padding:5px 2px;">• Pemeriksaan Kulit Sebelum Operasi</td>

                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isUtuhPra ? 'checked' : '' }}>
                            Utuh
                        </td>

                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isBengkakPra ? 'checked' : '' }}>
                            Menggelembung
                        </td>

                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isLainPra ? 'checked' : '' }}>
                            Lain-lain
                            <input type="text" style="font-size:11px; width:120px;"
                                value="{{ $isLainPra ? $valPra : '' }}">
                        </td>
                    </tr>


                                        @php
                        $valPra = $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pra_operasi;

                        $isUtuhPra = Str::contains($valPra, ['Utuh']);
                        $isBengkakPra = Str::contains($valPra, ['Menggelembung','Bengkak']);
                        $isLainPra = !$isUtuhPra && !$isBengkakPra;
                    @endphp

                    <tr>
                        <td></td>
                        <td style="padding-left:20px; padding:5px 2px;">• Pemeriksaan Kulit Sebelum Operasi</td>

                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isUtuhPra ? 'checked' : '' }}>
                            Utuh
                        </td>

                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isBengkakPra ? 'checked' : '' }}>
                            Menggelembung
                        </td>

                        <td style="padding:5px 2px;">
                            <input type="checkbox" {{ $isLainPra ? 'checked' : '' }}>
                            Lain-lain
                            <input type="text" style="font-size:11px; width:120px;"
                                value="{{ $isLainPra ? $valPra : '' }}">
                        </td>
                    </tr>


                    <tr>
                        <td></td>
                        <td style="padding:5px 2px;">(Kode Unit Electrosurgical {{ $laporanAnastesiDtl->kode_elektrosurgical }})</td>
                        <td colspan="3" style="padding:5px 2px;"><input type="checkbox"> Tidak</td>
                    </tr>

                    <tr>
                        <td style="padding:5px 2px;">10.</td>
                        <td style="padding:5px 2px;">Unit Pemanas / Pendingin Operasi</td>
                        <td style="padding:5px 2px;"><input type="checkbox" {{ $laporanAnastesiDtl->unit_pemasangan == 1 ? 'checked' : ''}}> Ya</td>
                        <td style="padding:5px 2px;"><input type="checkbox" {{ $laporanAnastesiDtl->unit_pemasangan == 0 ? 'checked' : ''}}> Tidak</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td colspan="4" style="padding:5px 2px;">
                            <span>Pengaturan temperatur mulai :   {{ $laporanAnastesiDtl->temperatur_mulai }} °C</span>
                            <br>
                            <span> (Kode Unit : {{ $laporanAnastesiDtl->kode_unit }})</span>
                            <br>
                            <span> Temperatur selesai : {{ $laporanAnastesiDtl->temperatur_selesai }}°C</span>
                           
                            
                        </td>
                    </tr>

                    <!-- =========================== -->
                    <!--        ROW 11–14 BARU       -->
                    <!-- =========================== -->

                    <!-- 11. Pemakaian Tourniguet -->
                  
                    <tr>
                        <td style="padding:5px 2px;">11.</td>
                        <td style="padding:5px 2px;">Pemakaian Tourniguet<br>(Diawasi oleh ______)</td>
                        <td style="padding:5px 2px;"><input type="checkbox" {{ !empty($laporanAnastesiDtl->pengawas_tomiquet) || $laporanAnastesiDtl->pengawas_tomiquet != null ? 'checked' : '' }}> Ya</td>
                        <td style="padding:5px 2px;"><input type="checkbox"  {{ empty($laporanAnastesiDtl->pengawas_tomiquet) || $laporanAnastesiDtl->pengawas_tomiquet == null ? 'checked' : '' }}> Tidak</td>
                        <td style="padding:5px 2px;"></td>
                    </tr>

                    <!-- Tabel lokasi -->
                    <tr>
                        <td></td>
                        <td colspan="4" style="padding:5px 2px;">
                            <table border="1" style="width:100%; border-collapse:collapse; font-size:11px;">
                                <tr>
                                    <th style="padding:4px;">Lokasi</th>
                                    <th style="padding:4px;">Waktu Mulai</th>
                                    <th style="padding:4px;">Waktu Selesai</th>
                                    <th style="padding:4px;">Tekanan</th>
                                </tr>

                                <!-- Lengan Kanan -->
                                @php
                                    $lkCheck = $laporanAnastesiDtl->lengan_kanan_mulai
                                            || $laporanAnastesiDtl->lengan_kanan_selesai
                                            || $laporanAnastesiDtl->lengan_kanan_tekanan;
                                @endphp
                                <tr>
                                    <td style="padding:4px;">
                                        <input type="checkbox" {{ $lkCheck ? 'checked' : '' }}> Lengan Kanan
                                    </td>
                                    <td>{{ $laporanAnastesiDtl->lengan_kanan_mulai ? date('H:i', strtotime($laporanAnastesiDtl->lengan_kanan_mulai)) : '' }}</td>
                                    <td>{{ $laporanAnastesiDtl->lengan_kanan_selesai ? date('H:i', strtotime($laporanAnastesiDtl->lengan_kanan_selesai)) : '' }}</td>
                                    <td>{{ $laporanAnastesiDtl->lengan_kanan_tekanan }}</td>
                                </tr>

                                <!-- Kaki Kanan -->
                                @php
                                    $kkCheck = $laporanAnastesiDtl->kaki_kanan_mulai
                                            || $laporanAnastesiDtl->kaki_kanan_selesai
                                            || $laporanAnastesiDtl->kaki_kanan_tekanan;
                                @endphp
                                <tr>
                                    <td style="padding:4px;">
                                        <input type="checkbox" {{ $kkCheck ? 'checked' : '' }}> Kaki Kanan
                                    </td>
                                    <td>{{ $laporanAnastesiDtl->kaki_kanan_mulai ? date('H:i', strtotime($laporanAnastesiDtl->kaki_kanan_mulai)) : '' }}</td>
                                    <td>{{ $laporanAnastesiDtl->kaki_kanan_selesai ? date('H:i', strtotime($laporanAnastesiDtl->kaki_kanan_selesai)) : '' }}</td>
                                    <td>{{ $laporanAnastesiDtl->kaki_kanan_tekanan }}</td>
                                </tr>

                                <!-- Lengan Kiri -->
                                @php
                                    $lkiCheck = $laporanAnastesiDtl->lengan_kiri_mulai
                                            || $laporanAnastesiDtl->lengan_kiri_selesai
                                            || $laporanAnastesiDtl->lengan_kiri_tekanan;
                                @endphp
                                <tr>
                                    <td style="padding:4px;">
                                        <input type="checkbox" {{ $lkiCheck ? 'checked' : '' }}> Lengan Kiri
                                    </td>
                                    <td>{{ $laporanAnastesiDtl->lengan_kiri_mulai ? date('H:i', strtotime($laporanAnastesiDtl->lengan_kiri_mulai)) : '' }}</td>
                                    <td>{{ $laporanAnastesiDtl->lengan_kiri_selesai ? date('H:i', strtotime($laporanAnastesiDtl->lengan_kiri_selesai)) : '' }}</td>
                                    <td>{{ $laporanAnastesiDtl->lengan_kiri_tekanan }}</td>
                                </tr>

                                <!-- Kaki Kiri -->
                                @php
                                    $kkiCheck = $laporanAnastesiDtl->kaki_kiri_mulai
                                            || $laporanAnastesiDtl->kaki_kiri_selesai
                                            || $laporanAnastesiDtl->kaki_kiri_tekanan;
                                @endphp
                                <tr>
                                    <td style="padding:4px;">
                                        <input type="checkbox" {{ $kkiCheck ? 'checked' : '' }}> Kaki Kiri
                                    </td>
                                    <td>{{ $laporanAnastesiDtl->kaki_kiri_mulai ? date('H:i', strtotime($laporanAnastesiDtl->kaki_kiri_mulai)) : '' }}</td>
                                    <td>{{ $laporanAnastesiDtl->kaki_kiri_selesai ? date('H:i', strtotime($laporanAnastesiDtl->kaki_kiri_selesai)) : '' }}</td>
                                    <td>{{ $laporanAnastesiDtl->kaki_kiri_tekanan }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- 12. Pemakaian Laser -->
                    <tr>
                        <td style="padding:5px 2px;">12.</td>
                        <td colspan="4" style="padding:5px 2px;">
                            Pemakaian Laser — Kode Model: 
                            <input type="text" style="width:200px; font-size:11px;" value={{  $laporanAnastesiDtl->kode_model ?? '-' }}>
                            <br>
                            (Diawasi oleh  <span style="underline : display;">  {{ $laporanAnastesiDtl->pengawas_laser }}</span> )
                        </td>
                    </tr>

                    <!-- 13. Pemakaian Implant -->
                    <tr>
                        <td style="padding:5px 2px;">13.</td>
                        <td style="padding:5px 2px;">Pemakaian Implant</td>
                        <td style="padding:5px 2px;"><input type="checkbox" {{  $laporanAnastesiDtl->pemakaian_implant == '1' ? 'checked' : '' }}> Ya</td>
                        <td style="padding:5px 2px;"><input type="checkbox"  {{  $laporanAnastesiDtl->pemakaian_implant == '0' ? 'checked' : '' }}> Tidak</td>
                        <td style="padding:5px 2px;"><input type="checkbox"> Kadaluwarsa ______________</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td style="padding:5px 2px;"><p><strong>Pabrik:</strong> {{ $laporanAnastesiDtl->pabrik }}</p>
                        </td>
                        <td style="padding:5px 2px;"> <p><strong>Size:</strong> {{ $laporanAnastesiDtl->size }}</p></td>
                        <td style="padding:5px 2px;">    <p><strong>Type:</strong> {{ $laporanAnastesiDtl->type }}</p></td>
                        <td style="padding:5px 2px;">  <p><strong>No Seri:</strong> {{ $laporanAnastesiDtl->no_seri }}</p>
                        </td>
                    </tr>

                    <!-- 14. Hitung Instrumen -->
                    <tr>
                        <td style="padding:5px 2px;">14.</td>
                        <td colspan="4" style="padding:5px 2px;">Hitung Instrumen / Kassa / Jarum</td>
                    </tr>

                </tbody>
            </table>



        </tr>
    </table>
    <br><br>

    <!-- Hitung Instrumen / Kassa / Jarum -->
    <table border="1" style="width:100%; border-collapse:collapse; font-size:11px;">
        <tr>
            <th style="padding:5px 2px;">Hitung</th>
            <th style="padding:5px 2px;">Kassa</th>
            <th style="padding:5px 2px;">Jarum</th>
            <th style="padding:5px 2px;">Instrumen</th>
        </tr>

        {{-- Hitung 1 --}}
        <tr>
            <td style="padding:5px 2px;">Hitung 1</td>
            <td style="padding:5px 2px;">Jumlah : {{ $laporanAnastesiDtl2->kassa_satu ?? '_________' }}</td>
            <td style="padding:5px 2px;">Jumlah : {{ $laporanAnastesiDtl2->jarum_satu ?? '_________' }}</td>
            <td style="padding:5px 2px;">Jumlah : {{ $laporanAnastesiDtl2->instrumen_satu ?? '_________' }}</td>
        </tr>

        {{-- Hitung 2 --}}
        <tr>
            <td style="padding:5px 2px;">Hitung 2</td>
            <td style="padding:5px 2px;">Jumlah : {{ $laporanAnastesiDtl2->kassa_dua ?? '_________' }}</td>
            <td style="padding:5px 2px;">Jumlah : {{ $laporanAnastesiDtl2->jarum_dua ?? '_________' }}</td>
            <td style="padding:5px 2px;">Jumlah : {{ $laporanAnastesiDtl2->instrumen_dua ?? '_________' }}</td>
        </tr>

        {{-- Hitung 3 --}}
        <tr>
            <td style="padding:5px 2px;">Hitung 3</td>
            <td style="padding:5px 2px;">Jumlah : {{ $laporanAnastesiDtl2->kassa_tiga ?? '_________' }}</td>
            <td style="padding:5px 2px;">Jumlah : {{ $laporanAnastesiDtl2->jarum_tiga ?? '_________' }}</td>
            <td style="padding:5px 2px;">Jumlah : {{ $laporanAnastesiDtl2->instrumen_tiga ?? '_________' }}</td>
        </tr>

        {{-- Checkbox bagian bawah --}}
        <tr>
            <td></td>

            <td style="padding:5px 2px;">
                <input type="checkbox" {{ $laporanAnastesiDtl2->kassa_tidak_lengkap ? 'checked' : '' }}> Tidak Lengkap <br>
                <input type="checkbox" {{ $laporanAnastesiDtl2->kassa_tidak_perlu ? 'checked' : '' }}> Tidak Perlu
            </td>

            <td style="padding:5px 2px;">
                <input type="checkbox" {{ $laporanAnastesiDtl2->jarum_tidak_lengkap ? 'checked' : '' }}> Tidak Lengkap <br>
                <input type="checkbox" {{ $laporanAnastesiDtl2->jarum_tidak_perlu ? 'checked' : '' }}> Tidak Perlu
            </td>

            <td style="padding:5px 2px;">
                <input type="checkbox" {{ $laporanAnastesiDtl2->instrumen_tidak_lengkap ? 'checked' : '' }}> Tidak Lengkap <br>
                <input type="checkbox" {{ $laporanAnastesiDtl2->instrumen_tidak_perlu ? 'checked' : '' }}> Tidak Perlu
            </td>
        </tr>
    </table>


    <br>

    <!-- Hitungan ACC -->
   <p style="font-size:12px;">
    Hitungan ACC oleh Dokter Bedah,<br>
    Tanda tangan dan Nama jelas : ___________________________________________<br><br>

    Catatan:<br>
    Jika dihitung tidak lengkap, setelah dicari tidak ditemukan → X-Ray:
    <input type="checkbox" {{ $laporanAnastesiDtl2->dilakukan_xray == 1 ? 'checked' : '' }}> Ya
    <input type="checkbox" {{ $laporanAnastesiDtl2->dilakukan_xray == 0 ? 'checked' : '' }}> Tidak<br>

    Bila lengkap, Dokter Bedah langsung tanda tangan.<br><br>

    Penggunaan tampon :
    <input type="checkbox" {{ $laporanAnastesiDtl2->penggunaan_tampon == 1 ? 'checked' : '' }}> Ya
    <input type="checkbox" {{ $laporanAnastesiDtl2->penggunaan_tampon == 0 ? 'checked' : '' }}> Tidak

    {{-- Jika YA, tampilkan jenis tampon --}}
    @if ($laporanAnastesiDtl2->penggunaan_tampon == 1)
        Jenis tampon: {{ $laporanAnastesiDtl2->jenis_tampon }}
    @else
        Jenis tampon __________________
    @endif
</p>

    <br>

    <!-- Pemakaian Drain -->
    <p style="font-size:12px;"><b>15. Pemakaian Drain</b></p>

    <table border="1" style="width:100%; border-collapse:collapse; font-size:12px;">
        <tr>
            <th style="padding:5px 2px;">TIPE DRAIN</th>
            <th style="padding:5px 2px;">JENIS DRAIN</th>
            <th style="padding:5px 2px;">UKURAN</th>
            <th style="padding:5px 2px;">KETERANGAN</th>
        </tr>

        @php
            // Ambil hanya data yang ada isinya
            $filteredDrain = collect($drainData)->filter(function ($d) {
                return !empty($d['tipe_drain']) ||
                    !empty($d['jenis_drain']) ||
                    !empty($d['ukuran']) ||
                    !empty($d['keterangan']);
            });

            $rowCount = max(2, $filteredDrain->count()); // minimal 2 baris, lebih jika data lebih banyak
        @endphp

        @for ($i = 0; $i < $rowCount; $i++)
            @php
                // Ambil data per baris jika ada
                $drain = $filteredDrain->values()->get($i);
            @endphp

            <tr>
                <td style="padding:2px 2px; height:35px;">{{ $drain['tipe_drain'] ?? '' }}</td>
                <td style="padding:2px 2px;">{{ $drain['jenis_drain'] ?? '' }}</td>
                <td style="padding:2px 2px;">{{ $drain['ukuran'] ?? '' }}</td>
                <td style="padding:2px 2px;">{{ $drain['keterangan'] ?? '' }}</td>
            </tr>
        @endfor
    </table>


    <br>

    <!-- Irigasi Luka -->
    {{-- ===================== --}}
{{-- 16. IRIGASI LUKA --}}
{{-- ===================== --}}
    @php
        // Data irigasi luka berupa string, contoh: "Sodium Chloride 0,9%, Antibiotik"
        $irigasi = strtolower($laporanAnastesiDtl2->irigasi_luka ?? '');

        function cekIrigasi($label, $irigasi) {
            return str_contains($irigasi, strtolower($label)) ? 'checked' : '';
        }
    @endphp

    <p style="font-size:12px;"><b>16. Irigasi Luka</b></p>

    <p style="font-size:12px;">
        <input type="checkbox" {{ cekIrigasi('Sodium Chloride', $irigasi) }}> Sodium Chloride 0,9% &nbsp;&nbsp;
        <input type="checkbox" {{ cekIrigasi('Anti Wolik Spray', $irigasi) }}> Anti Wolik Spray &nbsp;&nbsp;
        <input type="checkbox" {{ cekIrigasi('Antibiotik', $irigasi) }}> Antibiotik <br>

        <input type="checkbox" {{ cekIrigasi('H2O2', $irigasi) }}> H<sub>2</sub>O<sub>2</sub> &nbsp;&nbsp;
        <input type="checkbox" {{ cekIrigasi('Lain', $irigasi) }}> Lain-lain ____________________________
    </p>


    {{-- ===================== --}}
    {{-- 17. PEMAKAIAN CAIRAN --}}
    {{-- ===================== --}}
    @php
        $pemakaianCairan = json_decode($laporanAnastesiDtl2->pemakaian_cairan, true) ?: [];
        // Helper untuk cek apakah jenis cairan dipakai
        function cekCairan($jenis, $arr) {
            foreach ($arr as $item) {
                if (strtolower($item['jenis']) === strtolower($jenis)) {
                    return $item['jumlah'] ?? '';
                }
            }
            return null; // tidak ada
        }

        $glysin = cekCairan('Glysin', $pemakaianCairan);
        $bss = cekCairan('BSS Solution', $pemakaianCairan);
        $airIrigasi = cekCairan('Air untuk irigasi', $pemakaianCairan);
        $normalSaline = cekCairan('Sodium Chloride 0.9%', $pemakaianCairan);
    @endphp

    <p style="font-size:12px;"><b>17. Pemakaian Cairan</b></p>

    <p style="font-size:12px;">

        {{-- Glysin --}}
        <input type="checkbox" {{ $glysin !== null ? 'checked' : '' }}>
        Glysin: {{ $glysin !== null ? $glysin : '_______' }} Liter &nbsp;&nbsp;

        {{-- BSS --}}
        <input type="checkbox" {{ $bss !== null ? 'checked' : '' }}>
        BSS Solution <br>

        {{-- Air irigasi --}}
        Air untuk irigasi: {{ $airIrigasi !== null ? $airIrigasi : '_______' }} Liter <br>

        {{-- Sodium Chloride --}}
        <input type="checkbox" {{ $normalSaline !== null ? 'checked' : '' }}>
        Sodium Chloride 0.9%: {{ $normalSaline !== null ? $normalSaline : '_______' }} Liter &nbsp;&nbsp;

        {{-- Lain-lain --}}
        @php
            // ekstrak semua jenis lain-lain selain yang utama
            $known = ['glysin','bss solution','air untuk irigasi','sodium chloride 0.9%'];
            $lain2 = [];

            foreach ($pemakaianCairan as $item) {
                if (!in_array(strtolower($item['jenis']), $known)) {
                    $lain2[] = $item['jenis'] . ' (' . $item['jumlah'] . ' L)';
                }
            }
        @endphp

        <input type="checkbox" {{ count($lain2) > 0 ? 'checked' : '' }}>
        Lain-lain {{ count($lain2) > 0 ? implode(', ', $lain2) : '____________________________' }}

    </p>


    <!-- Alat-alat Terbungkus -->
    <p style="font-size:12px;"><b>18. Alat-alat Terbungkus</b></p>
    <p style="font-size:12px;">
        <input type="checkbox"> Tidak Ada &nbsp;&nbsp;
        <input type="checkbox"> Ada (Jenis: ____________________________) &nbsp;&nbsp;
        <input type="checkbox"> Lain-lain ____________________________
    </p>

    <!-- Balutan -->
    <p style="font-size:12px;"><b>19. Balutan</b></p>
    <p style="font-size:12px;">
        <input type="checkbox"> Tidak Ada &nbsp;&nbsp;
        <input type="checkbox"> Pressure &nbsp;&nbsp;
        (Jenis: ____________________________)
    </p>

    <!-- Spesimen -->
    <p style="font-size:12px;"><b>20. Spesimen</b></p>
    <p style="font-size:12px;">
        <input type="checkbox"> Histologi (Jenis __________) &nbsp;&nbsp;
        <input type="checkbox"> Kultur (Jenis __________) &nbsp;&nbsp;
        <input type="checkbox"> Frozen Section <br>

        <input type="checkbox"> Sitologi (Jenis __________) &nbsp;&nbsp;
        <input type="checkbox"> Lain-lain (Jenis __________)
    </p>

    <!-- Jumlah Total Jaringan -->
    <p style="font-size:12px;">
        Jumlah Total Jaringan/Cairan Pemeriksaan: ________________________________________________<br><br>

        <b>Spesimen untuk pasien</b><br>
        Jenis dari jaringan: ________________________________________________<br>
        Jumlah dari jaringan: ________________________________________________<br><br>

        <b>Keterangan</b><br>
        ___________________________________________________________________________________________<br><br>

        Nama jelas dan tanda tangan perawat instrumen: _______________________________<br>
        Nama jelas dan tanda tangan perawat sirkuler: _______________________________<br>
        Tanggal: ____________________ &nbsp;&nbsp; Jam: ____________________
    </p>

</body>

</html>