<?php

class AdlibsController extends BaseController {

    function getIndex() {
        $adlibs = Adlibs::orderBy('created_at', 'DESC');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $adlibs->where('text', 'like', $q)
                   ->orWhere('genre', 'like', $q);
        }
        $adlibs = $adlibs->paginate(20);
        return View::make('adlibs.getIndex')->withAdlibs($adlibs);
    }

    function getEdit($id) {
        $adlibs = Adlibs::findOrFail($id);
        return View::make('adlibs.getEdit')->withAdlibs($adlibs);
    }

    function postEdit($id) {
        $adlibs = Adlibs::findOrFail($id);
        if ($adlibs->save()) {
            return Redirect::to('/adlibs/')->with('message', 'data has been updated');
        } else {
            return Redirect::to('/adlibs/edit/' . $id)->withErrors($adlibs->errors());
        }
    }

    function getAdd() {
        return View::make('adlibs.getAdd');
    }

    function postAdd() {
        $adlibs = new Adlibs();
        if ($adlibs->save()) {
            return Redirect::to('/adlibs/')->with('message', 'data has been updated');
        } else {
            return Redirect::to('/adlibs/edit/' . $adlibs->id)->withErrors($adlibs->errors());
        }
    }

    public function getDelete($id) {
        $adlibs = Adlibs::findOrFail($id);
        $adlibs->delete();
        return Redirect::to('/adlibs/')->with('message', 'data has been deleted');
    }
}
