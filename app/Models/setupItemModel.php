<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setupItemModel extends Model
{
    use HasFactory;
    protected $table = "mm_setup_item";
    protected $primaryKey = "id_item";
    public $timestamps = false;
}
