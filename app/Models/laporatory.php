<?php

namespace App\Models;
use App\Models\reservationlaporatory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class laporatory extends Model
{
    use HasApiTokens;
    use HasFactory;
    protected $table="laporatory"; 
    protected $fillable = [
        'first_name', 'last_name', 
        'specialty', 'phone_number', 
        'email', 'pass', 'category'];
    Public function reservationlaporatory(){
        return $this ->hasmany(reservationlaporatory::class,'laporatory_id'); 
    }

}
