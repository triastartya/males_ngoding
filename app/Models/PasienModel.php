<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienModel extends Model
{
    use HasFactory;
    protected $table = "pasien";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

}
