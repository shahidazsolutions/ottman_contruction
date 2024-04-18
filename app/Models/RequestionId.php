<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestionId extends Model
{
    use HasFactory;
    protected $fillable=['r_id','purchase_requestion_id'];

}
