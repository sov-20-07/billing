<!DOCTYPE html>
<!--[if IE 7]><html lang="ru" class="ie7"><![endif]-->
<html lang="ru">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <title><?=Funcs::$seo_title?></title>
    
	<link href="/<?=Funcs::$cdir?>/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/<?=Funcs::$cdir?>/css/cusel.css" rel="stylesheet" type="text/css">
    <link href="/<?=Funcs::$cdir?>/css/highslide.css" rel="stylesheet" type="text/css">
    <link href="/<?=Funcs::$cdir?>/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" type="text/css">
    <link href="/<?=Funcs::$cdir?>/css/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css">
	<link href="/<?=Funcs::$cdir?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="/<?=Funcs::$cdir?>/css/jquery.jscrollpane.css" rel="stylesheet" type="text/css">
	<?foreach(View::getIncludeFiles('css') as $item):?>
		<link href="<?=$item?>" rel="stylesheet" type="text/css">
	<?endforeach?>
	<!--[if lt IE 9]>
	<script src="/<?=Funcs::$cdir?>/js/html5.js"></script>
	<![endif]-->
	
	<!-- СКРИПТЫ -->
	<script type="text/javascript">
		var onessapath="/<?=ONESSA_DIR?>/";
	</script>
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
	<script src="/<?=Funcs::$cdir?>/js/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="/<?=Funcs::$cdir?>/js/jquery-ui-timepicker-addon.js"></script>
	<script src="/<?=Funcs::$cdir?>/js/jquery.dragsort-0.5.1.js"></script>
	<script src="/<?=Funcs::$cdir?>/js/highslide-full.js"></script>
	<script src="/<?=Funcs::$cdir?>/js/galsettings.js"></script>
	<script src="/<?=Funcs::$cdir?>/js/jquery.tablednd_0_5.js"></script>
	<script src="/<?=Funcs::$cdir?>/ckeditor/ckfinder/ckfinder.js"></script>
	<script src="/<?=Funcs::$cdir?>/ckeditor/ckeditor.js"></script>
	<script src="/<?=Funcs::$cdir?>/ckeditor/adapters/jquery.js"></script>
	<script src="/<?=Funcs::$cdir?>/js/common.js"></script>
	<script src="/<?=Funcs::$cdir?>/js/application.js"></script>
	<?foreach(View::getIncludeFiles('js') as $item):?>
		<script src="<?=$item?>"></script>
	<?endforeach?>
	<!-- /СКРИПТЫ -->
</head>
<body>
	<aside class="ltSidebar jsSidebar">
		<div class="sidebar_content ltContainer">
			<a href="/<?=Funcs::$cdir?>/" class="ltRow sidebar_logo"><img src="/<?=Funcs::$cdir?>/i/onessa_logo.png" alt="oneSSA"></a>
			<?=MenuWidget::ServiceMenu()?>
			<div class="ltRow">
				<div class="sidebar_user-block">
					<span class="sidebar_online">Вы и еще <?=count(Funcs::getOnlineUsers())?> online</span>
					<hr class="sidebar_separator">
					<span class="sidebar_user-block_name"><?=$_SESSION['user']['name']?></span>
					<span class="sidebar_user-block_role"><?=$_SESSION['user']['role']?></span>
					<a href="/<?=Funcs::$cdir?>/login/logout/" class="icon_exit" title="Выход"></a>
				</div>
			</div>
		</div>
	</aside>
	<section class="ltPage">
		<?if(in_array(Funcs::$uri[1],Funcs::$modMenu) || Funcs::$uri[1]==''):?>
			<div class="jsSeparator"></div>
		<?endif?>
		<div class="ltContainer ltFullWidth">
			<div class="ltRow">
				<div class="ltCell cell_header <?if(!in_array(Funcs::$uri[1],Funcs::$modMenu) && Funcs::$uri[1]!=''):?>cell_header_full<?endif?>">
					<div class="clearfix">
						<span class="jsSidebarToggle icon_showmenu" title="Показать/скрыть меню"></span>
						
						<? /* ?>
						<section class="sites_menu jsSitesMenu">
							<header class="sites_menu_current"><span class="sites_menu_link"><?=Funcs::$sites[$_SESSION['OneSSA']['site']]['name']?></span></header>
							<ul class="sites_menu_list jsSitesMenuList">
							<?foreach(Funcs::$sitesMenu as $item):?>
								<li class="sites_menu_item">
									<?if(count($item['sub'])>0):?>
										<span class="sites_menu_link"><?=$item['name']?></span>
										<ul class="sites_menu_list jsSitesMenuList">
										<?foreach($item['sub'] as $sub):?>
											<li class="sites_menu_item"><a class="sites_menu_link" href="/<?=Funcs::$cdir?>/?site=<?=$sub['id']?>"><?=$sub['name']?></a></li>
										<?endforeach?>
										</ul>
									<?else:?>
										<a class="sites_menu_link" href="/<?=Funcs::$cdir?>/?site=<?=$item['id']?>"><?=$item['name']?></a>
									<?endif?>
								</li>
							<?endforeach?>
							</ul>
						</section>
						<? */ ?>
						
						<section class="sites_menu jsSitesMenu">
							<header class="sites_menu_current jsSitesMenuCurrent"><span class="sites_menu_link"><?=Funcs::$sites[$_SESSION['OneSSA']['site']]['name']?></span></header>
							<div class="sites_menu_list jsSitesMenuList">
								<div class="jsScrollStatic">
									<ul class="jsSitesMenuPane">
									<?foreach(Funcs::$sitesMenu as $item):?>
										<li class="sites_menu_item <?if(count($item['sub'])>0):?>sections_table_row-header_catalog jsSitesMenuGroup<?endif?>">
											<?if(count($item['sub'])>0):?>
												<span class="sites_menu_link"><?=$item['name']?></span>
												<ul class="sites_menu_list2 jsSitesMenuGroupContents">
												<?foreach($item['sub'] as $sub):?>
													<li class="sites_menu_item2"><a class="sites_menu_link" href="/<?=Funcs::$cdir?>/?site=<?=$sub['id']?>"><?=$sub['name']?></a></li>
												<?endforeach?>
												</ul>
											<?else:?>
												<a class="sites_menu_link" href="/<?=Funcs::$cdir?>/?site=<?=$item['id']?>"><?=$item['name']?></a>
											<?endif?>
										</li>
									<?endforeach?>
									</ul>
								</div>
							</div>
						</section>
					</div>
				</div>
				<?if(in_array(Funcs::$uri[1],Funcs::$modMenu) || Funcs::$uri[1]==''):?>
					<?=CrumbsWidget::run()?>
				<?endif?>
			</div>
			<div class="ltRow ltFullHeight <?if(!in_array(Funcs::$uri[1],Funcs::$modMenu) && Funcs::$uri[1]!=''):?>cell_content_full<?endif?>">
				<?if(Funcs::$uri[1]!='work' && Funcs::$uri[1]!=''):?>
                	<?=MenuWidget::run()?>
                <?else:?>
					<?=TreeWidget::run()?>
				<?endif?>
				{content}
			</div>
		</div>
	</section>
	<section class="popup popup_section-settings jsSectionSettingsPopup">
		<ul>
			<li class="popup_section-settings_option" onclick="document.location.href='/<?=Funcs::$cdir?>/work/showedit/?id='+$(this).parent().parent().attr('ids')">Редактировать</li>
			<li class="popup_section-settings_option" onclick="clearCache($(this).parent().parent().attr('ids'))">Сбросить кэш</li>
			<li class="popup_section-settings_option" onclick="document.location.href='/<?=Funcs::$cdir?>/work/copy/?id='+$(this).parent().parent().attr('ids')">Копировать</li>
			<li class="popup_section-settings_option" onclick="if(confirm('Удалить объект?')){document.location.href='/<?=Funcs::$cdir?>/work/del/?id='+$(this).parent().parent().attr('ids');}" >Удалить</li>
		</ul>
	</section>
	<section class="popup popup_tooltip jsTooltipPopup">
		<div class="popup_tooltip_content jsTooltipContent"></div>
	</section>
	<section class="popup popup_preview popup_section-settings popup_alwaysleft jsPreviewPopup">
	</section>
</body>
</html>