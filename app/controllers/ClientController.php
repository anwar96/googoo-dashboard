<?php

class ClientController extends BaseController {

    function getIndex() {
        $clients = Client::orderBy('created_at', 'DESC');
        if (Input::get('q')) {
            $q = '%' . Input::get('q') . '%';
            $clients->where('nama', 'like', $q)
                    ->orWhere('instansi', 'like', $q)
                    ->orWhere('email', 'like', $q)
                    ->orWhere('telp', 'like', $q);
        }
        $clients = $clients->paginate(20);
        return View::make('client.getIndex')->withClients($clients);
    }

    function getEdit($id) {
        $client = Client::findOrFail($id);
        return View::make('client.getEdit')->withClient($client);
    }

    function postEdit($id) {
        $client = Client::findOrFail($id);
        if ($client->save()) {
            return Redirect::to('/client/')->with('message', 'data has been updated');
        } else {
            return Redirect::to('/client/edit/' . $id)->withErrors($client->errors());
        }
    }

    function getAdd() {
        return View::make('client.getAdd');
    }

    function postAdd() {
        $client = new Client();
        if ($client->save()) {
            return Redirect::to('/client/')->with('message', 'data has been updated');
        } else {
            return Redirect::to('/client/add/')->withErrors($client->errors());
        }
    }

    public function getDelete($id) {
        $client = Client::findOrFail($id);
        $client->delete();
        return Redirect::to('/client/')->with('message', 'data has been deleted');
    }

    function getClientlist() {
        $term = trim(strip_tags($_GET['term']));
        $all_client = Client::getClientByName($term);
        if (!empty($all_client)) {
            foreach ($all_client as $value) {
                $row['value'] = htmlentities(stripslashes($value->nama));
                $row['data'] = $value->id;
                $row_set[] = $row; //build an array
            }
        } else {
            $row['value'] = htmlentities(stripslashes('Tidak ditemukan, klik + untuk tambahkan ke database?'));
            $row['data'] = 0;
            $row_set[] = $row; //build an array
        }
        return Response::json($row_set);
    }
}
