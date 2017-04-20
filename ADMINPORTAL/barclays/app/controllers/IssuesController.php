<?php

class IssuesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /issues
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Sentry::getUser();
		$issues = Issue::get();
		if (is_null($issues->first())) {
			return View::make('nodata', 
				array('user' => $user,
					'sub_persona'=>'issue',
					'sub_create'=>'issues'));
		}else{
			$counties = County::all();
			return View::make('issues.index', 
				compact('issues'),
				array('user' => $user,))
			->with('counties',$counties);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /issues/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('issues.index')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
    	}
    	$counties=array('' => 'select county') +County::lists('name', 'id');
		
		return View::make('issues.create',array('user' => $user,))
			->with('counties',$counties);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /issues
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules=array(		
			'user_id'=>'required',
			'device_id'=>'required',
			'merchant_id'=>'required',
			'name'=>'required',
			'phone'=>'required',

			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}else{
			$issues=new Issue;
			$issues->user_id=Input::get('user_id');
			$issues->device_id=Input::get('device_id');
			$issues->merchant_id=Input::get('merchant_id');
			$issues->manager=Input::get('manager');
			$issues->name=Input::get('name');
			$issues->phone=Input::get('phone');
			$issues->address=Input::get('address');
			$issues->description=Input::get('description');
			$issues->comments=Input::get('comments');
			$issues->save();

			Session::flash('message', 'The issue information has successfully been updated');
		}

		return Redirect::route('issues.index');
	}

	/**
	 * Display the specified resource.
	 * GET /issues/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function api_store()
	{
		$rules=array(		
			'user_id'=>'required',
			'device_id'=>'required',
			'merchant_id'=>'required',
			'issue'=>'required',

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
			$issues=new Issue;
			$issues->user_id=Input::get('user_id');
			$issues->device_id=Input::get('device_id');
			$issues->merchant_id=Input::get('merchant_id');
			$issues->location=Input::get('location');
			$issues->description=Input::get('description');
			$issues->issue=Input::get('issue');
			$issues->issue_other=Input::get('issue_other');
			$issues->serial_no=Input::get('serial_no');
			$issues->comments=Input::get('comments');
			$issues_save_response=$issues->save();

			if($issues_save_response){
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
	 * GET /issues/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('issues.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$issues = Issue::findOrFail($id);
		return View::make('issues.show',
			compact('issues'),
			array('user' => $user,));
	}

	
	/**
	 * Show the form for editing the specified resource.
	 * GET /issues/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('issues.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$issues = Issue::find($id);
		$counties=array('' => 'select county') +County::lists('name', 'id');
		return View::make('issues.edit', 
			compact('issues'),
			array('user' => $user,))
		->with('counties',$counties);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /issues/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules=array(	
			'user_id'=>'required',
			'device_id'=>'required',
			'merchant_id'=>'required',
			'name'=>'required',
			'phone'=>'required',
		);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}else{
			$issues=Issue::find($id);
			$issues->user_id=Input::get('user_id');
			$issues->device_id=Input::get('device_id');
			$issues->merchant_id=Input::get('merchant_id');
			$issues->manager=Input::get('manager');
			$issues->name=Input::get('name');
			$issues->phone=Input::get('phone');
			$issues->address=Input::get('address');
			$issues->description=Input::get('description');
			$issues->comments=Input::get('comments');
			$issues->save();

			Session::flash('message', 'The issues information has been updated successfully.');
		}

		return Redirect::route('issues.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /issues/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('issues.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		Issue::destroy($id);
		Session::flash('message', 'Successfully deleted the issues records!');
		return Redirect::route('issues.index');
	}

}