<?if(count($list)>0):?>
	<div class="additional_services">
		<div class="title">Дополнительные услуги</div>
		<?foreach($list as $i=>$items):?>
			<ul <?if($i==0):?>style="margin:0 6% 0 1%; padding-left:2px;"<?elseif($i==count($list)-1):?>style="margin:0;"<?endif?>>
			<?foreach($items as $item):?>
				<li><a href="<?=$item['path']?>"><?=$item['name']?><span class="diamond"></span></a></li>
			<?endforeach?>
			</ul>
		<?endforeach?>
	</div>  
<?endif?>