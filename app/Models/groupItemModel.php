<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class groupItemModel extends Model
{
    use HasFactory;
    protected $table = "mm_setup_grup_item";
    protected $primaryKey = "id_grup_item";
    public $timestamps = false;
}
