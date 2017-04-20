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
			<a href="{{ URL::to('devices/') }}">devices</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="#">details</a>
		</li>
	</ul>
	
</div>
<h3 class="page-title">
	Devices <small>details</small>
</h3>
<!-- END PAGE HEADER-->

	
	<div class="portlet blue box">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i>devices details
			</div>
			<div class="actions">
				<a  href="{{ URL::to('devices/' . $devices->id.'/edit') }}" class="btn btn-default btn-sm">
				<i class="fa fa-pencil"></i> Edit </a>
			</div>
		</div>
		<div class="portlet-body">

			<div class="row static-info">
				<div class="col-md-3 name">
					 Device
				</div>
				<div class="col-md-9 value">
					 {{$devices->name}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Description:
				</div>
				<div class="col-md-9 value">
					 {{$devices->description}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Comments:
				</div>
				<div class="col-md-9 value">
					 {{$devices->comments}}
				</div>
			</div>

		

			<div class="row static-info">
				<div class="col-md-3 name">
					 Created on
				</div>
				<div class="col-md-9 value">
					 {{$devices->created_at}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Updated on
				</div>
				<div class="col-md-9 value">
					 {{$devices->updated_at}}
				</div>
			</div>
			
		</div>

@stop