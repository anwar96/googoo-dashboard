<?php

class AudiospotController extends BaseController {

    function getIndex() {
        $audiospots = Audiospot::orderBy('created_at', 'DESC');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $audiospots->where('text', 'like', $q)
                       ->orWhere('genre', 'like', $q);
        }
        $audiospots = $audiospots->paginate(20);
        return View::make('audiospot.getIndex')->withAudiospots($audiospots);
    }

    function getEdit($id) {
        $audiospot = Audiospot::findOrFail($id);
        return View::make('audiospot.getEdit')->withAudiospots($audiospot);
    }

    function postEdit($id) {
        $audiospots = Audiospot::findOrFail($id);
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
        if ($audiospots->save()) {
            return Redirect::to('/audiospot/')->with('message', 'data has been updated');
        } else {
            return Redirect::to('/audiospot/edit/' . $audiospots->id)->withErrors($audiospots->errors());
        }
    }

    public function getDelete($id) {
        $audiospots = Audiospot::findOrFail($id);
        $audiospots->delete();
        return Redirect::to('/audiospot/')->with('message', 'data has been deleted');
    }
}
