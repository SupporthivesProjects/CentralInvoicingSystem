<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'bio', 'experience', 'location', 'mobile', 'slack',
        'portfolio', 'profile_image', 'cover_image', 'github', 'twitter', 'linkedin'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
