<?php

class Teaser extends \Eloquent {
	protected $fillable = ['teaser', 'status'];

	public $timestamps = false;

	public function isActive() {
		return $this->status == 1;
	}
}