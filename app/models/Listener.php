<?php

class Listener extends \Eloquent {

    protected $fillable = [];

    static function currentListener($id, $date) {
        return self::where('program_id', $id)
                        ->whereRaw('DATE(created_at) = ?', array($date))
                        ->orderBy('created_at', 'DESC')
                        ->get();
    }

    static function getalllistener($type = "", $start = "", $end = "") {
        $between = "";
        if ($start != "" && $end != "") {
            $between = "WHERE created_at BETWEEN '" . $start . "' AND '" . $end . "'";
        }

        if ($type == "m" || $type == "") {
            $sql = "SELECT DATE(created_at) as date, count(id) as count FROM listeners " . $between . " GROUP BY DATE(created_at)";
        } else {
            $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m-%d %H') as date, count(id) as count FROM listeners " . $between . " GROUP BY DATE_FORMAT(created_at, '%Y-%m-%d %H')";
        }

        $listener = DB::select($sql);
        return $listener;
    }

    static function getuniqelistener($start = "", $end = "") {
        $between = "";
        if ($start != "" && $end != "") {
            $between = "WHERE list.created_at BETWEEN '" . $start . "' AND '" . $end . "'";
        }


        $sql = "SELECT DATE( list.created_at ) AS date, SUM( list.jml ) AS count 
                FROM (
                    SELECT facebook_id, COUNT( facebook_id ) AS jml, created_at
                    FROM listeners
                    GROUP BY facebook_id
                ) AS list " . $between . "
                GROUP BY DATE( list.created_at )";


        $listener = DB::select($sql);
        return $listener;
    }
    
    static function getTopgenre($start = "", $end = ""){
        $between = "";
        if ($start != "" && $end != "") {
            $between = "AND created_at BETWEEN '" . $start . "' AND '" . $end . "'";
        }
        $sql = "SELECT genres.`name`, COUNT(genre_id) AS total "
                . "FROM( "
                . "SELECT artist_id FROM crowd_bands "
                . "WHERE fbid IS NOT NULL ".$between." GROUP BY artist_id"
                . ") AS crowds "
                . "LEFT JOIN artists ON artists.id = crowds.artist_id "
                . "LEFT JOIN artist_has_genres ON artists.id = artist_has_genres.`artist_id` "
                . "LEFT JOIN genres ON genres.id = artist_has_genres.`genre_id` "
                . "where genres.name IS NOT NULL "
                . "group by genres.id order by total desc limit 0, 15";
        $genre = DB::select($sql);
        return $genre;
    }

}
