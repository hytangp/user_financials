<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const USER_ROLE_ID = 1; //According to the seeder

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
