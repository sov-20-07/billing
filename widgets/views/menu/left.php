<?if(count($list)>0):?>
<div class="left-content">
	<div class="left-menu">
		<ul>
		<?foreach($list as $key=>$item):?>
			<?if($item['selected']):?>
				<li>
					<a class="active" href="<?=$item['path']?>"><?=$item['name']?></a>
					<?View::widget('menu/leftbranch',$item)?>
				</li>
			<?else:?>
				<li><a href="<?=$item['path']?>"><?=$item['name']?></a></li>
			<?endif?>
		<?endforeach?>
		</ul>
	</div>
</div>
<?endif?>