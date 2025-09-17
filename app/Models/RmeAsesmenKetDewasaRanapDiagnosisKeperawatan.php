<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeAsesmenKetDewasaRanapDiagnosisKeperawatan extends Model
{
    use HasFactory;

    protected $table = 'RME_ASESMEN_KET_DEWASA_RANAP_DIAGNOSIS_KEPERAWATAN';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = [
        'diagnosis' => 'array',
        'rencana_bersihan_jalan_nafas' => 'array',
        'rencana_penurunan_curah_jantung' => 'array',
        'rencana_perfusi_perifer' => 'array',
        'rencana_hipovolemia' => 'array',
        'rencana_hipervolemia' => 'array',
        'rencana_diare' => 'array',
        'rencana_retensi_urine' => 'array',
        'rencana_nyeri_akut' => 'array',
        'rencana_nyeri_kronis' => 'array',
        'rencana_hipertermia' => 'array',
        'rencana_gangguan_mobilitas_fisik' => 'array',
        'rencana_resiko_infeksi' => 'array',
        'rencana_konstipasi' => 'array',
        'rencana_resiko_jatuh' => 'array',
        'rencana_gangguan_integritas_kulit' => 'array',
    ];

    public function asesmen()
    {
        return $this->belongsTo(RmeAsesmen::class, 'id_asesmen', 'id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }

    public function userEdit()
    {
        return $this->belongsTo(User::class, 'user_edit', 'id');
    }
}
