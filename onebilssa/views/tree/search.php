<ol class="tree_search_res">
<?foreach($tree as $item):?>
	<li><a href="/<?=Funcs::$cdir?>/work/<?=$item['tree']?>/"><?=$item['name']?></a></li>
<?endforeach?>
</ol>
