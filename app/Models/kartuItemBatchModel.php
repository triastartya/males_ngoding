<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kartuItemBatchModel extends Model
{
    use HasFactory;
    protected $table = "mm_kartu_stok_item_detail_batch";
    protected $primaryKey = "id_kartu_stok_item_detail_batch";
    public $timestamps = false; 
}
