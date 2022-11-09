<?php

namespace Xoxoday\Disclaimer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XocodeAttempt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name','code','email','mobile','ip','date_time'];

}
