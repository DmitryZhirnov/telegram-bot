<?php

namespace App\Domain\SwearingWord;

use Illuminate\Database\Eloquent\Model;

class SwearingWord extends Model
{
    protected $table = 'swearing_words';
    protected $fillable = ['word'];
}