<?php

class LeadsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /leads
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Sentry::getUser();
		$leads = Lead::get();
		if (is_null($leads->first())) {
			return View::make('nodata', 
				array('user' => $user,
					'sub_persona'=>'lead',
					'sub_create'=>'leads'));
		}else{
			$counties = County::all();
			return View::make('leads.index', 
				compact('leads'),
				array('user' => $user,))
			->with('counties',$counties);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /leads/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('leads.index')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
    	}
    	$counties=array('' => 'select county') +County::lists('name', 'id');
		
		return View::make('leads.create',array('user' => $user,))
			->with('counties',$counties);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /leads
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules=array(		
			'user_id'=>'required',
			'product_id'=>'required',
			'branch_id'=>'required',
			'name'=>'required',
			'phone'=>'required',

			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}else{
			$leads=new Lead;
			$leads->user_id=Input::get('user_id');
			$leads->product_id=Input::get('product_id');
			$leads->branch_id=Input::get('branch_id');
			$leads->manager=Input::get('manager');
			$leads->name=Input::get('name');
			$leads->phone=Input::get('phone');
			$leads->address=Input::get('address');
			$leads->description=Input::get('description');
			$leads->comments=Input::get('comments');
			$leads->save();

			Session::flash('message', 'The lead information has successfully been updated');
		}

		return Redirect::route('leads.index');
	}

	/**
	 * Display the specified resource.
	 * GET /leads/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function api_store()
	{
		$rules=array(		
			'user_id'=>'required',
			'product_id'=>'required',
			'branch_id'=>'required',
			'name'=>'required',
			'phone'=>'required',

			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails()){
			$response=array(
                'error' => true,
                'code' => 200,
                'message' => array(
                	'application'=>false,
                	'error'=>$validator->errors()->all()));
		}else{
			$leads=new Lead;
			$leads->user_id=Input::get('user_id');
			$leads->product_id=Input::get('product_id');
			$leads->branch_id=Input::get('branch_id');
			$leads->manager=Input::get('manager');
			$leads->name=Input::get('name');
			$leads->phone=Input::get('phone');
			$leads->description=Input::get('description');
			$leads->address=Input::get('address');
			$leads->comments=Input::get('comments');
			$leads_save_response=$leads->save();

			if($leads_save_response){
				$response=array(
		                'error' => false,
		                'code' => 200,
		                'message' => array(
		                	'application'=>false,
		                	'error'=>'successfully'));
			}else{
				$response=array(
		                'error' => true,
		                'code' => 200,
		                'message' => array(
		                	'application'=>false,
		                	'error'=>'Error in discount application'));
			}

			
		}
		return Response::json($response, 200);
	}

	/**
	 * Display the specified resource.
	 * GET /leads/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('leads.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$leads = Lead::findOrFail($id);
		return View::make('leads.show',
			compact('leads'),
			array('user' => $user,));
	}

	
	/**
	 * Show the form for editing the specified resource.
	 * GET /leads/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('leads.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$leads = Lead::find($id);
		$counties=array('' => 'select county') +County::lists('name', 'id');
		return View::make('leads.edit', 
			compact('leads'),
			array('user' => $user,))
		->with('counties',$counties);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /leads/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules=array(	
			'user_id'=>'required',
			'product_id'=>'required',
			'branch_id'=>'required',
			'name'=>'required',
			'phone'=>'required',
		);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}else{
			$leads=Lead::find($id);
			$leads->user_id=Input::get('user_id');
			$leads->product_id=Input::get('product_id');
			$leads->branch_id=Input::get('branch_id');
			$leads->manager=Input::get('manager');
			$leads->name=Input::get('name');
			$leads->phone=Input::get('phone');
			$leads->address=Input::get('address');
			$leads->description=Input::get('description');
			$leads->comments=Input::get('comments');
			$leads->save();

			Session::flash('message', 'The leads information has been updated successfully.');
		}

		return Redirect::route('leads.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /leads/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('leads.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		Lead::destroy($id);
		Session::flash('message', 'Successfully deleted the leads records!');
		return Redirect::route('leads.index');
	}

}