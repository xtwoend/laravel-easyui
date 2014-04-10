@extends('layouts.frontend')

@section('scripthead')


@stop

@section('title')
    Login
@stop

@section('content')
    
    <div class="easyui-window" title="Login" style="width:300px;height:145px;" data-options="collapsible:true">
        {{ Form::open(array('url' => route('auth.store'), 'method' => 'post', 'style'=> 'padding:10px;')) }}
            <div class="row">
                <div class="small-3 columns">
                    <label for="username" class="left inline">Username</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" id="username" name="username" class="form-control">
                </div>
            </div>
            
            <div class="row">
                <div class="small-3 columns">
                    <label for="password" class="left inline">Password</label>
                </div>
                <div class="small-9 columns">
                    <input type="password" id="password" name="password" class="form-control">
                </div>
            </div>

            <div class="row">
                <button type="submit" class="tiny right"><i class="fa fa-lock"></i> Login</button>
            </div>
        {{ Form::close() }}
    </div>

@stop

@section('scriptend')
	
	
@stop