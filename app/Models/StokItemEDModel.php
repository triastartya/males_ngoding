<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stokItemEDModel extends Model
{
    use HasFactory;
    protected $table = "mm_setup_stok_item_detail_batch";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}