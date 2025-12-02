<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = ['quiz_id', 'text', 'correct_answer', 'options'];

    protected $casts = [
        'options' => 'array',
    ];
    
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
