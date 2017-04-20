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
			<a href="{{ URL::to('branches/') }}">branches</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="#">details</a>
		</li>
	</ul>
	
</div>
<h3 class="page-title">
	Branches <small>details</small>
</h3>
<!-- END PAGE HEADER-->

	
	<div class="portlet blue box">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i>branches details
			</div>
			<div class="actions">
				<a  href="{{ URL::to('branches/' . $branches->id.'/edit') }}" class="btn btn-default btn-sm">
				<i class="fa fa-pencil"></i> Edit </a>
			</div>
		</div>
		<div class="portlet-body">

			<div class="row static-info">
				<div class="col-md-3 name">
					 Branch
				</div>
				<div class="col-md-9 value">
					 {{$branches->name}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Description:
				</div>
				<div class="col-md-9 value">
					 {{$branches->description}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Description:
				</div>
				<div class="col-md-9 value">
					 {{$branches->county->name}}
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-3 name">
					 Town:
				</div>
				<div class="col-md-9 value">
					 {{$branches->town}}
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-3 name">
					 Location:
				</div>
				<div class="col-md-9 value">
					 {{$branches->location}}
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-3 name">
					 Branch Manager:
				</div>
				<div class="col-md-9 value">
					 {{$branches->manager}}
				</div>
			</div>
			<div class="row static-info">
				<div class="col-md-3 name">
					 Telephone:
				</div>
				<div class="col-md-9 value">
					 {{$branches->telephone}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Comments:
				</div>
				<div class="col-md-9 value">
					 {{$branches->comments}}
				</div>
			</div>

		

			<div class="row static-info">
				<div class="col-md-3 name">
					 Created on
				</div>
				<div class="col-md-9 value">
					 {{$branches->created_at}}
				</div>
			</div>

			<div class="row static-info">
				<div class="col-md-3 name">
					 Updated on
				</div>
				<div class="col-md-9 value">
					 {{$branches->updated_at}}
				</div>
			</div>
			
		</div>

@stop