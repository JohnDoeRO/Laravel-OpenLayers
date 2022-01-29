<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Coords
 */
class Coords extends Model
{
    /**
     * table
     *
     * @var string
     */
    protected $table = 'coords';

    protected $fillable = ['lat', 'lot'];

}
