<?php

class CountiesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /counties
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Sentry::getUser();
		$counties = County::get();
		if (is_null($counties->first())) {
			return View::make('nodata', 
				array('user' => $user,
					'sub_persona'=>'county',
					'sub_create'=>'counties'));
		}else{
			return View::make('counties.index', 
				compact('counties'),
				array('user' => $user,));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /counties/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('counties.index')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
    	}
		return View::make('counties.create',array('user' => $user,));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /counties
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
			$counties=new County;
			$counties->name=Input::get('name');
			$counties->description=Input::get('description');
			$counties->comments=Input::get('comments');
			$counties->save();

			Session::flash('message', 'The county information has successfully been updated');
		}

		return Redirect::route('counties.index');
	}

	/**
	 * Display the specified resource.
	 * GET /counties/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('counties.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$counties = County::findOrFail($id);
		return View::make('counties.show',
			compact('counties'),
			array('user' => $user,));
	}

	
	/**
	 * Show the form for editing the specified resource.
	 * GET /counties/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('counties.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$counties = County::find($id);
		return View::make('counties.edit', 
			compact('counties'),
			array('user' => $user,));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /counties/{id}
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
			$counties=County::find($id);
			$counties->name=Input::get('name');
			$counties->description=Input::get('description');
			$counties->comments=Input::get('comments');
			$counties->save();

			Session::flash('message', 'The counties information has been updated successfully.');
		}

		return Redirect::route('counties.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /counties/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('counties.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		County::destroy($id);
		Session::flash('message', 'Successfully deleted the counties records!');
		return Redirect::route('counties.index');
	}

}