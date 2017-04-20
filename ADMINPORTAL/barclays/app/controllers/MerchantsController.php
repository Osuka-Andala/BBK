<?php

class MerchantsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /merchants
	 *
	 * @return Response
	 */
	
	public function index()
	{
		$user = Sentry::getUser();
		$merchants = Merchant::get();
		if (is_null($merchants->first())) {
			return View::make('nodata', 
				array('user' => $user,
					'sub_persona'=>'merchant',
					'sub_create'=>'merchants'));
		}else{
			$counties = County::all();
			return View::make('merchants.index', 
				compact('merchants'),
				array('user' => $user,))
			->with('counties',$counties);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /merchants/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('merchants.index')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
    	}
    	$counties=array('' => 'select county') +County::lists('name', 'id');
		
		return View::make('merchants.create',array('user' => $user,))
			->with('counties',$counties);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /merchants
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
			$merchants=new Merchant;
			$merchants->name=Input::get('name');
			$merchants->description=Input::get('description');
			$merchants->county_id=Input::get('county_id');
			$merchants->town=Input::get('town');
			$merchants->location=Input::get('location');
			$merchants->manager=Input::get('manager');
			$merchants->telephone=Input::get('telephone');
			$merchants->comments=Input::get('comments');
			$merchants->save();

			Session::flash('message', 'The merchant information has successfully been updated');
		}

		return Redirect::route('merchants.index');
	}

	/**
	 * Display the specified resource.
	 * GET /merchants/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('merchants.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$merchants = Merchant::findOrFail($id);
		return View::make('merchants.show',
			compact('merchants'),
			array('user' => $user,));
	}

	
	/**
	 * Show the form for editing the specified resource.
	 * GET /merchants/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('merchants.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$merchants = Merchant::find($id);
		$counties=array('' => 'select county') +County::lists('name', 'id');
		return View::make('merchants.edit', 
			compact('merchants'),
			array('user' => $user,))
		->with('counties',$counties);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /merchants/{id}
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
			$merchants=Merchant::find($id);
			$merchants->name=Input::get('name');
			$merchants->description=Input::get('description');
			$merchants->county_id=Input::get('county_id');
			$merchants->town=Input::get('town');
			$merchants->location=Input::get('location');
			$merchants->manager=Input::get('manager');
			$merchants->telephone=Input::get('telephone');
			$merchants->comments=Input::get('comments');
			$merchants->save();

			Session::flash('message', 'The merchants information has been updated successfully.');
		}

		return Redirect::route('merchants.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /merchants/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('merchants.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		Merchant::destroy($id);
		Session::flash('message', 'Successfully deleted the merchants records!');
		return Redirect::route('merchants.index');
	}

}