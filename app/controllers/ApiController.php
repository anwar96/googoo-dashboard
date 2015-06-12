<?php

class ApiController extends BaseController {

    /**
     * 2014-09-25
     */
    function playlist() {
        $date = App::environment() == 'local' ? '2014-09-25' : date('Y-m-d');
        $date = date('Y-m-d');
        $program = Program::where('is_active', 'true')->first();

        $sql = "
            SELECT `music_interests`.`artist_id`, count(facebook_id) as total,
            MAX(listeners.created_at) as last, `artists`.`name`
            FROM `listeners`
                INNER JOIN `music_interests` ON `music_interests`.`fb_user_id`=`listeners`.`facebook_id`
                INNER JOIN `artists` ON `artists`.`id`=`music_interests`.`artist_id`
            WHERE
                `listeners`.`program_id` = ?
                AND DATE(listeners.created_at) = ?
                AND `artists`.`name` IS NOT NULL
                AND artists.id NOT IN (SELECT artist_id FROM artist_exception)
            GROUP BY `music_interests`.`artist_id`
            ORDER BY `total` DESC,last DESC
        ";

        $results = DB::select($sql, array($program->id, $date));

        $songs = array();
        $argenre2 = [];
        foreach ($results as $i) {

            $allsongs = Song::where('artist_id', $i->artist_id)
                ->leftJoin('genres', function ($join) {
                    $join->on('songs.genre_id', '=', 'genres.id');
                })->select([
                'songs.*',
                'genres.id',
                'genres.name',
            ])
                ->whereRaw('bpm BETWEEN ' . $program->min_bpm . ' AND ' . $program->max_bpm, array())
                ->limit(3)
                ->get();

            $sql = "SELECT m.id, m.name "
            . "FROM listeners m INNER JOIN music_interests mi "
            . "ON mi.`fb_user_id` = m.`facebook_id`"
            . "WHERE mi.`artist_id` = ? and m.`program_id` = ? AND DATE(m.created_at) = ?";
            $likedmember = DB::select($sql, array($i->artist_id, $program->id, $date));

            if ($allsongs->toArray()) {
                $song['id'] = $i->artist_id;
                $song['artist'] = $i->name;
                $song['total'] = $i->total;
                $song['total_song'] = count($allsongs);
                $song['liked_member'] = count($likedmember);
                $song['last'] = $i->last;
                $song['songs'] = $allsongs->toArray();
                $songs[] = $song;

                $argenre = [];
                foreach ($allsongs as $key => $s) {
                    //echo $s->genre;
                    $argenre[$key] = strtolower(trim($s->name));
                }

                $vals = array_count_values($argenre);
                foreach ($vals as $key => $v) {
                    if ($key != "") {
                        if (array_key_exists($key, $argenre2)) {
                            $argenre2[$key] = $argenre2[$key] + $v;
                        } else {
                            $argenre2[$key] = $v;
                        }
                    }

                }
            }

            if (count($songs) > 9) {
                break;
            }
        }

        $maxValue = max($argenre2);
        $maxIndex = array_search(max($argenre2), $argenre2);

        $json['success'] = true;
        $json['xx'] = $maxIndex;
        $json['data'] = $songs;
        return Response::json($json);
    }

    function hitslist() {
        $songs = array();
        $allsongs = Song::leftJoin('genres', function ($join) {
            $join->on('songs.genre_id', '=', 'genres.id');
        })->Join('hits_charts', function ($join) {
              $join->on('songs.id', '=', 'hits_charts.song_id');
          })->select([
            'songs.*',
            'genres.id',
            'genres.name',
        ])->limit(3)
          ->orderByRaw("RAND()")
          ->get();

        if ($allsongs->toArray()) {
            $songs = $allsongs->toArray();
        }

        if (count($songs) > 10) {
            break;
        }

        $json['success'] = true;
        $json['data'] = $songs;
        return Response::json($json);
    }

    function getnewsong() {
        $songs = array();
        $allsongs = Song::leftJoin('genres', function ($join) {
            $join->on('songs.genre_id', '=', 'genres.id');
        })->Join('newsongs', function ($join) {
              $join->on('songs.id', '=', 'newsongs.song_id');
          })->select([
            'songs.*',
            'genres.id',
            'genres.name',
        ])->limit(3)
          ->orderByRaw("RAND()")
          ->get();

        if ($allsongs->toArray()) {
            $songs = $allsongs->toArray();
        }

        if (count($songs) > 10) {
            break;
        }

        $json['success'] = true;
        $json['data'] = $songs;
        return Response::json($json);
    }

    function similar_artist($id) {
        $date = date('Y-m-d');
        $program = Program::where('is_active', 'true')->first();

        $sql = "
            SELECT `artists`.`id`, `artists`.`name`
            FROM `similar_artists`
                INNER JOIN `artists` ON `similar_artists`.`similar_artist_id`=`artists`.`id`
            WHERE
                `similar_artists`.`artist_id` = ?
        ";

        $results = DB::select($sql, array($id));

        $songs = array();
        foreach ($results as $i) {

            $allsongs = Song::where('artist_id', $i->id)
                ->whereRaw('bpm BETWEEN ' . $program->min_bpm . ' AND ' . $program->max_bpm, array())
                ->limit(5)
                ->get();

            if ($allsongs->toArray()) {
                $song['id'] = $i->id;
                $song['artist'] = $i->name;
                $song['total_song'] = count($allsongs);
                $song['songs'] = $allsongs->toArray();
                $songs[] = $song;
            }

            if (count($songs) > 9) {
                break;
            }
        }
        $json['success'] = true;
        $json['data'] = $songs;
        return Response::json($json);
    }

    function similar_genre($id, $artist_id) {
        $date = date('Y-m-d');
        $program = Program::where('is_active', 'true')->first();

        $songs = array();
        $allsongs = Song::where('genre_id', $id)
            ->where('artist_id', '!=', $artist_id)
            ->leftJoin('genres', function ($join) {
                $join->on('songs.genre_id', '=', 'genres.id');
            })->select([
            'songs.*',
            'genres.id',
            'genres.name',
        ])->whereRaw('bpm BETWEEN ' . $program->min_bpm . ' AND ' . $program->max_bpm, array())
            ->limit(10)
            ->orderByRaw("RAND()")
            ->get();

        if ($allsongs->toArray()) {
            $songs = $allsongs->toArray();
        }

        if (count($songs) > 10) {
            break;
        }

        $json['success'] = true;
        $json['data'] = $songs;
        return Response::json($json);
    }

    function similar_year($year, $artist_id) {
        $date = date('Y-m-d');
        $program = Program::where('is_active', 'true')->first();

        $songs = array();
        $allsongs = Song::where('release_year', $year)
            ->where('artist_id', '!=', $artist_id)
            ->leftJoin('genres', function ($join) {
                $join->on('songs.genre_id', '=', 'genres.id');
            })->select([
            'songs.*',
            'genres.id',
            'genres.name',
        ])->whereRaw('bpm BETWEEN ' . $program->min_bpm . ' AND ' . $program->max_bpm, array())
            ->limit(10)
            ->orderByRaw("RAND()")
            ->get();

        if ($allsongs->toArray()) {
            $songs = $allsongs->toArray();
        }

        if (count($songs) > 10) {
            break;
        }

        $json['success'] = true;
        $json['data'] = $songs;
        return Response::json($json);
    }

    function likedmember($id) {
        $date = date('Y-m-d');
        $program = Program::where('is_active', 'true')->first();
        $sql = "SELECT m.id, m.name "
        . "FROM listeners m INNER JOIN music_interests mi "
        . "ON mi.`fb_user_id` = m.`facebook_id`"
        . "WHERE mi.`artist_id` = ? and m.`program_id` = ? AND DATE(m.created_at) = ?";
        $results = DB::select($sql, array($id, $program->id, $date));
        $result = "";
        foreach ($results as $key => $value) {
            $result .= $value->name . ", ";
        }
        $json['success'] = true;
        $json['data'] = $result;
        return Response::json($json);
    }

    function likedartist($id) {
        $sql = "SELECT a.`fb_band_id`, a.`id`, a.`name` "
        . "FROM music_interests mi "
        . "INNER JOIN artists a ON mi.`artist_id` = a.`id` "
        . "LEFT JOIN rejected_artists ra ON ra.artist_id = a.id "
        . "WHERE mi.`fb_user_id` = ? "
        . "AND ra.`id` is NULL "
        . "AND a.fb_band_id != 0";
        $results = DB::select($sql, array($id));
        $result = "";
        foreach ($results as $key => $value) {
            $result .= $value->name . ", ";
        }
        $json['success'] = true;
        $json['data'] = $result;
        return Response::json($json);
    }

    /**
     * Ajax for changing programs
     *
     * GET /api/program/change/{id}
     * @param int $id
     * @return json
     */
    public function programChange($id) {
        DB::table('programs')
            ->where('is_active', 'true')
            ->update(array('is_active' => 'false'));

        $program = Program::find($id);
        $program->is_active = 'true';
        $program->save();

        $resp['success'] = true;
        $resp['data'] = $program;
        return Response::json($resp);
    }

    public function listeners($id) {
        $date = date('Y-m-d');
        $sql = "
        SELECT * FROM `listeners`
        WHERE
            `program_id` = '2'
            and DATE(created_at) = '2014-09-25'
            ORDER BY `created_at` DESC
        ";
        $listeners = Listener::where('program_id', $id)
            ->whereRaw('DATE(created_at) = ?', array($date))
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($listeners as $r) {
            $r->facebook_id = (string) $r->facebook_id;
        }
        return Response::json(array('data' => $listeners));
    }

    public function nosong($programID) {
        $date = App::environment() == 'local' ? '2014-09-25' : date('Y-m-d');
        $sql = "
            SELECT
                a.id,a.name,count(*) as total
            FROM listeners l
                LEFT JOIN music_interests mi ON mi.fb_user_id = l.facebook_id
                LEFT JOIN artists a ON a.id = mi.artist_id
                LEFT JOIN songs s ON s.artist_id = mi.artist_id
            WHERE
                l.program_id = ?
                AND DATE(l.created_at) = ?
                AND a.name IS NOT  NULL
                AND s.title IS NULL
            GROUP BY a.id
            ORDER BY total DESC
            LIMIT 10
        ";
        $results = DB::select($sql, array($programID, $date));
        return Response::json($results);
    }

    public function ignoreList() {
        $ignore = Ignore::with('artist')
            ->orderBy('created_at')
            ->get();
        return Response::json(array('data' => $ignore->toArray()));
    }

    function ignore($id) {
        $ignore = Ignore::find($id);
        if (!$ignore) {
            $ignore = Ignore::create(['artist_id' => $id]);
        }

        return Response::json($ignore);
    }

    function ignoreRemove($id) {
        $ignore = Ignore::find($id);
        if ($ignore) {
            $ignore->delete();
        }
        return Response::json($ignore);
    }

    function ignoreRemoveAll() {
        $ignore = Ignore::truncate();
        return Response::json($ignore);
    }

    function newsong($id) {
        $users = Newsong::where('song_id', '=', $id)->get()->toArray();
        if (empty($users)) {
            $newsong = new Newsong();
            $newsong->song_id = $id;
            $newsong->save();
        }

        return Response::json($id);
    }

    function chart($id) {
        $charts = Chart::where('song_id', '=', $id)->get()->toArray();
        if (empty($charts)) {
            $charts = new Chart();
            $charts->song_id = $id;
            $charts->count = 1;
            $charts->save();
        }

        return Response::json($id);
    }

    function listartist() {
        echo "test";
    }

}
