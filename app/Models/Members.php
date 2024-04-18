<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'number',
        'nic',
        'address'
    ];

    public function payments(){
        return $this->hasMany(MemberPayment::class,'member_id');
    }
}
