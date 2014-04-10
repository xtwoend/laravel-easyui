<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Dian Taksi :: 
            @yield('title')
        </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<link rel="shortcut icon" href="/assets/img/favicon.ico"/>
		<link rel="icon" type="image/gif" href="/assets/img/favicon.gif">
		
		@foreach(Config::get('themes.cssmaster') as $css)
			{{ HTML::style($css) }}
		@endforeach

        @yield('stylehead')

        <!--[if lt IE 9]>
           
        <![endif]-->
        @foreach(Config::get('themes.jsmaster') as $js)
			{{ HTML::script($js) }}
        @endforeach

        @yield('scripthead')

	</head>

    @yield('body')
	
    @yield('scriptend')

</html>