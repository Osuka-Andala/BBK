@extends('layouts.metronic')
@section('content')

<!-- BEGIN PAGE HEADER-->

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index-2.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">admin</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">register</a>
        </li>
    </ul>
    
</div>
<h3 class="page-title">
    Administrators <small>add new</small>
</h3>
<!-- END PAGE HEADER-->

<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> add a new administrator
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
   
       {{ Form::open(array('url' => array('register'))) }}
        <div class="form-body">
            @foreach($errors->all() as $key => $value)
                <div class="alert alert-info">{{$value}}</div>
            @endforeach
            <div class="row">
            
            <div class="col-md-6">

        <div class="form-group">
            {{ Form::label('first_name', 'first name') }}
            {{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('last_name', 'last name') }}
            {{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('username', 'email address') }}
            {{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', 'password') }}
            {{ Form::password('password', array('class' => 'form-control')) }}
        </div>
<!--/span-->
                    
                
    </div>
</div>
</div>
            <div class="form-actions right">
                <button type="button" class="btn default">Cancel</button>
                {{ Form::submit('save record', array('class' => 'btn btn-outline btn-primary')) }}
              
            </div>
        {{ Form::close() }}
        <!-- END FORM-->
    </div>
</div>

@stop