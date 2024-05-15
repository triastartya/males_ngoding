<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasPerawatan extends Model
{
    use HasFactory;
    protected $table = "kelas_perawatan";
    protected $primaryKey = "id_kelas";
    public $timestamps = false;
}
