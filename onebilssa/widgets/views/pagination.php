<?if($pagination['pages']!=FALSE):?>
	<ul class="pagination">
		<?if($_GET['p']!='' && $_GET['p']!=1):?>
			<?/*?><a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?><?=Funcs::getFG('p')?>" class="font_12">Первая</a></li><?*/?>
			<?if($_GET['p']-1!=1):?>
				<li class="pagination_item"><a href="?p=<?=$_GET['p']-1?><?=Funcs::getFG('p','&')?>" class="pagination_link" title="Предыдущая страница">&lt;</a></li>
			<?else:?>
				<li class="pagination_item"><a href="<?=Funcs::getFG('p','?')?>" class="pagination_link" title="Предыдущая страница">&lt;</a></li>
			<?endif?>
		<?else:?>
			<?/*?>
			<a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?><?=Funcs::getFG('p')?>" class="font_12">Первая</a></li>
			<a href="<?=Funcs::getFG('p','?')?>" class="icon left_arrows" title="Предыдущая"></a>
			<?*/?>
		<?endif?>
		<?foreach($pagination['pages'] as $item):?>
			<?if($_GET['p']=='' && $item==1):?>
				<li class="pagination_item"><span class="pagination_link active">1</span></li>
			<?elseif($_GET['p']==$item):?>
				<li class="pagination_item"><span class="pagination_link active"><?=$item?></span></li>
			<?elseif($item=='-'):?>
				<li class="pagination_item"><span class="pagination_link">.&nbsp;.&nbsp;.</span></li>
			<?else:?>
				<?if($item!=1):?>
					<li class="pagination_item"><a class="pagination_link" href="?p=<?=$item?><?=Funcs::getFG('p','&')?>"><?=$item?></a></li>
				<?else:?>
					<li class="pagination_item"><a class="pagination_link" href="<?=Funcs::getFG('p','?')?>"><?=$item?></a></li>
				<?endif?>
			<?endif?>
		<?endforeach?>
		<?if($_GET['p']==''):?>
			<li class="pagination_item"><a href="?p=2<?=Funcs::getFG('p','&')?>" title="Следующая страница" class="pagination_link">&gt;</a></li>
			<?/*?><a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?>?p=<?=$pagination['pages'][count($pagination['pages'])-1]?><?if($_GET['module']!=''):?>&module=<?=$_GET['module']?><?endif?>" class="font_12">Последняя</a><?*/?>
		<?elseif($_GET['p']!=$pagination['pages'][count($pagination['pages'])-1]):?>
			<li class="pagination_item"><a href="?p=<?=$_GET['p']+1?><?=Funcs::getFG('p','&')?>" title="Следующая страница" class="pagination_link">&gt;</a></li>
			<?/*?><a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?>?p=<?=$pagination['pages'][count($pagination['pages'])-1]?><?if($_GET['module']!=''):?>&module=<?=$_GET['module']?><?endif?>" class="font_12">Последняя</a><?*/?>
		<?else:?>
			<?/*?>
			<a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?>?p=<?=$pagination['pages'][count($pagination['pages'])-1]?>&<?=Funcs::getFG('p')?>" class="icon right_arrows" title="Следующая"></a>
			<a href="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?>?p=<?=$pagination['pages'][count($pagination['pages'])-1]?><?if($_GET['module']!=''):?>&module=<?=$_GET['module']?><?endif?>" class="font_12">Последняя</a>
			<?*/?>
		<?endif?>
	</ul>
<?endif?>
<div class="displayed-quantity">
	<form method="post" action="/<?=Funcs::$cdir?>/tree/perpage/" id="selectPerPageForm">
		Выводить по:
		<select class="jsSelectStyled" onchange="$('#selectPerPageForm').submit()" name="new_kol">
			<option value="10" <?if($_SESSION['user']['perpage']==10):?>selected<?endif?>>10</option>
			<option value="25" <?if($_SESSION['user']['perpage']==25):?>selected<?endif?>>25</option>
			<option value="50" <?if($_SESSION['user']['perpage']==50):?>selected<?endif?>>50</option>
			<option value="100" <?if($_SESSION['user']['perpage']==100):?>selected<?endif?>>100</option>
			<option value="5000000" <?if($_SESSION['user']['perpage']==5000000):?>selected<?endif?>>Все</option>
		</select>
	</form>
</div>