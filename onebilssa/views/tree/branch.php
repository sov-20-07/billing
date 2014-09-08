<ul class="catalog-menu">
<?foreach($sub as $item):?>
	<li class="catalog-menu_item jsMenuItem <?if(count($item['sub'])>0):?>jsOpened<?else:?>jsClosed<?endif?> <?if($item['selected']):?>active<?endif?>">
		<a class="catalog-menu_link" href="/<?=Funcs::$cdir?>/work/<?=$item['id']?>/">
			<?=$item['name']?>
			<?if(count($item['sub'])>0):?><span class="catalog-menu_toggle" onclick="treemenuClick(<?=$item['id']?>)" id="tmc<?=$item['id']?>"></span><?endif?>
		</a>												
		<?if(count($item['sub'])>0):?>
			<?View::render('tree/branch',$item)?>
		<?endif?>
	</li>
<?endforeach?>
</ul>
<?/*?>
			<ul>
<?foreach($sub as $item):?>
	<li>
		<div id="tmc<?=$item['id']?>" <?if($item['selected'] && count($item['sub'])>0):?>class="menuminus" onclick="treemenuClick(<?=$item['id']?>)"<?elseif($item['inner']):?>class="menuplus" onclick="treemenuClick(<?=$item['id']?>)"<?else:?>class="menudot"<?endif?>></div>
		<a href="/<?=Funcs::$cdir?>/<?=$item['id']?>" <?if($item['selected']):?>class="selected"<?endif?>><?=$item['name']?></a>
		<div class="holder<?=$item['id']?>"></div>
		<?if(count($item['sub'])>0):?>
			<?View::render('tree/branch',$item)?>
		<?endif?>
	</li>
<?endforeach?>
</ul>
<?*/?>
			