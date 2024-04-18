<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable=[
        'amount',
        'added_by',
        'transfer_to',
        'project_id',
        'type',
        'date',
        'description',
        'status',
    ];

    public function getAuth(){
        return $this->belongsTo(User::class,'added_by');
    }
    public function getSupplier(){
        return $this->belongsTo(Supplier::class,'transfer_to');

    }
 public function getContractor(){
        return $this->belongsTo(Contractor::class,'transfer_to');

    }

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
}
