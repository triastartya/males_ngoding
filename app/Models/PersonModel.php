<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonModel extends Model
{
    use HasFactory;
    protected $table = "person";
    protected $primaryKey = "id_person";
    public $timestamps = false;
}
