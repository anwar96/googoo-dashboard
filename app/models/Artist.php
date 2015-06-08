<?php

class Artist extends \LaravelBook\Ardent\Ardent {

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $guarded = ['id'];
    public static $rules = array(
        'name' => 'required'
    );

    function songs() {
        return $this->hasMany('Song')->orderBy('title');
    }

    function fbartist() {
        return $this->belongsToMany('Fbartis', 'artist_has_fb', 'artist_id', 'fb_artist_id');
    }

    function genres() {
        return $this->belongsToMany('Genre', 'artist_has_genres');
    }

    static function getArtists($limit = 10) {

        $artists = self::with('genres')
                ->leftJoin('rejected_artists', function($join) {
                    $join->on('artists.id', '=', 'rejected_artists.artist_id');
                })->select([
                    'artists.*',
                    'rejected_artists.artist_id'
                ])
                ->orderBy('name', 'ASC');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $artists->where('name', 'like', $q);
        }
        return $artists->paginate($limit);
    }

    function scopeOfSlug($query, $slug) {
        return $query->where('slug', '=', trim($slug));
    }

    static function getArtistByName($name) {
        $sql = "SELECT * FROM artists WHERE name LIKE '%" . $name . "%'";
        $data = DB::select($sql);
        return $data;
    }

    static function getSimilarArtists($id) {
        $sql = "SELECT a.id, a.name FROM similar_artists sa inner join artists a on a.id = sa.similar_artist_id where sa.artist_id = ?";
        $data = DB::select($sql, array($id));
        return $data;
    }

}
