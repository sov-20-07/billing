<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=Funcs::$seo_title?></title>
    <meta name="description" content="<?=Funcs::$seo_description?>" />
	<meta name="keywords" content="<?=Funcs::$seo_keywords?>" /> 
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <link href="/css/main.css" rel="stylesheet" type="text/css">
    <link href="/css/cloud-zoom.css" rel="stylesheet" type="text/css">
    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/css/ie7.css"><![endif]--> 
    <script src="/js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="/js/oneCarousel.js" type="text/javascript"></script>
    <script src="/js/oneCarousel2.js" type="text/javascript"></script>
    <script src="/js/cloud-zoom.1.0.2.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>
     <script src="/js/basket.js" type="text/javascript"></script>
    <script src="/js/application.js" type="text/javascript"></script>
</head>
<body id="btop">
    <div id="wrapper" class="fixed_width" style="box-shadow: none;">
    <!-- шапка -->
    	<div id="header">
        	<!-- блок: валюта, поиск -->
        	<div class="top_pattern"><div class="fixed_width">      
        			
				<a href="/" class="logo"><img src="/i/logo.png" />интернет-магазин сантехники</a>
				<!-- телефон -->
				<div class="call_block print_v">
					<div class="phone"><span><?=substr(Funcs::$conf['settings']['phone'],0,8)?></span><?=substr(Funcs::$conf['settings']['phone'],9,9)?></div>
					работаем круглосуточно
				</div>
				<!-- /телефон -->
			<!-- /блок: лого, телефон, корзина -->
            </div></div>
        	<!-- /блок: валюта, поиск -->
        </div>
    	<!-- /шапка -->
		<div id="content"><div class="common_padds"><div class="inline_block">
			<div id="right_part" class="without_left"><div class="right_padds">
				<div class="good_card inline_block">
					<div class="good_img print_v">
						<?if(count($fields['files_gal'])>0):?>
							<?foreach($fields['files_gal'] as $i=>$item):?>
								<img src="/of/2<?=$item['path']?>" alt="<?=$item['name']?>"/><br />
							<?endforeach?>
						<?endif?>
					</div>
					<div class="good_description print_v"><div id="zoom_display">
						<h1><?=$name?></h1>
						<?if($fields['art']):?><div class="article">Артикул № <?=$fields['art']?></div><?endif?>
						<div class="review_links">
							<div class="stars s<?=$fields['rating']?>"><div class="inline_block setstars" ids="<?=$id?>"><span ids="1"></span><span ids="2"></span><span ids="3"></span><span ids="4"></span><span ids="5"></span></div></div>
						</div><br />
						<?if($fields['available']==1):?>
							<div class="in_stock">Есть на складе</div>
						<?else:?>
							<div class="in_stock">Нет на складе</div>
						<?endif?>
						<?=$fields['description']?>
						<div class="blocks3 inline_block">
							<div class="price_block float_block">
								<div class="price"><?=number_format($fields['price'],0,'',' ')?> руб.</div>
							</div>
							<div class="help_block float_block print_v">
								<span class="icon ic_question auto_icon"><?=Funcs::$conf['settings']['phone']?></span>
								<div class="call_note">Звоните! Наши менеджеры готовы ответить на все ваши вопросы</div>
							</div>
						</div>
						<div class="notes inline_block">
							<div class="float_block">
								<span class="icon ic_box auto_icon"><span>Доставка ежедневно, в удобное для вас время, которое оговаривается заранее.</span></span>
							</div>
							<div class="float_block">
								<span class="icon ic_note auto_icon"><span>На каждое изделие предоставляются все необходимые документы</span></span>
							</div>
						</div>
						<br />
						<?if(count($dops)>0):?>
						<div class="in_stock print_v">Дополнительные опции</div>
						<div class="bookmarks_block print_v"><div class="bookmark_content block1 block_bkm1 act">
							<table class="default">
								<col width="95"><col><col width="110">
								<?foreach($dops as $item):?>
									<tr>
										<td class="mini_img"><img src="/of/1<?=$item['files_gal'][0]['path']?>" class="img86x66" /></td>
										<td>
											<div class="mini_good_name"><b class="font_14"><?=$item['name']?></b></div>
											<?=$item['description']?>
										</td>
										<td><b class="font_14"><?=number_format($item['price'],0,'',' ')?> руб.</b></td>
									</tr>
								<?endforeach?>
							</table>
						</div></div>
						<?endif?>
						<?if(trim(strip_tags($fields['tech']))!=''):?>
							<div class="in_stock print_v">Технические харакетристики</div>
							<?=$fields['tech']?>
							<br />
						<?endif?>
						<?if(trim(strip_tags($fields['fulltext']))!=''):?>
							<div class="in_stock print_v">Подробное описание</div>
							<?=$fields['fulltext']?>
						<?endif?>
						</div></div>
				</div>
			</div></div>
		</div></div></div>
		<div id="spacer"></div>
    </div>
    <!-- /"обёртка" -->
    <!-- подвал -->
    <div id="footer" class="fixed_width">
        <div class="copy">&copy;&nbsp;2012 Интернет-магазин AQUAVIL.RU</div>
        <div class="studio-developer">
			<a href="http://www.one-touch.ru/" title="Создание сайта Studio oneTOUCH">Создание сайта</a><br clear="all"><a href="http://www.one-touch.ru/" title="Создание сайта Studio oneTOUCH" class="link_logo"><img src="/i/onetouch_logo.gif" alt="Создание сайта Studio oneTOUCH"></a>
        </div>
    </div>
   	<!-- /подвал -->
   	<script>
		$(document).ready(function(){
			window.print();
		});
	</script>
</body>
</html>