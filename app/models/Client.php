<?php

class Client extends \LaravelBook\Ardent\Ardent {

    protected $guarded = ['id'];
    public static $rules = array(
        'nama' => 'required',
        'instansi' => 'required',
        'email' => 'required|email',
        'telp' => 'required',
        'alamat' => 'required',
    );
    public $autoHydrateEntityFromInput = true; // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true;

    static function getClientByName($name) {
        $sql = "SELECT * FROM clients WHERE nama LIKE '%" . $name . "%'";
        $data = DB::select($sql);
        return $data;
    }
}
