<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseRequistion;
class Supplier extends Model
{
    use HasFactory;
    protected $fillable=['name','fname','email','phone','nic','image','address'];

    public function getPuchase(){
        return $this->hasMany(PurchaseRequistion::class,'supplier_id');
    }




    public function balance($id){
        $supplier = Supplier::find($id);
        if(!$supplier){
            return 0;
        }
        $purchase = PurchaseRequistion::where('supplier_id',$id)->where('status','confirmed')->get();
        $total_purchase = $purchase->sum('amount') ?? 0;
        $paid_amount = $purchase->sum('paid_amount') ?? 0;
        $total_pay = Payment::where('transfer_to',$id)->where('type','supplier')->sum('amount');

        return formatAmount($total_purchase - ($total_pay+$paid_amount));

    }

    // specific project payment
    public function getProjectPayment($supplier_id,$project_id){
        return Payment::where('project_id',$project_id)->where('transfer_to',$supplier_id)->where('type','supplier')->sum('amount');

    }

}
