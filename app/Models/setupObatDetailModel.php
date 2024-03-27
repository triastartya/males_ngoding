<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setupObatDetailModel extends Model
{
    use HasFactory;
    protected $table = "phar_setup_obat_detail";
    protected $primaryKey = "id_obat_detail";
    public $timestamps = false;
}
