@extends('layouts.metronic')
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@section('content')
<div class="well bs-component">
    <fieldset>
        <legend>
            <p>No {{$sub_persona}} records found </p>
        </legend>
        <p>

        <div class="alert alert-dismissable alert-danger">

            No {{$sub_persona}} information has been saved yet. Would you like to create one ?

        </div>
        <p>
            <a class="btn btn-outline btn-info"
               href="{{ URL::to(''.$sub_create.'/create') }}">Create</a>
            <a class="btn btn-outline btn-warning" href="{{ URL::to('/') }}">Cancel</a>
        </p>
        </p>


    </fieldset>
</div>


@stop