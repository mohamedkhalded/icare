<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class reservationclinic extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $table="clinic_reservation"; 
    protected $fillable = [
        'name', 'phone', 
        'clinic_id','patient_id'];
}
