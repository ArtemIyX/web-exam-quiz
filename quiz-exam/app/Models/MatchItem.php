<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchItem extends Model
{
    use HasFactory;
    protected $table = 'matches';
    protected $fillable = ['question_id', 'left_item', 'right_item'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
