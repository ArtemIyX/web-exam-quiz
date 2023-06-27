<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionOption extends Model
{
    use HasFactory;
    protected $table = "submission_options";
    protected $fillable = [
        'submission_id', 'question_id', 'option_id',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
}
