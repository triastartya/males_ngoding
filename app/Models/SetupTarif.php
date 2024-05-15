<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupTarif extends Model
{
    use HasFactory;
    protected $table = "setup_tarif";
    protected $primaryKey = "id_setup_tarif";
    public $timestamps = false;
}
