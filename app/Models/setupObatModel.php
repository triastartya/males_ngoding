<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setupObatModel extends Model
{
    use HasFactory;
    protected $table = "phar_setup_obat";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
