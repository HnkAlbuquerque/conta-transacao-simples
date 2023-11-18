<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected  $primaryKey = 'conta_id';
    protected $fillable = [
        'conta_id',
        'saldo',
    ];
}
