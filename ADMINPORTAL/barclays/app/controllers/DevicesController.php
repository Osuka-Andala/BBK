<?php

class DevicesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /devices
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Sentry::getUser();
		$devices = Device::get();
		if (is_null($devices->first())) {
			return View::make('nodata', 
				array('user' => $user,
					'sub_persona'=>'device',
					'sub_create'=>'devices'));
		}else{
			return View::make('devices.index', 
				compact('devices'),
				array('user' => $user,));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /devices/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('devices.index')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
    	}
		return View::make('devices.create',array('user' => $user,));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /devices
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules=array(		
			'name'=>'required',
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}else{
			$devices=new Device;
			$devices->name=Input::get('name');
			$devices->description=Input::get('description');
			$devices->comments=Input::get('comments');
			$devices->save();

			Session::flash('message', 'The device information has successfully been updated');
		}

		return Redirect::route('devices.index');
	}

	/**
	 * Display the specified resource.
	 * GET /devices/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('devices.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$devices = Device::findOrFail($id);
		return View::make('devices.show',
			compact('devices'),
			array('user' => $user,));
	}

	
	/**
	 * Show the form for editing the specified resource.
	 * GET /devices/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('devices.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$devices = Device::find($id);
		return View::make('devices.edit', 
			compact('devices'),
			array('user' => $user,));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /devices/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules=array(	
			'name'=>'required',	
		);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}else{
			$devices=Device::find($id);
			$devices->name=Input::get('name');
			$devices->description=Input::get('description');
			$devices->comments=Input::get('comments');
			$devices->save();

			Session::flash('message', 'The devices information has been updated successfully.');
		}

		return Redirect::route('devices.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /devices/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('devices.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		Device::destroy($id);
		Session::flash('message', 'Successfully deleted the devices records!');
		return Redirect::route('devices.index');
	}

}