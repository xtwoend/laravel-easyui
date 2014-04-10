<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Basic DateBox - jQuery EasyUI Demo</title>

	<link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="foundation/css/foundation.min.css">
	
	{{ javascript(Config::get('themes.jsmaster')) }}

</head>
<body>
	<h2>Basic DateBox</h2>
	<div class="demo-info">
		<div class="demo-tip icon-tip"></div>
		<div>Click the calendar image on the right side.</div>
	</div>
	<div style="margin:10px 0;"></div>
	<input class="easyui-datebox"></input>
</body>
</html>