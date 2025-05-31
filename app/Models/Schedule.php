<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['request_id', 'date', 'time'];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
