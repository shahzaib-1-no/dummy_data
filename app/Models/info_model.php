<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class info_model extends Model
{
    use HasFactory;
    public $table = 'info';
    protected $fillable=[
        'fullname',
        'email',
        'password',
        'country',
        'state',
        'city' , 
        'country_name' , 
        'state_name' , 
        'city_name' , 
    ];
}
