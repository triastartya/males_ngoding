<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebiturPasienModel extends Model
{
    use HasFactory;
    protected $table = "debitur_pasien";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
