<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;


    public function Smsstatus(){
        
        return $this->belongsTo(SmsStatus::class,'sms_status_id');
 
     }
}
