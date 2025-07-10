<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'age',
        'password',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'age' => 'integer',
        'role' => 'integer',
    ];

    public function isAdmin()
    {
        return $this->role === 1;
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->withTimestamps();
    }

    public function friendships()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function friendOf()
    {
        return $this->hasMany(Friendship::class, 'friend_id');
    }

    public function isFriendWith(User $user)
    {
        return $this->friends()->where('users.id', $user->id)->exists();
    }

    public function addFriend(User $user)
    {
        if (!$this->isFriendWith($user)) {
            $this->friends()->attach($user);
        }
    }

    public function removeFriend(User $user)
    {
        if ($this->isFriendWith($user)) {
            $this->friends()->detach($user);
        }
    }
}
