<div class="ltRow jsScrollContainer">
	<div class="jsScrollWrapper">
		<div class="jsScroll darkOverflow">
			<ul class="sidebar_menu">
				<?foreach($list as $path=>$item):?>
					<?if($item==''):?>
						<li class="sidebar_menu_item">&nbsp;</li>
					<?elseif($path=='work'):?>
						<li class="sidebar_menu_item"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$siteDB?>/"><?=$item?></a></li>
					<?else:?>
						<li class="sidebar_menu_item"><a href="/<?=Funcs::$cdir?>/<?=$path?>/"><?=$item?></a></li>
					<?endif?>
				<?endforeach?>
				<li class="sidebar_menu_item">&nbsp;</li>
				<li class="sidebar_menu_item"><a href="http://www.one-touch.ru/onessa_help/">Помощь</a></li>
				<li class="sidebar_menu_item"><a href="mailto:support@one-touch.ru">Техподдержка</a></li>
			</ul>
		</div>
	</div>
</div>