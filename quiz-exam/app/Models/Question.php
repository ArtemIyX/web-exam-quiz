<?php

namespace App\Models;

use App\Models\MatchItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'question', 'question_type'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function matches()
    {
        return $this->hasMany(MatchItem::class);
    }
}
