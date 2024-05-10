<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{

    protected $table = "board_members";

    protected $fillable = ['board_id', 'user_id', 'role'];

    // Relationship with Board
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeUserIsMember($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}