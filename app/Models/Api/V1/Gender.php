<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public $timestamps = false;
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
