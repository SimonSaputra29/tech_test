<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = ['murid_id', 'guru_id', 'status'];

    public function murid()
    {
        return $this->belongsTo(User::class, 'murid_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }
}
