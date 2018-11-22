<?php

namespace PaulKatipunan\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{	

	public $timestamps = false;

    protected $fillable = [
        'email', 'token'
    ];

}
