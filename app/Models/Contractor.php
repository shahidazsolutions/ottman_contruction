<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;
    protected $fillable=['name','fname','email','phone','nic','image','address'];


    public function getContractPayment($project_id,$contractor_id) {
        $payments =  Payment::where('project_id', $project_id)->where('transfer_to',$contractor_id)->where('type','contractor')->get();
        if($payments){
            return $payments;
        }
        return 0;

    }

    public function payments(){
        return $this->hasMany(Payment::class,'transfer_to');
    }

    public function contracts(){
        return $this->hasMany(AsignContractor::class,'contractor');
    }



}
