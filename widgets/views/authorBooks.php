<?if(count($list)>0):?>
	<div class="head_designer">
		<span>Другие книги автора</span>
		<div class="right grey">Все книги (<?=count($list)?>)</div>
	</div>
	<div id="user_books">
		<?if(count($list)>3):?>
			<span class="ic_nav prev"></span>
			<span class="ic_nav next"></span>
			<div class="lenta">
				<ul>
				<?foreach($list as $item):?>
					<li>
						<div class="hover_book">
							<a href="<?=$item['path']?>">
								<div class="u-turn <?if($item['square']==1):?>dim30x30<?else:?>dim25x20<?endif?> center">
									<div class="u-turn_shadow"></div>
									<div class="left_page" style="background: url('/of/<?if($item['square']==1):?>3<?else:?>4<?endif?><?=$item['files_gal'][3]['path']?>') no-repeat center;"></div>
									<div class="right_page" style="background: url('/of/<?if($item['square']==1):?>3<?else:?>4<?endif?><?=$item['files_gal'][4]['path']?>') no-repeat center;"></div>
								</div>
							</a>
							<a href="<?=$item['path']?>" class="font_11 up"><?=$item['name']?></a><br />
							от: <?=$item['author']?>
						</div>
					</li>
				<?endforeach?>
				</ul>
			</div>
		<?else:?>
			<div class="simplebooklenta">
				<ul>
				<?foreach($list as $item):?>
					<li style="float:left">
						<div class="hover_book">
							<a href="<?=$item['path']?>">
								<div class="u-turn <?if($item['square']==1):?>dim30x30<?else:?>dim25x20<?endif?> center">
									<div class="u-turn_shadow"></div>
									<div class="left_page" style="background: url('/of/<?if($item['square']==1):?>3<?else:?>4<?endif?><?=$item['files_gal'][3]['path']?>') no-repeat center;"></div>
									<div class="right_page" style="background: url('/of/<?if($item['square']==1):?>3<?else:?>4<?endif?><?=$item['files_gal'][4]['path']?>') no-repeat center;"></div>
								</div>
							</a>
							<a href="<?=$item['path']?>" class="font_11 up"><?=$item['name']?></a><br />
							от: <?=$item['author']?>
						</div>
					</li>
				<?endforeach?>
				</ul>
				<br clear="all" />
			</div>
		<?endif?>
	</div>
<?endif?>