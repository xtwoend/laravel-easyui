@extends('layouts.base')

@section('scripthead')
      
@stop

@section('body')
<body class="easyui-layout">
    <div data-options="region:'north',border:false" style="height:40px;padding:6px">
        
        @include('layouts.partials.topmenu')

    </div>
    <!-- Menu Region / Kiri -->
    <div data-options="region:'west',split:true,title:'Navigasi'" style="width:200px;padding:10px;">

       @include('layouts.partials.sidebar')

    </div>
    <!-- Help Region / Kanan -->
    <div data-options="region:'east',split:true,collapsed:true,title:'Help'" style="width:200px;padding:10px;">
        east region
    </div>
    
    <!-- Footer -->
    <div data-options="region:'south',border:false" style="height:35px;padding:10px;">
        south region
    </div>
    
    <!-- Content -->
    <div data-options="region:'center',title:''">
        <div id="tabContent" class="easyui-tabs tabs-content" data-options="fit:true,border:false,plain:true,cache:true">
               @yield('content')
        </div>
    </div>
    @include('about')
</body>
@stop

@section('scriptend')

@stop