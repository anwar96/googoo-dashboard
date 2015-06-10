<?php

class Audiospot extends \LaravelBook\Ardent\Ardent {

    protected $guarded = ['id'];
    public static $rules = array(
        'text' => 'required',
        'type' => 'required',
        'genre' => 'required',
        'status' => 'required',
        'count' => 'required',
    );
    public $autoHydrateEntityFromInput = true; // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true;
}
