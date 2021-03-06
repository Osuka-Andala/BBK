@extends('layouts.metronic')
@section('content')

<!-- BEGIN PAGE HEADER-->

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ URL::to('/') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="{{ URL::to('products/') }}">products</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="#">details</a>
		</li>
	</ul>
	
</div>
<h3 class="page-title">
	Products <small>details</small>
</h3>
<!-- END PAGE HEADER-->

	
	<div class="portlet blue box">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i>products details
			</div>
			<div class="actions">
				<a  href="{{ URL::to('products/' . $products->id.'/edit') }}" class="btn btn-default btn-sm">
				<i class="fa fa-pencil"></i> Edit </a>
			</div>
		</div>
		<div class="portlet-body">

			<div class="row static-info">
				<div class="col-md-3 name">
					 Product
				</div>
				<div class="col-md-9 value">
					 {{$products->name}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Description:
				</div>
				<div class="col-md-9 value">
					 {{$products->description}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Comments:
				</div>
				<div class="col-md-9 value">
					 {{$products->comments}}
				</div>
			</div>

		

			<div class="row static-info">
				<div class="col-md-3 name">
					 Created on
				</div>
				<div class="col-md-9 value">
					 {{$products->created_at}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Updated on
				</div>
				<div class="col-md-9 value">
					 {{$products->updated_at}}
				</div>
			</div>
			
		</div>

@stop