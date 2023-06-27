<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchItem extends Model
{
    use HasFactory;
    protected $table = 'matches';
    protected $fillable = ['question_id', 'item', 'is_right', 'parent_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function parent()
    {
        return $this->belongsTo(MatchItem::class, 'parent_id');
    }

}
