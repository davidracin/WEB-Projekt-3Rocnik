<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishingCities extends Model
{
    use HasFactory;
    protected $table = 'publishing_cities'; // Specify the table name
    protected $primaryKey = 'id';
    public $incrementing = false;
}
