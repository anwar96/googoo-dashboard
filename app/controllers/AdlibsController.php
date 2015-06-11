<?php

class AdlibsController extends BaseController {

    function getIndex() {
        $adlibs = Adlibs::select(['adlibs.*', 'clients.nama', 'clients.instansi'])->join('clients', 'clients.id', '=', 'adlibs.client_id')->orderBy('adlibs.created_at', 'DESC');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $adlibs->where('text', 'like', $q)
                   ->orWhere('genre', 'like', $q)
                   ->orWhere('type', 'like', $q)
                   ->orWhere('nama', 'like', $q);
        }
        $adlibs = $adlibs->paginate(20);
        return View::make('adlibs.getIndex')->withAdlibs($adlibs);
    }

    function getEdit($id) {
        $adlibs = Adlibs::select(['adlibs.*', 'clients.nama', 'clients.instansi'])->join('clients', 'clients.id', '=', 'adlibs.client_id')->findOrFail($id);
        return View::make('adlibs.getEdit')->withAdlibs($adlibs);
    }

    function postEdit($id) {
        $adlibs = Adlibs::findOrFail($id);
        $adlibs->client_id = Input::get('client_id');
        $adlibs->text = Input::get('text');
        $adlibs->genre = Input::get('genre');
        $adlibs->status = Input::get('status');
        $adlibs->count = Input::get('count');
        $adlibs->type = Input::get('type');
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
        $adlibs->client_id = Input::get('client_id');
        $adlibs->text = Input::get('text');
        $adlibs->genre = Input::get('genre');
        $adlibs->status = Input::get('status');
        $adlibs->count = Input::get('count');
        $adlibs->type = Input::get('type');
        if ($adlibs->save()) {
            return Redirect::to('/adlibs/')->with('message', 'data has been updated');
        } else {
            return Redirect::to('/adlibs/add/')->withErrors($adlibs->errors());
        }
    }

    public function getDelete($id) {
        $adlibs = Adlibs::findOrFail($id);
        $adlibs->delete();
        return Redirect::to('/adlibs/')->with('message', 'data has been deleted');
    }
}
