<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipePasienModel extends Model
{
    use HasFactory;
    protected $table = "tipe_person";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
