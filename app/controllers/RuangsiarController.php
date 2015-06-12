<?php

class RuangsiarController extends BaseController {

    public function getIndex() {
        $date = App::environment() == 'local' ? '2014-09-25' : date('Y-m-d');
        $date = date('Y-m-d');
        $programs = Program::all();
        $currentProgram = Program::where('is_active', 'true')->first();
        $nosongs = $this->nosong($currentProgram->id, $date);

        return View::make('ruangsiar.getIndex')
            ->with('currentProgram', $currentProgram)
            ->withNosongs($nosongs)
            ->withPrograms($programs);
    }

    private function nosong($programID, $date) {
        $sql = "
            SELECT
                a.id,a.name,count(*) as total
            FROM listeners l
                LEFT JOIN music_interests mi ON mi.fb_user_id = l.facebook_id
                LEFT JOIN artists a ON a.id = mi.artist_id
                LEFT JOIN songs s ON s.artist_id = mi.artist_id
                LEFT JOIN rejected_artists ra ON ra.artist_id = a.id
            WHERE
                l.program_id = ?
                AND DATE(l.created_at) = ?
                AND a.name IS NOT  NULL
                AND s.id IS NULL
                AND ra.id IS NULL
            GROUP BY a.id
            ORDER BY total DESC
            LIMIT 10
        ";

        $results = DB::select($sql, array($programID, $date));
        return $results;
    }

}
