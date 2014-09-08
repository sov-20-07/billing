<?if($pagination['pages']!=FALSE):?>
	<div class="pages">
		<?if($_GET['p']!='' && $_GET['p']!=1):?>
			<?/*?><a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?><?=Funcs::getFG('p')?>" class="font_12">Первая</a></li><?*/?>
			<?if($_GET['p']-1!=1):?>
				<a href="?p=<?=$_GET['p']-1?><?=Funcs::getFG('p','&')?>" class="pr-but" title="Предыдущая страница"></a>
			<?else:?>
				<a href="<?=Funcs::getFG('p','?')?>" class="pr-but" title="Предыдущая страница"></a>
			<?endif?>
		<?else:?>
			<?/*?>
			<a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?><?=Funcs::getFG('p')?>" class="font_12">Первая</a></li>
			<a href="<?=Funcs::getFG('p','?')?>" class="icon left_arrows" title="Предыдущая"></a>
			<?*/?>
		<?endif?>
		<?foreach($pagination['pages'] as $item):?>
			<?if($_GET['p']=='' && $item==1):?>
				<span>1</span>
			<?elseif($_GET['p']==$item):?>
				<span><?=$item?></span>
			<?elseif($item=='-'):?>
				<span>&hellip;</span>
			<?else:?>
				<?if($item!=1):?>
					<a href="?p=<?=$item?><?=Funcs::getFG('p','&')?>"><?=$item?></a>
				<?else:?>
					<a href="<?=Funcs::getFG('p','?')?>"><?=$item?></a>
				<?endif?>
			<?endif?>
		<?endforeach?>
		<?if($_GET['p']==''):?>
			<a href="?p=2<?=Funcs::getFG('p','&')?>" class="next-but" title="Следующая страница"></a>
			<?/*?><a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?>?p=<?=$pagination['pages'][count($pagination['pages'])-1]?><?if($_GET['module']!=''):?>&module=<?=$_GET['module']?><?endif?>" class="font_12">Последняя</a><?*/?>
		<?elseif($_GET['p']!=$pagination['pages'][count($pagination['pages'])-1]):?>
			<a href="?p=<?=$_GET['p']+1?><?=Funcs::getFG('p','&')?>" class="next-but" title="Следующая страница"></a>
			<?/*?><a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?>?p=<?=$pagination['pages'][count($pagination['pages'])-1]?><?if($_GET['module']!=''):?>&module=<?=$_GET['module']?><?endif?>" class="font_12">Последняя</a><?*/?>
		<?else:?>
			<?/*?>
			<a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?>?p=<?=$pagination['pages'][count($pagination['pages'])-1]?>&<?=Funcs::getFG('p')?>" class="icon right_arrows" title="Следующая"></a>
			<a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?>?p=<?=$pagination['pages'][count($pagination['pages'])-1]?><?if($_GET['module']!=''):?>&module=<?=$_GET['module']?><?endif?>" class="font_12">Последняя</a>
			<?*/?>
		<?endif?>
	</div>
<?endif?>