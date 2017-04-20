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
         <a href="{{ URL::to('personas/') }}">merchants</a>
         <i class="fa fa-angle-right"></i>
      </li>
      <li>
         <a href="#">new</a>
      </li>
   </ul>
</div>
<h3 class="page-title">
   Merchants <small>add new</small>
</h3>
<!-- END PAGE HEADER-->
<div class="portlet box blue">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-gift"></i> add new merchant details
      </div>
      <div class="tools">
         <a href="#" class="collapse">
         </a>
         <a href="#" class="reload">
         </a>
      </div>
   </div>
   <div class="portlet-body form">
      <!-- BEGIN FORM-->
      {{ Form::open(array('route' => array('merchants.index'),'class'=>'horizontal-form ')) }}
      <div class="form-body">
         @foreach($errors->all() as $key => $value)
         <div class="alert alert-info">{{$value}}</div>
         @endforeach
         <div class="row">
            <div class="col-md-6">
               <div class="form-group">
                  {{ Form::label('name', 'Merchant') }}
                  {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
               </div>
               <div class="form-group">
                  {{ Form::label('description', 'Description') }}
                  {{ Form::text('description', Input::old('description'), array('class' => 'form-control')) }}
               </div>
               <div class="form-group">
                  {{ Form::label('county_id', 'County') }}
                  {{ Form::select('county_id',$counties, Input::old('county_id'), array('class'
                  => 'form-control')) }}

              </div>
               <div class="form-group">
                  {{ Form::label('town', 'Town') }}
                  {{ Form::text('town', Input::old('town'), array('class' => 'form-control')) }}
               </div>
                <div class="form-group">
                  {{ Form::label('location', 'Location') }}
                  {{ Form::text('location', Input::old('location'), array('class' => 'form-control')) }}
               </div>
                <div class="form-group">
                  {{ Form::label('manager', 'Contact Person') }}
                  {{ Form::text('manager', Input::old('description'), array('class' => 'form-control')) }}
               </div>
               <div class="form-group">
                  {{ Form::label('comments', 'Comments') }}
                  {{ Form::text('comments', Input::old('comments'), array('class' => 'form-control')) }}
               </div>
                <div class="form-group">
                  {{ Form::label('telephone', 'Merchant Contact Information') }}
                  {{ Form::text('telephone', Input::old('telephone'), array('class' => 'form-control')) }}
               </div>
            </div>
         </div>
      </div>
      <div class="form-actions right">
         <button type="button" class="btn default">Cancel</button>
         {{ Form::submit('save merchant', array('class' => 'btn btn-outline btn-primary')) }}
      </div>
      {{ Form::close() }}
      <!-- END FORM-->
   </div>
</div>
@stop
