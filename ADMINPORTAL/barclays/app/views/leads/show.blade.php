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
			<a href="{{ URL::to('leads/') }}">leads</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="#">details</a>
		</li>
	</ul>
	
</div>
<h3 class="page-title">
	Leads <small>details</small>
</h3>
<!-- END PAGE HEADER-->

	
	<div class="portlet blue box">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i>leads details
			</div>
			<div class="actions">
				<a  href="{{ URL::to('leads/' . $leads->id.'/edit') }}" class="btn btn-default btn-sm">
				<i class="fa fa-pencil"></i> Edit </a>
			</div>
		</div>
		<div class="portlet-body">

			<div class="row static-info">
				<div class="col-md-3 name">
					 Lead
				</div>
				<div class="col-md-9 value">
					 {{$leads->name}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Description:
				</div>
				<div class="col-md-9 value">
					 {{$leads->description}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Description:
				</div>
				<div class="col-md-9 value">
					 {{$leads->county->name}}
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-3 name">
					 Town:
				</div>
				<div class="col-md-9 value">
					 {{$leads->town}}
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-3 name">
					 Location:
				</div>
				<div class="col-md-9 value">
					 {{$leads->location}}
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-3 name">
					 Lead Manager:
				</div>
				<div class="col-md-9 value">
					 {{$leads->manager}}
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-3 name">
					 Telephone:
				</div>
				<div class="col-md-9 value">
					 {{$leads->telephone}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Comments:
				</div>
				<div class="col-md-9 value">
					 {{$leads->comments}}
				</div>
			</div>

		

			<div class="row static-info">
				<div class="col-md-3 name">
					 Created on
				</div>
				<div class="col-md-9 value">
					 {{$leads->created_at}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Updated on
				</div>
				<div class="col-md-9 value">
					 {{$leads->updated_at}}
				</div>
			</div>
			
		</div>

@stop