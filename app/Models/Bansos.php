<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bansos extends Model
{
    protected $table = 'bansos';
    protected $fillable = [
        'user_id',
        'jenis_bansos_id',
        'nama_lengkap',
        'nik',
        'alamat',
        'rt_rw',
        'no_hp',
        'status_tempat_tinggal',
        'desa',
        'kondisi_ekonomi',
        'alasan',
        'dokumen_pendukung',
        'dokumen_ktp',
        'dokumen_kk',
        'dokumen_rumah',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisBansos()
    {
        return $this->belongsTo(JenisBansos::class, 'jenis_bansos_id');
    }
}
