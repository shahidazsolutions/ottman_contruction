<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['name','fname','mobile_number','office_number','res_number','email','nic','image','address'];



    public function applications(){
        return $this->hasMany(FormApplication::class,'customer_id');
    }


    public function bookedFlat($id){
        return Product::where('id',$id)->first();

    }


    public function booking($customer_id,$flat_id){
        return FormApplication::where('customer_id',$customer_id,)->where('flat_id',$flat_id)->first();

    }

    public function flatPayment($customer_id,$flat_id){
        return CustomerPayment::where('customer_id',$customer_id)->where('flat_id',$flat_id)->get();


    }


    // after transfer the prevoice holder paid amount
    public static function prevoicePaid($customer_id,$flat_id)
    {
        $advance = 0;
        $booking =  FormApplication::where('customer_id',$customer_id,)->where('flat_id',$flat_id)->first();
        if($booking){
            $advance = $booking->paid_amount;
        }
         $payment = CustomerPayment::where('customer_id',$customer_id)->where('flat_id',$flat_id)->sum('amount');
        return $payment+$payment;

    }

}
