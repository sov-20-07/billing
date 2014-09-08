<div class="top_menu">
	<ul>
	<?foreach($list as $i=>$item):?>
		<li>
			<span>
				<a href="<?=$item['path']?>"><?=$item['name']?></a>
				<?if(count($item['list'])>0):?>
					<ul>
					<?foreach($item['list'] as $item2):?>
						<li><a href="<?=$item2['path']?>"><?=$item2['name']?></a></li>
					<?endforeach?>
					</ul>
				<?endif?>
			</span>
		</li>
	<?endforeach?>
	</ul>
	<a href="#"></a>
</div>