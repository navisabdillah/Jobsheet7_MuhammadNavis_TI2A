<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'matakuliah';

    public function mahasiswamatakuliah(){
        return $this->hasMany(Mahasiswa_MataKuliah::class);
}
}
