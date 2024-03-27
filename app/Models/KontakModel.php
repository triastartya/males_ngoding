<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontakModel extends Model
{
    use HasFactory;
    protected $table = "kontak_person";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
