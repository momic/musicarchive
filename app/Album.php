<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
	protected $dates = ['released'];
    protected $fillable = [
    	'artist_id',
    	'title',
    	'released'
    ];

    /**
     * Get artist for album
     */
    public function artist() {
    	return $this->belongsTo('App\Artist');
    }

}
