<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionItem extends Model
{
    use HasFactory;
    protected $table = 'options';
    protected $fillable = ['question_id', 'option', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
