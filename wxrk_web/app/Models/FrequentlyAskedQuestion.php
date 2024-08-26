<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrequentlyAskedQuestion extends Model
{

    protected $fillable = [
        'question',
        'answer',
        'language_id'
    ];


    public function language() {
        return $this->belongsTo(Language::class);
    }

}
