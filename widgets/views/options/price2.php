<?if(is_array($list)):?>
	<?foreach($list as $item):?>
		<a href="<?=$item['href']?>"><?=$item['name']?> <span class="rub">a</span></a><br/>
	<?endforeach?>
	<br/>
<?endif?>