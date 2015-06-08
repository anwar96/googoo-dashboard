<?php

class Genre extends \LaravelBook\Ardent\Ardent {

    protected $fillable = [];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $guarded = ['id'];
    public static $rules = array(
        'name' => 'required'
    );

    function artists() {
        return $this->belongsToMany('Artist', 'artist_has_genres')->orderBy('name', 'ASC');
    }

    static function getGenres($limit = 10) {

        $genres = self::with('artists')->orderBy('name', 'ASC');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $genres->where('name', 'like', $q);
        }
        $results = $genres->paginate($limit);
        return $results;
    }

    function scopeOfSlug($query, $slug) {
        return $query->where('slug', '=', trim($slug));
    }
    
    static function getGenreByName($name) {
        $sql = "SELECT * FROM genres WHERE name LIKE '%" . $name . "%' order by name ASC";
        $data = DB::select($sql);
        return $data;
    }

}
