<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormApplication extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['payment_by', 'number', 'date', 'bank_branch',
     'flat_preference', 'payment_schedule', 'nominee_name', 'nominee_so_wo',
      'nominee_relation', 'nominee_cnic', 'customer_id', 'flat_id'
    ,'total_amount','installment','paid_amount'];


    public function flate(){
        return $this->belongsTo(Product::class,'flat_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function customerPayment($customer_id,$flat_id){
       return CustomerPayment::where('customer_id',$customer_id)->where('flat_id',$flat_id)->get();
    }
}

