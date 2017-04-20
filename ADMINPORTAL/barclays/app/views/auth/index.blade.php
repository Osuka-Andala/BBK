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
            <a href="#">all administrators</a>
        </li>
    </ul>
    
</div>
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



    <div class="portlet-body">

        <!-- BEGIN FORM-->





	    <table class="table table-striped table-bordered table-hover" id="dataTables-example">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Email</th>

                    <th>First name</th>

                    <th>Last name</th>

                    <th>Last login</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                @foreach($users as $key => $value)

                <tr>

                    <td>{{ $value->id }}</td>

                    <td>{{ $value->email }}</td>

                    <td>{{ $value->first_name }}</td>

                    <td>{{ $value->last_name }}</td>

                    <td>{{ $value->last_login }}</td>

                     <td>

                        {{ Form::open(array('url' => 'auth/' . $value->id, 'class' =>

                        'pull-right')) }}

                        {{ Form::hidden('_method', 'DELETE') }}

                        {{ Form::submit('delete', array('class' => 'btn btn-outline btn-warning btn-xs')) }}

                        {{ Form::close() }}





                        <!-- delete the employee (uses the destroy method DESTROY /employees/{id} -->

                        <!-- we will add this later since its a little more complicated than the other two buttons -->



                        <!-- show the employee (uses the show method found at GET /employees/{id} -->

                        <a class="btn btn-outline btn-success btn-xs pull-right"

                           href="{{ URL::to('admin/auth/' . $value->id) }}">details</a>



                        <!-- edit this employee (uses the edit method found at GET /employees/{id}/edit -->



                    </td>

                </tr>

                @endforeach

            </tbody>

       </table>







    </div>

</div>

</div>

            

    </div>

</div>



@stop