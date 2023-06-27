<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionMatch extends Model
{
    use HasFactory;
    protected $table = "submission_matches";

    protected $fillable = [
        'submission_id', 'question_id', 'left_match_id', 'right_match_id',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function leftMatch()
    {
        return $this->belongsTo(MatchItem::class, 'left_match_id');
    }

    public function rightMatch()
    {
        return $this->belongsTo(MatchItem::class, 'right_match_id');
    }
}
