<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceModel extends Model
{
    use HasFactory, SoftDeletes;
    protected  $fillable  =  ['order_id', 'type', 'amount', 'paid', 'credit', 'project', 'debit', 'contractor', 'supplier'];
}
