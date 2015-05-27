<?php

class Listener extends \Eloquent
{

    protected $fillable = [];

    static function currentListener($id, $date)
    {
        return self::where('program_id', $id)
                ->whereRaw('DATE(created_at) = ?', array($date))
                ->orderBy('created_at', 'DESC')
                ->get();
    }
    
    static function getalllistener($start = "", $end = ""){
        $sql = "SELECT DATE(created_at) as date, count(id) as count FROM listeners GROUP BY DATE(created_at)";
        $listener = DB::select($sql);
        if ($start != "" && $end != ""){
            $listener->whereBetween('created_at', array($start, $end));
        }
        
        return $listener;
    }

}
