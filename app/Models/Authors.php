<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    use HasFactory;
    protected $table = 'authors'; // Specify the table name
    protected $primaryKey = 'id';
    public $incrementing = false;
}
