<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FormApplication;
class Product extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable=[
        'project_id','room_number',
        'floor_number','flate_size',
        'unit_price','parking_charge','utility_charge',
        'additional_charge','other_charge','discount_deduction','flat_net_price',
        'refund_charge','file','description','booking','flat_price'];


        public function project(){
            return $this->belongsTo(Project::class,'project_id');
        }
        
        public function booking (){
            return $this->HasMany(FormApplication::class,'flat_id');
        }
}
