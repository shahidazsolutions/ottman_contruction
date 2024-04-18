<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequistion extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['project_id','supplier_id','employee_id','requistion_date','required_date','remark','image','amount'];
    function project()  {
        return $this->hasOne(Project::class,'id','project_id');
    }
    function employee()  {
        return $this->hasOne(User::class,'id','employee_id');
    }
    function supplier()  {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
    function requistion_id()  {
        return $this->hasOne(RequestionId::class,'purchase_requestion_id','id');
    }

    public function getPurchaseItems(){
        return $this->hasMany(PurchaseRequistionItem::class,'purchase_requistion_id');
    }

}
