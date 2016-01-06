<?php

class Weeklyprogram extends \Eloquent {

	private static $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
	
	public $timestamps = false;

	protected $fillable = ['day', 'name', 'hour'];

	public static function getDay($day) {
		return self::$hari[$day];
	} 

	/*
	*
	*	@param array
	*
	*/
	public function setHourAttribute($value) {
		foreach($value as $v => $k) {
			$value[$v] = date("g A", strtotime("$k:00"));
		}
		$this->attributes['hour'] = $value['from']. " - ". $value['to'];
	}

	public function getHourFromAttribute($value) {
		try {
			$hour_from = explode(" - ", $this->hour)[0];
			return $hour_from;
		}catch(Exception $e) {

			return "1 AM";
		}
	}

	public function getHourToAttribute($value) {
		try {
			$hour_from = explode(" - ", $this->hour)[1];
			return $hour_from;
		}catch(Exception $e) {
			return "1 AM";
		}
	}



	
}