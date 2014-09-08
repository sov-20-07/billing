<!DOCTYPE html>
<!--[if IE 7]><html lang="ru" class="ie7"><![endif]-->
<html lang="ru">
	<head>
	    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	    <title>oneSSA</title>
	    
		<link href="/<?=Funcs::$cdir?>/css/reset.css" rel="stylesheet" type="text/css">
	    <link href="/<?=Funcs::$cdir?>/css/cusel.css" rel="stylesheet" type="text/css">
		<link href="/<?=Funcs::$cdir?>/css/style.css" rel="stylesheet" type="text/css">
	    <link href="/<?=Funcs::$cdir?>/css/jquery.jscrollpane.css" rel="stylesheet" type="text/css">
		
		<!--[if lt IE 9]>
		<script src="/<?=Funcs::$cdir?>/js/html5.js"></script>
		<![endif]-->
		
		<!-- СКРИПТЫ -->
		<script src="/<?=Funcs::$cdir?>/js/jquery-1.9.1.min.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/jquery.easing.1.3.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/jquery.placeholder.min.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/selectivizr-min.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/jquery.jscrollpane.min.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/cusel-fixed-min-2.5.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/jquery.textchange.min.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/jquery.icheck.min.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/jquery.menu-aim.js"></script>
		<script src="/<?=Funcs::$cdir?>/js/common.js"></script>
		<!-- /СКРИПТЫ -->
	</head>
	<body class="authorization_body">
		<section class="ltPage authorization">
			<div class="authorization_block">
				<form action="/<?=Funcs::$cdir?>/login/" method="post" id="LoginForm">
					<img class="authorization_logo" src="/<?=Funcs::$cdir?>/i/onessa_logo.png" alt="oneSSA">
					<div class="authorization_fields">
						<div class="input_text_holder"><input type="text" name="login" class="input_text" placeholder="Логин"></div>
						<div class="input_text_holder"><input type="password"t name="password" class="input_text" placeholder="Пароль"></div>
					</div>
					<?if($_SESSION['error']>1):?>
						<span style="color:#FF0000;margin-left: 8px;font-weight: bold;">Неверно введен логин и/или пароль</span>
					<?endif?>
					<span class="button" onclick="$('#LoginForm').submit()" id="inp1" name="inp1" onkeydown="checkKey(event)">Войти</span>
					<a class="button-pass" href="/<?=Funcs::$cdir?>/login/forgot/">Забыли пароль?</a>
				</form>
			</div>
			<div class="authorization_helper"></div>
		</section>
		<script type="text/javascript">
			document.onkeyup = function (e) { 
			e = e || window.event; 
			if (e.keyCode === 13) { 
				$('#LoginForm').submit()
			} 
				return false; 
			} 
		</script>
	</body>
</html>   