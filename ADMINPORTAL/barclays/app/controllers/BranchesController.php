<?php

class BranchesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Sentry::getUser();
		$branches = Branch::get();
		if (is_null($branches->first())) {
			return View::make('nodata', 
				array('user' => $user,
					'sub_persona'=>'branch',
					'sub_create'=>'branches'));
		}else{
			$counties = County::all();
			return View::make('branches.index', 
				compact('branches'),
				array('user' => $user,))
			->with('counties',$counties);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /branches/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('branches.index')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
    	}
    	$counties=array('' => 'select county') +County::lists('name', 'id');
		
		return View::make('branches.create',array('user' => $user,))
			->with('counties',$counties);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /branches
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules=array(		
			'name'=>'required',
			'county_id'=>'required',
			'manager'=>'required',
			'telephone'=>'required',

			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}else{
			$branches=new Branch;
			$branches->name=Input::get('name');
			$branches->description=Input::get('description');
			$branches->county_id=Input::get('county_id');
			$branches->town=Input::get('town');
			$branches->location=Input::get('location');
			$branches->manager=Input::get('manager');
			$branches->telephone=Input::get('telephone');
			$branches->comments=Input::get('comments');
			$branches->save();

			Session::flash('message', 'The branch information has successfully been updated');
		}

		return Redirect::route('branches.index');
	}

	/**
	 * Display the specified resource.
	 * GET /branches/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('branches.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$branches = Branch::findOrFail($id);
		return View::make('branches.show',
			compact('branches'),
			array('user' => $user,));
	}

	
	/**
	 * Show the form for editing the specified resource.
	 * GET /branches/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('branches.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$branches = Branch::find($id);
		$counties=array('' => 'select county') +County::lists('name', 'id');
		return View::make('branches.edit', 
			compact('branches'),
			array('user' => $user,))
		->with('counties',$counties);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /branches/{id}
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
			$branches=Branch::find($id);
			$branches->name=Input::get('name');
			$branches->description=Input::get('description');
			$branches->county_id=Input::get('county_id');
			$branches->town=Input::get('town');
			$branches->location=Input::get('location');
			$branches->manager=Input::get('manager');
			$branches->telephone=Input::get('telephone');
			$branches->comments=Input::get('comments');
			$branches->save();

			Session::flash('message', 'The branches information has been updated successfully.');
		}

		return Redirect::route('branches.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /branches/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('branches.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		Branch::destroy($id);
		Session::flash('message', 'Successfully deleted the branches records!');
		return Redirect::route('branches.index');
	}

}