<?php

class Issue extends \Eloquent {
	protected $fillable = [];
	public function device()
	{
	    return $this->belongsTo('Device','device_id');
	}
	public function merchant()
	{
	    return $this->belongsTo('Merchant','merchant_id');
	}
}