<?php

class ListenerController extends BaseController {

    public function getIndex() {
        $type = Input::get('type');
        $start = Input::get('start');
        $end = Input::get('end');

        if ($start == "") {
            $start = date('Y-m-01');
        }

        if ($end == "") {
            $end = date('Y-m-t');
        }

        $listener = Listener::getalllistener($type, $start, $end);
        $arlistener = [];
        $countlistener = 0;
        foreach ($listener as $key => $value) {
            $arlistener[$key]['date'] = $value->date;
            $arlistener[$key]['visits'] = $value->count;
            $countlistener = $countlistener + $value->count;
        }

        $unique = Listener::getuniqelistener($start, $end);
        $arunique = [];
        $countunique = 0;
        foreach ($unique as $key => $value) {
            $arunique[$key]['date'] = $value->date;
            $arunique[$key]['visits'] = $value->count;
            $countunique = $countunique + $value->count;
        }

        $genre = Listener::getTopgenre($start, $end);
        $argenre = [];
        foreach ($genre as $key => $value) {
            $argenre[$key]['name'] = $value->name;
            $argenre[$key]['total'] = $value->total;
        }

        if (Input::get('type') == 'm' || Input::get('type') == '') {
            $view = 'listener.getIndex';
        } else {
            $view = 'listener.getIndexHourly';
        }
        return View::make($view)
                        ->with('listener', $arlistener)
                        ->with('unique', $arunique)
                        ->with('countlistener', $countlistener)
                        ->with('countunique', $countunique)
                        ->with('genre', $argenre)
                        ->with('datestart', $start)
                        ->with('dateend', $end);
    }

}
