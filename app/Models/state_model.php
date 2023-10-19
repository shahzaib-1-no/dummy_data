<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class state_model extends Model
{
    use HasFactory;
    public $table='state';
    protected $fillable=[
        'country_id',
        'state_name',
    ];
}
