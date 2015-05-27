<?php

class ListenerController extends BaseController {

    public function getIndex() {
        $listener = Listener::getalllistener();
        $arlistener = [];
        foreach ($listener as $key => $value) {
            $arlistener[$key]['date'] = $value->date;
            $arlistener[$key]['visits'] = $value->count;
        }
        return View::make('listener.getIndex')->with('listener', $arlistener);
    }

}
