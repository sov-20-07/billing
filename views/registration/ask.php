<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Комплект оборудования Continent CHD-04/IR с поддержкой HDTV + карта доступа &quot;Континент HD&quot; с подпиской 1200 – цена, описание, отзывы, технические характеристики</title>
		<meta name="description" content="Комплект оборудования Continent CHD-04/IR с поддержкой HDTV + карта доступа &quot;Континент HD&quot; с подпиской 1200 – интернет-магазин климатического оборудования RuClimat.ru." />
		<meta name="keywords" content="Комплект оборудования Continent CHD-04/IR с поддержкой HDTV + карта доступа &quot;Континент HD&quot; с подпиской 1200, купить" /> 
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<link href="/css/style.css" rel="stylesheet" type="text/css">
		<link href="/css/add.css" rel="stylesheet" type="text/css">
		<script src="/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<link href="/css/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css" />
		<script src="/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>		
		<link href="/css/highslide.css" rel="stylesheet" type="text/css" />
		<script src="/js/highslide-full.js" type="text/javascript"></script>
		<script src="/js/jcarousellite.js"></script>
		<script src="/js/perfectpixel.js" type="text/javascript"></script>
		<script src="/js/basket.js" type="text/javascript"></script>
		<script src="/js/common.js" type="text/javascript"></script>		
		<script src="/js/application.js" type="text/javascript"></script>
		<link href="/js/AlertBox.css" rel="stylesheet" type="text/css" /> 
    	<script src="/js/AlertBox.js" type="text/javascript"></script> 
		<script type="text/javascript">
			langu="";
			hs.graphicsDir = "/js/graphics/";
			hs.outlineType = "rounded-white";
			hs.wrapperClassName = "draggable-header";
			hs.dimmingOpacity = 0.80;
			hs.align = "center";
			$(document).ready(function(){
				$(".pop_img").each(function(){
					this.parentNode.className="highslide";
					$(this.parentNode).click(function(){
						return hs.expand(this,
							{wrapperClassName: 'borderless floating-caption',
								dimmingOpacity: 0.75,
								minHeight: 1200,
								align: 'center'})
					});
	
				});
			})
		</script>
	</head>
	<body class="body" style="text-align: center;">
		<br /><br />
	 	<h1>Авторизация</h1>
	 	<p>Вы успешно прошли авторизацию через <img src="/i/<?=$_SESSION['info']['provider'] ?>.png" /></p>
		<p>Продолжив, вы сможете входить в личный кабинет без ввода пароля</p>
		<a class="new-user" href="#" onclick="opener.location.href='/registration/?ask';self.close();return false;">Новый пользователь</a>
		<a class="bind" href="#" onclick="opener.location.href='/registration/showlogin/?ask';self.close();return false;">Привязать к аккаунту</a>
	</body>
</html>