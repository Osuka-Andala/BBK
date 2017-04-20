<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <meta charset="utf-8"/>
    <title>Barclays</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('global/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('global/plugins/simple-line-icons/simple-line-icons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('global/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('global/plugins/uniform/css/uniform.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}">
    <!-- Data tables -->
    <link rel="stylesheet" href="{{ URL::asset('global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pages/css/lock.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('global/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('global/css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('layout/css/layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('layout/css/themes/grey.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('layout/css/custom.css') }}">

    <link rel="shortcut icon" href="favicon.ico"/>
</head>

<body>
<div class="page-lock">
	<div class="page-logo">
		<a class="brand" href="">
		{{HTML::image('image/vigil_logo_bird.png','logo',array('height'=>'150px','class'=>'lock-avatar'))}}
		<h2>BARCLAYS PORTAL</h2>
		</a>
	</div>
	<div class="page-body">
		<div class="lock-head">
			 Login
		</div>
		<div class="lock-body">
			<div class="pull-left lock-avatar-block">
				{{HTML::image('image/login_avatar.png','logo',array('width'=>'100px','height'=>'100px','class'=>'lock-avatar'))}}
			</div>
			

            {{ Form::open(array('url' => array('login'),'class'=>'lock-form pull-left')) }}
				<div class="form-group">				
					{{ Form::text('username', Input::old('username'), array('class' => 'form-control placeholder-no-fix','placeholder' => 'Email')) }}
                </div>
				
				<div class="form-group">					
					{{ Form::password('password', array('class' => 'form-control placeholder-no-fix','autocomplete' => 'off','placeholder' => 'Password')) }}
				</div>
				
				<div class="form-actions">
				 {{ Form::submit('login', array('class' => 'btn btn-success uppercase'))}}
				
				</div>
			{{ Form::close() }}
		</div>
		<div class="lock-bottom">
			@if (Session::has('message'))
                    <div class="alert alert-warning">{{ Session::get('message') }}</div>
            @endif
		</div>
	</div>
	<div class="page-footer-custom">
		 2015 &copy; IntellApps Limited.
	</div>
</div>



{{HTML::script('global/plugins/jquery.min.js')}}
{{HTML::script('global/plugins/jquery-migrate.min.js')}}
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

{{HTML::script('global/plugins/jquery-ui/jquery-ui.min.js')}}
{{HTML::script('global/plugins/bootstrap/js/bootstrap.min.js')}}
{{HTML::script('global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}
{{HTML::script('global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}
{{HTML::script('global/plugins/jquery.blockui.min.js')}}
{{HTML::script('global/plugins/jquery.cokie.min.js')}}
{{HTML::script('global/plugins/uniform/jquery.uniform.min.js')}}
{{HTML::script('global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}
<!-- END CORE PLUGINS -->
{{HTML::script('global/scripts/metronic.js')}}
{{HTML::script('layout/scripts/layout.js')}}
{{HTML::script('layout/scripts/demo.js')}}

{{HTML::script('global/plugins/datatables/media/js/jquery.dataTables.min.js')}}
{{HTML::script('global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}

<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
       // Demo.init(); // init demo features
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>
<!-- END JAVASCRIPTS -->

</body>

<!-- END BODY -->
</html>