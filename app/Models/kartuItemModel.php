<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kartuItemModel extends Model
{
    use HasFactory;
    protected $table = "mm_kartu_stok_item";
    protected $primaryKey = "id_kartu_stok_item";
    public $timestamps = false; 
}
