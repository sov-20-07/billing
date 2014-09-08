<div class="breadcrumbs">
	<a href="/" class="home"></a>
	<?foreach($list as $i=>$item):?>
		<?if($item['name']=='Каталог'):?>
			<span class="catalog">&gt;</span><span class="catalog"><?=$item['name']?></span>
		<?else:?>
			<?if($i!=count($list)-1):?>
				<span>&gt;</span><a href="<?=$item['path']?>"><?=$item['name']?></a>
			<?else:?>
				<span>&gt;</span><span><?=$item['name']?></span>
			<?endif?>
		<?endif?>
	<?endforeach?>
</div>
<?/* ?>
<div id="navigation">
	<span class="pseudo is_gray all_site_link">Весь сайт</span>
	<?foreach($list as $i=>$item):?>
		<?if($i!=count($list)-1):?>
			<span class="right_arrow"></span><a href="<?=$item['path']?>" class="is_gray"><?=$item['name']?></a>
		<?else:?>
			<span class="right_arrow"></span><?=$item['name']?>
		<?endif?>
	<?endforeach?>
	<div class="all_site_pos"><div class="all_site"><div class="border_block">
		<div class="top_block2">
			<span class="icon ic_close_block auto_icon all_site_link"><span class="pseudo is_white">Закрыть</span></span>
			<b class="pseudo is_white all_site_link">Весь сайт</b> <a href="/" class="s_shift">Главная страница</a>
		</div>
		<div class="links_block">
			<table class="default">
				<col width="25%"><col width="25%"><col width="25%"><col width="25%">
				<tr>
				<?foreach($allsite as $i=>$item):?>
					<td>
						<ul>
						<?if($item['selected']):?>
							<li class="head act" class="univers_bold"><?=$item['name']?></li>
						<?else:?>
							<li class="head"><a href="<?=$item['path']?>" class="univers_bold"><?=$item['name']?></a></li>
						<?endif?>
						<?foreach($item['sub'] as $sub):?>
							<?if($sub['selected']):?>
								<li class="act"><?=$sub['name']?></li>
							<?else:?>
								<li><a href="<?=$sub['path']?>"><?=$sub['name']?></a></li>
							<?endif?>
						<?endforeach?>
						</ul>
					</td>
				<?endforeach?>
				</tr>
			</table>
		</div>
	</div></div></div>
</div>
<?*/?>