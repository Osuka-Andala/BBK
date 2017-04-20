<?php

class Branch extends \Eloquent {
	protected $fillable = [];

	public function county()
	{
	    return $this->belongsTo('County','county_id');
	}
}