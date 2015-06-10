<?php

class Adlibs extends \LaravelBook\Ardent\Ardent {

    protected $guarded = ['id'];
    public static $rules = array(
        'text' => 'required',
        'genre' => 'required',
        'status' => 'required',
        'count' => 'required',
    );
    public $autoHydrateEntityFromInput = true; // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true;
}
