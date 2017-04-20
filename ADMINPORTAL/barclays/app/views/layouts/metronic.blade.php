<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <meta charset="utf-8"/>
    <title>Barcla Portal</title>
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
    <link rel="stylesheet" href="{{ URL::asset('global/plugins/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('global/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('global/css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('layout/css/layout.css') }}">
     <!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('layout/css/themes/grey.css') }}"> -->
     <link rel="stylesheet" type="text/css" href="{{ URL::asset('layout/css/themes/darkblue.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ URL::asset('layout/css/custom.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="favicon.ico"/>

   <script type="text/javascript">
    $(document).on('submit', '.delete-form', function(){
    return confirm('Are you sure?');
});

   </script>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-container-bg-solid page-sidebar-closed-hide-logo page-header-fixed-mobile page-footer-fixed1">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
<!-- BEGIN HEADER INNER -->
<div class="page-header-inner">
<!-- BEGIN LOGO -->
<div class="page-logo">
    <a href="{{ URL::to('dashboard/') }}">
        {{HTML::image('image/vigil_logo.png','logo',array('height'=>'40px','class'=>'logo-default','style'=>'max-width:150px; margin-top: 5px;margin-left: 35px'))}}
            
    </a>
    <div class="menu-toggler sidebar-toggler">
        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
    </div>
</div>
<!-- END LOGO -->
<!-- BEGIN RESPONSIVE MENU TOGGLER -->
<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
</a>
<!-- END RESPONSIVE MENU TOGGLER -->
<!-- BEGIN PAGE ACTIONS -->
<!-- DOC: Remove "hide" class to enable the page header actions -->
<div class="page-actions">
    <div class="btn-group hide">
        <button type="button" class="btn btn-circle red-pink dropdown-toggle" data-toggle="dropdown">
            <i class="icon-bar-chart"></i>&nbsp;<span class="hidden-sm hidden-xs">New&nbsp;</span>&nbsp;<i class="fa fa-angle-down"></i>
        </button>
        
    </div>

</div>
<!-- END PAGE ACTIONS -->
<!-- BEGIN PAGE TOP -->
<div class="page-top">
<div class="pull-left">

</div>

<!-- BEGIN TOP NAVIGATION MENU -->
<div class="top-menu">

<ul class="nav navbar-nav pull-right">

<!-- BEGIN NOTIFICATION DROPDOWN -->
<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
	{{ $notifications = Session::get('message'); }}
        <i class="icon-bell"></i>
						<span class="badge badge-default">
						{{count($notifications)}} </span>
    </a>
    <ul class="dropdown-menu">
        <li class="external">
            <h3><span class="bold">{{count($notifications)}} pending</span> notifications</h3>
            <a href="">view all</a>
        </li>
        <li>
            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
			
			@if (Session::has('message'))
				
				<li>
                    <a href="javascript:;">
                        <span class="time">just now</span>
										<span class="details">
										<span class="label label-sm label-icon label-success">
										<i class="fa fa-plus"></i>
										</span>
										{{ Session::get('message') }}. </span>
                    </a>
                </li>
			@endif
                


            </ul>
        </li>
    </ul>
</li>
<!-- END NOTIFICATION DROPDOWN -->
<!-- BEGIN INBOX DROPDOWN -->
<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <i class="icon-envelope-open"></i>
						<span class="badge badge-default">
						0 </span>
    </a>
    <ul class="dropdown-menu">
        <li class="external">
            <h3>You have <span class="bold">0 New</span> Messages</h3>
            <a href="page_inbox.html">view all</a>
        </li>
        <li>
            <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                <li>
                    
                </li>


            </ul>
        </li>
    </ul>
</li>
<!-- END INBOX DROPDOWN -->
<!-- BEGIN USER LOGIN DROPDOWN -->
<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-user">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

        {{HTML::image('layout/img/avatar.png','logo',array('class'=>'img-circle'))}}
						<span class="username username-hide-on-mobile">
						{{$user->first_name}} </span>
        <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-default">
        <li>
            <a href="">
                <i class="icon-user"></i> My Profile </a>
        </li>
        
        <li>
            <a href="">
                <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">
								0 </span>
            </a>
        </li>
        
        <li class="divider">
        </li>
        
        <li>
            <a href="{{ URL::to('logout') }}">
                <i class="icon-key"></i>Logout {{$user->first_name}} </a>
        </li>
    </ul>
</li>
<!-- END USER LOGIN DROPDOWN -->
</ul>
</div>
<!-- END TOP NAVIGATION MENU -->
</div>
<!-- END PAGE TOP -->
</div>
<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<div class="page-sidebar navbar-collapse collapse">
<!-- BEGIN SIDEBAR MENU -->
<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
<li class="start active open">
    <a href="javascript:;">
        <i class="icon-graph"></i>
        <span class="title">DASHBOARD</span>
        <span class="selected"></span>
        <span class="arrow open"></span>
    </a>
    <ul class="sub-menu">
        <li>
            <a href="{{ URL::to('dashboardNames/') }}">
                <i class="icon-list"></i>
                top 10 suspicious persons</a>
        </li>
        <li>
            <a href="{{ URL::to('dashboardPlates/') }}">
                <i class="icon-list"></i>
                top 10 suspicious vehcles</a>
        </li>
        <li>
            <a href="{{ URL::to('dashboardPlaces1/') }}">
                <i class="icon-list"></i>
                top 10 suspicious incidents</a>
        </li>
        <li>
            <a href="{{ URL::to('dashboardPlaces2/') }}">
                <i class="icon-list"></i>
                top 10 suspicious location</a>
        </li>
        
        

    </ul>
</li>
<li>
    <a href="javascript:;">
        <i class="icon-present"></i>
        <span class="title">ISSUES</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        
        <li>
            <a href="{{ URL::to('issues/create') }}">
                <i class="icon-list"></i>
                create issue</a>
        </li>
        <li>
            <a href="{{ URL::to('issues') }}">
                <i class="icon-list"></i>
                all issues</a>
        </li>

    </ul>
</li>
<li>
    <a href="javascript:;">
        <i class="icon-present"></i>
        <span class="title">LEADS</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        
        <li>
            <a href="{{ URL::to('leads/create') }}">
                <i class="icon-list"></i>
                create lead</a>
        </li>
        <li>
            <a href="{{ URL::to('leads') }}">
                <i class="icon-list"></i>
                all leads</a>
        </li>

    </ul>
</li>
<li>
    <a href="javascript:;">
        <i class="icon-present"></i>
        <span class="title">MERCHANTS</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        
        <li>
            <a href="{{ URL::to('merchants/create') }}">
                <i class="icon-list"></i>
                add merchant</a>
        </li>
        <li>
            <a href="{{ URL::to('merchants') }}">
                <i class="icon-list"></i>
                all merchants</a>
        </li>

    </ul>
</li>
<li>
    <a href="javascript:;">
        <i class="icon-present"></i>
        <span class="title">BRANCHES</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        
        <li>
            <a href="{{ URL::to('branches/create') }}">
                <i class="icon-list"></i>
                add branch</a>
        </li>
        <li>
            <a href="{{ URL::to('branch') }}">
                <i class="icon-list"></i>
                all branches</a>
        </li>

    </ul>
</li>
<li>
    <a href="javascript:;">
        <i class="icon-present"></i>
        <span class="title">PRODUCTS</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        
        <li>
            <a href="{{ URL::to('products/create') }}">
                <i class="icon-list"></i>
                add product</a>
        </li>
        <li>
            <a href="{{ URL::to('products') }}">
                <i class="icon-list"></i>
                all products</a>
        </li>

    </ul>
</li>
<li>
    <a href="javascript:;">
        <i class="icon-present"></i>
        <span class="title">DEVICES</span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        
        <li>
            <a href="{{ URL::to('devices/create') }}">
                <i class="icon-list"></i>
                add devices</a>
        </li>
        <li>
            <a href="{{ URL::to('devices') }}">
                <i class="icon-list"></i>
                all devices</a>
        </li>

    </ul>
</li>
<li >
    <a href="javascript:;">
        <i class="icon-support"></i>
        <span class="title">HELP</span>

    </a>
    
</li>
<li>
    <a href="javascript:;">
        <i class="icon-info"></i>
        <span class="title">ABOUT</span>
        <span class="arrow "></span>
    </a>
    
</li>


</ul>
<!-- END SIDEBAR MENU -->
</div>
</div>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        Widget settings form goes here
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn blue">Save changes</button>
                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

        <!-- END STYLE CUSTOMIZER -->

        @yield('content')

    </div>
</div>
<!-- END CONTENT -->
<!-- BEGIN QUICK SIDEBAR -->
<!--Cooming Soon...-->
<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
        2015 &copy; Vigil Portal by Fravier Limited
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
{{HTML::script('global/plugins/respond.min.js')}}
{{HTML::script('global/plugins/excanvas.min.js')}}
<![endif]-->
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

{{HTML::script('global/plugins/select2/select2.min.js')}}
{{HTML::script('global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}
{{HTML::script('global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}
{{HTML::script('global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')}}

{{HTML::script('global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
{{HTML::script('global/plugins/jquery.sparkline.min.js')}}
{{HTML::script('pages/scripts/table-advanced.js')}}



<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        
        //ChartsAmcharts.init();
        TableAdvanced.init();


        
        
       


    });
</script>



<!-- END JAVASCRIPTS -->

</body>

<!-- END BODY -->
</html>