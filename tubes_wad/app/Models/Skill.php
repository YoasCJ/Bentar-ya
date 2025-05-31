<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    /**
     * Get the users that possess this skill.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill');
    }
}