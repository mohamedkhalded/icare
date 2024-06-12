<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class clinic extends Model
{
    use HasApiTokens;
    use HasFactory;
    protected $table="clinic"; 
      
       protected $fillable = [
        'first_name', 'last_name', 
        'specialty', 'phone_number', 
        'email', 'pass', 'category'];

     

 
}
