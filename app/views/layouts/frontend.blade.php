@extends('layouts.base')

@section('scripthead')


@stop

@section('body')
<body>

    @yield('content')      

</body>
@stop

@section('scriptend')
	
	<script type="text/javascript">
    $(function(){
    	
    });
    </script>
    
@stop