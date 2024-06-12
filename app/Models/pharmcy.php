<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class pharmcy extends Model
{
    use HasApiTokens;
    use HasFactory;
    protected $table="pharmcy"; 
    protected $fillable = [
        'first_name', 'last_name', 
        'specialty', 'phone_number', 
        'email', 'pass', 'category'];
}
