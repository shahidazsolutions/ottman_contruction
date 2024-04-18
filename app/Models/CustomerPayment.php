<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
class CustomerPayment extends Model
{
    use HasFactory;
    protected $fillable=[
        'amount',
        'added_by',
        'customer_id',
        'project_id',
        'flat_id',
        'date',
        'status',
    ];

    public function getAuth(){
        return $this->belongsTo(User::class,'added_by');
    }
    public function getCustomer(){
        return $this->belongsTo(Customer::class,'customer_id');

    }
        
        public function customer($id){
            return Customer::withTrashed()->where('id',$id)->first();
return $this->belongsTo(Customer::class,'customer_id');
            
        }
    
     public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function flat(){
        return $this->belongsTo(Product::class,'flat_id');
    }
}
