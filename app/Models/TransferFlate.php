<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferFlate extends Model
{
    use HasFactory;
    protected $fillable=[
        'flat_id',
        'old_customer_id',
        'old_customer_nominee',
        'old_customer_payment',
        'old_customer_nic',

        // new customer
        'new_customer_id',
        'new_customer_nominee',
        'new_customer_payment',
        'new_customer_nic'
    ];

    public function oldCustomer(){
            return $this->belongsTo(Customer::class,'old_customer_id');
    }
    public function newCustomer(){
        return $this->belongsTo(Customer::class,'new_customer_id');
}
public function flat(){
    return $this->belongsTo(Product::class,'flat_id');
}


public function flate(){
    return $this->belongsTo(Product::class,'flat_id');
}

public function customerPayment($customer_id,$flat_id){
    return CustomerPayment::where('customer_id',$customer_id)->where('flat_id',$flat_id)->get();
}

public function getBooking($customer_id,$flat_id){
    return FormApplication::where('customer_id',$customer_id)->where('flat_id',$flat_id)->first();

}
}
