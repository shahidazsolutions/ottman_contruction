<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
class AsignContractor extends Model
{
    use HasFactory;
    protected $fillable = ['project', 'contractor', 'amount'];

        public function getProject(){
            return $this->belongsTo(Project::class,'project');

        }

        public function getContractor(){
            return $this->belongsTo(Contractor::class,'contractor');

        }

        public function contractPayment($contractor_id,$project_id){

            return Payment::where('transfer_to',$contractor_id)->where('project_id',$project_id)->where('type','contractor')->sum('amount');
        }

}
