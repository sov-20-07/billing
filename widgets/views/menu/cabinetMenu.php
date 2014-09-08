<div class="left-menu">
	<ul>
	<?foreach($list as $path=>$item):?>
		<?if(Funcs::$uri[1]===$path || (Funcs::$uri[1]=='' && is_numeric($path))):?>
			<li><a class="active" href="/<?=$prefix?>/<?if($path!='0'):?><?=$path?>/<?endif?>"><?=$item?></a></li>
		<?else:?>
			<li><a href="/<?=$prefix?>/<?if($path!='0'):?><?=$path?>/<?endif?>"><?=$item?></a></li>
		<?endif?>
	<?endforeach?>
	</ul>
</div>