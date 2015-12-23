<?php

class WeeklyprogramsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$programs = Weeklyprogram::orderBy('id', 'DESC')->paginate(15);

		return View::make('weeklyprogram.getIndex')->withPrograms($programs);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('weeklyprogram.getCreate');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
        $validator = Validator::make(Input::all(), array(
			'day' => 'required|integer|between:0,6',
            'name' => 'required',
            'from' => 'required|integer|between:1,24',
            'to'    => 'required|integer|between:1,24'
        ));

        if ($validator->fails()) {
        	return Redirect::to('weeklyprogram/create')->withErrors($validator);
        }

		$weeklyprogram = new Weeklyprogram;
		$weeklyprogram->name = Input::get('name');
		$weeklyprogram->day = Input::get('day', 0);
		$weeklyprogram->hour = ['from' => Input::get('from'), 'to' => Input::get('to')];
		
		if ($weeklyprogram->save()) {
			return Redirect::to('weeklyprogram')->withSuccess('program has been added');
		}else{
			return Redirect::to('weeklyprogram/create')->withErrors(['something is wrong']);
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
		$program = Weeklyprogram::findOrFail($id);
		$hour['from'] = ($program->hour_from ?: "1 AM");
		$hour['to'] = ($program->hour_to ?: "1 AM");

		return View::make('weeklyprogram.getEdit')->withProgram($program)->withHour($hour);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate($id)
	{
        $validator = Validator::make(Input::all(), array(
			'day' => 'integer|between:0,6',
            'from' => 'integer|between:1,24',
            'to'    => 'integer|between:1,24'
        ));

        if ($validator->fails()) {
        	return Redirect::back()->withErrors($validator);
        }    

		$program = Weeklyprogram::findOrFail($id);
		$program->day = Input::get('day', $program->day);
		$program->name = Input::get('name', $program->name);
		$program->hour = ['from' => Input::get('from'), 'to' => Input::get('to')];
		$program->save();

		return Redirect::to('weeklyprogram')->withSuccess('berhasil update');
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

		$program = Weeklyprogram::findOrFail($id);
		$program->delete();

		return Redirect::back()->withSuccess('program has been deleted');
	}


}
