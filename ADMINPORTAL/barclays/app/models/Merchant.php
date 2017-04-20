<?php

class Merchant extends \Eloquent {
	protected $fillable = [];

	public function county()
	{
	    return $this->belongsTo('County','county_id');
	}
}