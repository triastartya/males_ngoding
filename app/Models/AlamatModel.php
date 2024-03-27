<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatModel extends Model
{
    use HasFactory;
    protected $table = "alamat_person";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
