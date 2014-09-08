<?foreach($list as $items):?>
<div class="footer-block">
	<h6><?=$items['name']?></h6>
	<ul>
	<?foreach($items['list'] as $i=>$item):?>
		<?if(count($items['list'])>6 && $i==4):?></ul><ul><?endif?>
		<li><a href="<?=$item['path']?>"><?=$item['name']?></a></li>
	<?endforeach?>
	</ul>
</div>
<?endforeach?>