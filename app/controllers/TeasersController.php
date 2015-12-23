<?php

class TeasersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$teasers = Teaser::orderBy('id', 'DESC')->paginate(10); 

		return View::make('teaser.getIndex')->withTeasers($teasers);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getUpload()
	{
		return View::make('teaser.getUpload');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postUpload()
	{
		$validator = Validator::make(Input::all(), array(
			'file' => 'image'
		));
		//kalo ada url make yang url, kalo ngga yang file
		if ($validator->fails()) {
			return Redirect::to('/teaser/upload');
		}

		if (Input::hasFile('file'))
        {
        	$folder = '/teaser_photo/';
            $path = public_path() . $folder;
            $filename = $original = Input::file('file')->getClientOriginalName();
            $extension = Input::file('file')->getClientOriginalExtension();
            if (File::exists($path . $filename))
            {
                $filename = time() . '_' . $original;
            }
            $file = Input::file('file')->move($path, $filename);
			

			$teaser = new Teaser;
            $teaser->teaser = $folder . $filename;
            $teaser->status = 1;
            $teaser->save();
            return Redirect::to('teaser');
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$teaser = Teaser::findOrFail($id);
		$teaser->status = $teaser->isActive() ? 0 : 1;
		$teaser->save();

		return Redirect::to('teaser');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDestroy($id)
	{
		//larang ngedelete dari url
		if (Input::get('_token') != csrf_token()) {
			App::abort(403, 'No direct access allowed');
		}

		$teaser = Teaser::findOrFail($id);
		$teaser->delete();

		return Redirect::to('teaser');
	}


}
