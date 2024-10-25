<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['task', 'matkul', 'deadline', 'deskripsi'];

    // Define the relationship to the Information model
    public function information()
    {
        return $this->hasOne(Information::class);
    }
}
