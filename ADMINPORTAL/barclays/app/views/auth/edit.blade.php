@extends('layouts.metronic')

@section('content')



<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
    Administrators <small> modify</small>
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
            <a href="#">modify details</a>
        </li>
    </ul>
    
</div>
<!-- END PAGE HEADER-->




<div class="portlet box blue">

    <div class="portlet-title">

        <div class="caption">

            <i class="fa fa-gift"></i> modify administrator

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



      {{ Form::model($users, array('route' => array('admin.auth.update', $users->id), 'method' => 'PUT')) }}

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

        <div class="form-group">
            {{ Form::label('select_group', 'admin level') }}
            <select  name="select_group" class="form-control" id="select_group" >          
            </select>

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


<script type="text/javascript">
        $.ajax({
            type: 'GET',
            url:  '{{ URL::to("admin/dropdown/getUserGroups") }}',
            contentType: "application/json; charset=utf-8",
            dataType: "json",

            success:function(results){
                $.each(results,function(i,group){
                    if(group){
                         $('#select_group')
                             .append($("<option></option>")
                             .attr("value",group.id)
                             .text(group.name)); 
                    }
                   
                   
                });
            },
            error:function(x,error){
                alert("Problem:" +error);
            }

        });
   

</script>
@stop