<?if(count($list)>0):?>
	<ul>
	<?foreach($list as $key=>$item):?>
		<?if($item['selected']):?>
	 		<li>
	 			<b><?=$item['name']?></b>
	 			<?View::widget('menu/leftbranch',$item)?>
	 		</li>
	 	<?else:?>
			<li><a href="<?=$item['path']?>"><?=$item['name']?></a></li>
		<?endif?>
	<?endforeach?>
	</ul> 
<?endif?>