<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $fillable = ['user_id', 'judul', 'konten', 'kategori', 'gambar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
