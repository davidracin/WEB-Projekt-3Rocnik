<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publishers extends Model
{
    use HasFactory;
    protected $table = 'publishers'; // Specify the table name
    protected $primaryKey = 'id';
    public $incrementing = false;
}
