<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['employe_id','supplier_id','purchase_reuestion_id','purpose',];
    function purchase_requistion()  {
        return $this->hasOne(PurchaseRequistion::class,'id','purchase_reuestion_id');
    }
    function employee()  {
        return $this->hasOne(User::class,'id','employe_id');
    }
    function supplier()  {
        return $this->hasOne(Supplier::class,'id','supplier_id');
    }
}
