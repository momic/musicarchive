<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = [
    	'artist',
    	'image',
    	'musician_from'
    ];

    /**
     * Get albums for artist
     */
    public function albums() {
    	return $this->hasMany('App\Album');
    }
}
