<div class="ltCell cell_breadcrumbs">
	<?if(count($list)>0):?>
		<ul class="breadcrumbs">
		<?foreach($list as $i=>$item):?>
			<?if($i!=count($list)-1):?>
				<li class="breadcrumbs_item"><a href="<?=$item['path']?>"><?=$item['name']?></a></li>
			<?endif?>
		<?endforeach?>
		</ul>
	<?endif?>
</div>
