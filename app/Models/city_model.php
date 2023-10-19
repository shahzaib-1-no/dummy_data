<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class city_model extends Model
{
    use HasFactory;
    public $table = 'city';
    protected $fillable = [
        'country_id',
        'state_id',
        'city_name',
    ];
}
