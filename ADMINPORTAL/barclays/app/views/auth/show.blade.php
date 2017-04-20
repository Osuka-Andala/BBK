@extends('layouts.metronic')

@section('content')



<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
    Administrators <small>all administrators</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ URL::to('admin/') }}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ URL::to('admin/auth/') }}">administrators</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">details</a>
        </li>
    </ul>
    
</div>
<!-- END PAGE HEADER-->

	

	<div class="portlet blue box">

		<div class="portlet-title">

			<div class="caption">

				<i class="fa fa-cogs"></i>administrators details

			</div>

			<div class="actions">

				<a  href="{{ URL::to('admin/auth/' . $users->id.'/edit') }}" class="btn btn-default btn-sm">
				<i class="fa fa-pencil"></i> Edit </a>


            </div>


			

		</div>

		<div class="portlet-body">



			<div class="row static-info">

				<div class="col-md-3 name">

					 Email:

				</div>

				<div class="col-md-9 value">

					 {{$users->email}}

				</div>

			</div>



			

			<div class="row static-info">

				<div class="col-md-3 name">

					 First Name:

				</div>

				<div class="col-md-9 value">

					 {{$users->first_name}}

				</div>

			</div>

		



			<div class="row static-info">

				<div class="col-md-3 name">

					 Last Name:

				</div>

				<div class="col-md-9 value">

					 {{$users->last_name}}

				</div>

			</div>



			<div class="row static-info">

				<div class="col-md-3 name">

					 Last login:

				</div>

				<div class="col-md-9 value">

					 {{$users->last_login}}

				</div>

			</div>

			

		</div>



@stop