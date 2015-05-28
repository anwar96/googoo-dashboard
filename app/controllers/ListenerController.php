<?php

class ListenerController extends BaseController {

    public function getIndex() {
        $type = Input::get('type');
        $start = Input::get('start');
        $end = Input::get('end');
        
        $listener = Listener::getalllistener($type, $start, $end);
        $arlistener = [];
        foreach ($listener as $key => $value) {
            $arlistener[$key]['date'] = $value->date;
            $arlistener[$key]['visits'] = $value->count;
        }
        
        $unique = Listener::getuniqelistener($start, $end);
        $arunique = [];
        foreach ($unique as $key => $value) {
            $arunique[$key]['date'] = $value->date;
            $arunique[$key]['visits'] = $value->count;
        }
        
        if (Input::get('type') == 'm' || Input::get('type') == ''){
            $view = 'listener.getIndex';
        }else{
            $view = 'listener.getIndexHourly';
        }
        return View::make($view)->with('listener', $arlistener)->with('unique', $arunique);
    }

}
