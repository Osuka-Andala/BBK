<?php

class ProductsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /products
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Sentry::getUser();
		$products = Product::get();
		if (is_null($products->first())) {
			return View::make('nodata', 
				array('user' => $user,
					'sub_persona'=>'product',
					'sub_create'=>'products'));
		}else{
			return View::make('products.index', 
				compact('products'),
				array('user' => $user,));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /products/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('products.index')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
    	}
		return View::make('products.create',array('user' => $user,));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /products
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
			$products=new Product;
			$products->name=Input::get('name');
			$products->description=Input::get('description');
			$products->comments=Input::get('comments');
			$products->save();

			Session::flash('message', 'The product information has successfully been updated');
		}

		return Redirect::route('products.index');
	}

	/**
	 * Display the specified resource.
	 * GET /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('products.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$products = Product::findOrFail($id);
		return View::make('products.show',
			compact('products'),
			array('user' => $user,));
	}

	
	/**
	 * Show the form for editing the specified resource.
	 * GET /products/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('products.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		$products = Product::find($id);
		return View::make('products.edit', 
			compact('products'),
			array('user' => $user,));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /products/{id}
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
			$products=Product::find($id);
			$products->name=Input::get('name');
			$products->description=Input::get('description');
			$products->comments=Input::get('comments');
			$products->save();

			Session::flash('message', 'The products information has been updated successfully.');
		}

		return Redirect::route('products.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Sentry::getUser();
		if (!$user->hasAccess('products.show')) {
      		return View::make('unauthorized', 
				array('user' => $user,));
      	}
		Product::destroy($id);
		Session::flash('message', 'Successfully deleted the products records!');
		return Redirect::route('products.index');
	}

}