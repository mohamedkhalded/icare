<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class reservationlaporatory extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $table="laporatory_reservation"; 
    protected $fillable = [
        'name', 'phone', 'lapoatory_id', 'patient_id', 'state' // قم بإضافة الحقل 'state' هنا
    ];
}
