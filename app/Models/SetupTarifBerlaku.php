<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupTarifBerlaku extends Model
{
    use HasFactory;
    protected $table = "tarif_berlaku";
    protected $primaryKey = "id_tarif_berlaku";
    public $timestamps = false;
}
