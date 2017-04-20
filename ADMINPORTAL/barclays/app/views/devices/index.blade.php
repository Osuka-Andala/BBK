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
         <a href="#">all</a>
      </li>
   </ul>
</div>
<h3 class="page-title">
   Devices <small>all devices</small>
</h3>
<!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-globe"></i>all devices
      </div>
      <div class="tools">
         <a href="#" class="collapse">
         </a>
         <a href="#" class="reload">
         </a>
      </div>
   </div>
   <div class="portlet-body">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
         <thead>
            <tr>
               <th>#</th>
               <th>Name</th>
               <th>Description</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
            @foreach($devices as $key => $value)
            <tr>
               <td>{{ $value->id }}</td>
               <td>{{ $value->name }}</td>
               <td>{{ $value->description }}</td>
               <!-- we will also add show, edit, and delete buttons -->
               <td>
                  {{ Form::open(array('url' => 'devices/' . $value->id, 'class' =>
                  'pull-right')) }}
                  {{ Form::hidden('_method', 'DELETE') }}
                  {{ Form::submit('delete', array('class' => 'btn btn-outline btn-warning btn-xs')) }}
                  {{ Form::close() }}
                  <!-- delete the employee (uses the destroy method DESTROY /employees/{id} -->
                  <!-- we will add this later since its a little more complicated than the other two buttons -->
                  <!-- show the employee (uses the show method found at GET /employees/{id} -->
                  <a class="btn btn-outline btn-success btn-xs pull-right"
                     href="{{ URL::to('devices/' . $value->id) }}">details</a>
                  <!-- edit this employee (uses the edit method found at GET /employees/{id}/edit -->
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
@stop
