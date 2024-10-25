<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = ['todo_id', 'is_pinned', 'is_done'];

    // Specify the primary key
    protected $primaryKey = 'todo_id';

    // Indicate that the primary key is not an auto-incrementing integer
    public $incrementing = false; // Set this to false since todo_id is not an auto-incrementing ID

    // Define the inverse relationship to the Todo model
    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
