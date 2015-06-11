<?php

class AudiospotController extends BaseController {

    function getIndex() {
        $audiospots = Audiospot::select(['audiospots.*', 'clients.nama', 'clients.instansi'])->join('clients', 'clients.id', '=', 'audiospots.client_id')->orderBy('audiospots.created_at', 'DESC');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $audiospots->where('text', 'like', $q)
                       ->orWhere('genre', 'like', $q)
                       ->orWhere('nama', 'like', $q);
        }
        $audiospots = $audiospots->paginate(20);
        return View::make('audiospot.getIndex')->withAudiospots($audiospots);
    }

    function getEdit($id) {
        $audiospot = Audiospot::select(['audiospots.*', 'clients.nama', 'clients.instansi'])->join('clients', 'clients.id', '=', 'audiospots.client_id')->findOrFail($id);
        return View::make('audiospot.getEdit')->withAudiospots($audiospot);
    }

    function postEdit($id) {
        $audiospots = Audiospot::findOrFail($id);
        $audiospots->client_id = Input::get('client_id');
        $audiospots->text = Input::get('text');
        $audiospots->genre = Input::get('genre');
        $audiospots->status = Input::get('status');
        $audiospots->count = Input::get('count');
        $audiospots->type = Input::get('type');
        if ($audiospots->save()) {
            return Redirect::to('/audiospot/')->with('message', 'data has been updated');
        } else {
            return Redirect::to('/audiospot/edit/' . $id)->withErrors($audiospots->errors());
        }
    }

    function getAdd() {
        return View::make('audiospot.getAdd');
    }

    function postAdd() {
        $audiospots = new Audiospot();
        $audiospots->client_id = Input::get('client_id');
        $audiospots->text = Input::get('text');
        $audiospots->genre = Input::get('genre');
        $audiospots->status = Input::get('status');
        $audiospots->count = Input::get('count');
        $audiospots->type = Input::get('type');
        if ($audiospots->save()) {
            return Redirect::to('/audiospot/')->with('message', 'data has been updated');
        } else {
            return Redirect::to('/audiospot/add/')->withErrors($audiospots->errors());
        }
    }

    public function getDelete($id) {
        $audiospots = Audiospot::findOrFail($id);
        $audiospots->delete();
        return Redirect::to('/audiospot/')->with('message', 'data has been deleted');
    }
}
