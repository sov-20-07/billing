<a href="/<?=Funcs::$cdir?>/work/bind/?module=<?=$_POST['id']?>&tree=<?=$_POST['tree']?>">Привязать модуль</a> |
<a href="/<?=Funcs::$cdir?>/work/showadd/?module=<?=$_POST['id']?>&tree=<?=$_POST['tree']?>">Создать элемент</a>
<?foreach(Module::getList() as $item):?>
	<?=$item['name']?><br />
<?endforeach?>