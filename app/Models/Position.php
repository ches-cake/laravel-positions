<?php

// app/Models/Position.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model {
    protected $fillable = ['position_name', 'reports_to'];
}

