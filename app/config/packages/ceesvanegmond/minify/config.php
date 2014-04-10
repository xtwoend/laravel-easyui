<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | App environments to not minify
    |--------------------------------------------------------------------------
    |
    | These environments will not be minified
    |
    */

    'ignore_envionments' => array(
	     'local',
    ),

	/*
    |--------------------------------------------------------------------------
    | CSS path and CSS build path
    |--------------------------------------------------------------------------
    |
    | Minify is an extention that can minify your css files into one build file.
    | The css_path property is the location where your CSS files are located
    | The css_builds_path property is the location where the builded files are
    | stored.  THis is relative to the css_path property.
    |
    */

    'css_build_path' => '/css/',

	/*
    |--------------------------------------------------------------------------
    | JS path and JS build path
    |--------------------------------------------------------------------------
    |
    | Minify is an extention that can minify your JS files into one build file.
    | The JS_path property is the location where your JS files are located
    | The JS_builds_path property is the location where the builded files are
    | stored.  THis is relative to the css_path property.
    |
    */

    'js_build_path' => '/js/',

);
