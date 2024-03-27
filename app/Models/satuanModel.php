<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satuanModel extends Model
{
    use HasFactory;
    protected $table = "mm_setup_satuan";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
