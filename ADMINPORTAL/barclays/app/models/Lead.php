<?php

class Lead extends \Eloquent {
	protected $fillable = [];

	public function product()
	{
	    return $this->belongsTo('Product','product_id');
	}
	public function branch()
	{
	    return $this->belongsTo('Branch','product_id');
	}
}