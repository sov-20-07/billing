<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <title><?=Funcs::$seo_title?></title>
	    <meta name="description" content="<?=Funcs::$seo_description?>" />
		<meta name="keywords" content="<?=Funcs::$seo_keywords?>" /> 
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
		
		<link href="/css/main.css" rel="stylesheet" type="text/css">
	    <link href="/css/cabinet.css" rel="stylesheet" type="text/css">
	    <link href="/css/default.css" rel="stylesheet" type="text/css">
	    <link href="/css/jquery.selectBox.css" rel="stylesheet" type="text/css">
	    <link href="/css/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css">
	    <link href="/css/add.css" rel="stylesheet" type="text/css">
	    
	    <script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
		<script src="/js/jcarousellite.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script src="/js/jquery.selectBox.min.js" type="text/javascript"></script>
		<script src="/js/basket.js" type="text/javascript"></script>
	    <script src="/js/common.js" type="text/javascript"></script>
	    <script src="/js/application.js" type="text/javascript"></script>
		<link href="/js/highslide.css" rel="stylesheet" type="text/css" /> 
	    <script src="/js/highslide-full.js" type="text/javascript"></script> 
	    <script type="text/javascript"> 
			langu="";
			hs.graphicsDir = "/js/graphics/";
			hs.outlineType = "rounded-white";
			hs.wrapperClassName = "draggable-header";
			hs.dimmingOpacity = 0.80;
			hs.align = "center";
			$("document").ready(function(){
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
	<body>
	<div id="wrapper">
		<div id="header" class="fixed_width">
			<span class="logo" title="Fotobuka"><img src="/i/logo.png" alt="Fotobuka" /></span>
		</div>
		<div style="margin-left:20px;">
		{content}
		</div>
        <div id="spacer"></div>
    </div>
    <!-- /"обёртка" -->

    <!-- подвал -->
    <div id="footer" class="fixed_width">
    	<div class="dotted_line"></div>
        <div class="copy"><img src="/i/small_logo.gif" alt="fotobuka" title="fotobuka" /><span>2012&copy;</span></div>
		<div class="studio-developer">
			Создание сайта<br clear="all">
			<img src="/i/onetouch_logo.gif" alt="Создание сайта Studio oneTOUCH">
        </div>
   	</div>
    </body>
</html>