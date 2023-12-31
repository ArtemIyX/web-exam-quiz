<?php

namespace App\Models;

use App\Models\MatchItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'question', 'question_type', 'points'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options()
    {
        return $this->hasMany(OptionItem::class);
    }

    public function matches()
    {
        return $this->hasMany(MatchItem::class);
    }
}
