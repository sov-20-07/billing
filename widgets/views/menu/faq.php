<div class="faq_menu"><div class="menu_padds">
	<ul>
	<?foreach($list as $key=>$items):?>
		<li <?if($items['selected']):?>class="act"<?endif?>>
			<span class="pseudo sliding" id="item<?=$key?>"><?=$items['name']?></span>
			<?if(count($items['sub']>0)):?>
				<div class="submenu sliding_item<?=$key?>">
					<ul>
					<?foreach($items['sub'] as $item):?>
						<?if($item['selected']):?>
							<li class="act"><?=$item['name']?></li>
						<?else:?>
							<li><a href="<?=$item['path']?>"><?=$item['name']?></a></li>
						<?endif?>
					<?endforeach?>
					</ul>
				</div>
			<?endif?>
		</li>
	<?endforeach?>
	</ul>
</div></div>