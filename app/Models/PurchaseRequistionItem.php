<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Item;
use App\Models\Unit;
class PurchaseRequistionItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['purchase_requistion_id','item_id','unit_id','quantity','rate'];

public function item(){
    return $this->belongsTo(Item::class,'item_id');
}

public function unit(){
    return $this->belongsTo(Unit::class,'unit_id');
}
    
}
