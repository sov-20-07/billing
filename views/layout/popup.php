<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    <title>Добавить в корзину</title>
	    <link href="/css/style.css" rel="stylesheet" type="text/css">
	    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/css/ie7.css"><![endif]--> 
	    <script src="/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<script>
			function closeme(){
				window.parent.hs.close();
			}
		</script>
	</head>
	<body class="popup">
		<span class="close" style="position: absolute;z-index: 200;top:20px;right:20px;" onclick="closeme();"></span>
		{content}
	</body>
</html>