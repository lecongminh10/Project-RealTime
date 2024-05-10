<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Board extends Model
{
    
    protected $table ='boards';

    protected $fillable = [
        'name',
        'created_by',

    ];
    public function scopeCreatedByUser($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

}
