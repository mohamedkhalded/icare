<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class patient extends Model
{
    use HasApiTokens;
    use HasFactory;
    protected $table="patient"; 
    protected $fillable = [
        'name1', 'phone', 
        'email', 'pass',];
}
