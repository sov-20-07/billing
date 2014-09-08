<?if(count($viewed)>0):?>
	<h3>Просмотренные</h3>
	<?//foreach($viewed as $items):?>
		<?foreach($viewed[1] as $item):?>
			<?=View::getRenderEmpty('catalog/listmodelsmall',$item)?>
		<?endforeach?>
	<?//endforeach?>
<?endif?>