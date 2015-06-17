<?php

class Song extends \LaravelBook\Ardent\Ardent {

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $guarded = ['id'];
    public static $rules = array(
        'title' => 'required',
        'artist' => 'required',
        'album' => 'required',
        'release_year' => 'required',
        'genre' => 'required',
        'bpm' => 'required',
    );
    public $autoHydrateEntityFromInput = true; // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true;

    function dbartist() {
        return $this->belongsTo("Artist", 'artist_id');
    }

    static function getSongs($limit) {
        $songs = self::leftJoin('newsongs', function ($join) {
            $join->on('songs.id', '=', 'newsongs.song_id');
        })->leftJoin('genres', function ($join) {
              $join->on('songs.genre_id', '=', 'genres.id');
          })->leftJoin('hits_charts', function ($join) {
            $join->on('songs.id', '=', 'hits_charts.song_id');
        })->select([
            'songs.id',
            'songs.slug',
            'songs.slug_artist',
            'songs.artist_id',
            'songs.genre_id',
            'songs.artist',
            'songs.title',
            'songs.album',
            'songs.genre',
            'genres.name',
            'songs.release_year',
            'songs.bpm',
            'songs.created_at',
            'songs.modified_at',
            'songs.is_lastfm',
            'newsongs.song_id',
            'hits_charts.id as chart_id',
        ])
          ->orderBy('modified_at', 'DESC')->with('dbartist');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $songs->where('title', 'like', $q);
        }
        return $songs->paginate($limit);
    }

    static function getNewSongs($limit) {
        $songs = self::join('newsongs', function ($join) {
            $join->on('songs.id', '=', 'newsongs.song_id');
        })->leftJoin('genres', function ($join) {
              $join->on('songs.genre_id', '=', 'genres.id');
          })->select([
            'songs.id',
            'songs.slug',
            'songs.slug_artist',
            'songs.artist_id',
            'songs.genre_id',
            'songs.artist',
            'songs.title',
            'songs.album',
            'songs.genre',
            'genres.name',
            'songs.release_year',
            'songs.bpm',
            'songs.created_at',
            'songs.modified_at',
            'songs.is_lastfm',
            'newsongs.song_id',
            'newsongs.id as newsong_id',
        ])
          ->orderBy('newsongs.updated_at', 'DESC')->with('dbartist');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $songs->where('title', 'like', $q);
        }
        return $songs->paginate($limit);
    }

    static function getHitsSongs($limit) {
        $songs = self::join('hits_charts', function ($join) {
            $join->on('songs.id', '=', 'hits_charts.song_id');
        })->leftJoin('genres', function ($join) {
              $join->on('songs.genre_id', '=', 'genres.id');
          })->select([
            'songs.id',
            'songs.slug',
            'songs.slug_artist',
            'songs.artist_id',
            'songs.genre_id',
            'songs.artist',
            'songs.title',
            'songs.album',
            'songs.genre',
            'genres.name',
            'songs.release_year',
            'songs.bpm',
            'songs.created_at',
            'songs.modified_at',
            'songs.is_lastfm',
            'hits_charts.song_id',
            'hits_charts.id as chart_id',
        ])
          ->orderBy('hits_charts.updated_at', 'DESC')->with('dbartist');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $songs->where('title', 'like', $q);
        }
        return $songs->paginate($limit);
    }

    /**
     * TRUNCATE `artists`;
    TRUNCATE `artist_has_genres`;
    TRUNCATE `genres`;
    TRUNCATE `songs`;
     * @return boolean
     */
    public function beforeSave() {
        $iArtist = Input::get('artist', $this->artist);
        $iTitle = Input::get('title', $this->title);
        $iGenre = Input::get('genre', $this->genre);
        if (Input::get('artist_id')) {
            $artist = Artist::findOrFail(Input::get('artist_id'));
            $slugArtist = $artist->slug;
        } else {
            $slugArtist = strtolower(Str::slug($iArtist));
        }

        $slugGenre = strtolower(Str::slug($iGenre));
        $slugTitle = strtolower(Str::slug($iArtist . ' ' . $iTitle));

        $artist = Artist::ofSlug($slugArtist)->first();
        if (!$artist) {
            $artist = Artist::create(array(
                'slug' => $slugArtist,
                'name' => $iArtist,
            ));
        }

        $genre = Genre::ofSlug($slugGenre)->first();
        if (!$genre) {
            $genre = Genre::create(['slug' => $slugGenre, 'name' => $iGenre]);
        }

        $artist->genres()->sync(array($genre->id));

        $this->slug = trim($slugTitle);
        $this->slug_artist = trim($slugArtist);
        $this->artist_id = $artist->id;
        $this->genre_id = $genre->id;

        return true;
    }

}
