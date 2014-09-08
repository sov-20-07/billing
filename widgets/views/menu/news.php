<div class="left_menu">
	<ul>
	<?foreach($list as $key=>$item):?>
		<?if($item['selected'] || $item['inner']):?>
			<li>
				<?if(Funcs::$uri[2]!='' || isset($_GET['d'])):?>
					<a href="<?=$item['path']?>" class="inner"><?=$item['name']?></a>
				<?else:?>
					<b><?=$item['name']?></b>
				<?endif?>
				<ul>
				<?foreach($item['years'] as $year=>$item2):?>
					<li>
						<span class="pseudo is_dark sliding" id="sm<?=$year?>"><?=$year?></span>
						<ul class="sliding_sm<?=$year?> <?if($year==$date[0]):?>act<?endif?>">
							<?foreach($item2 as $month=>$item3):?>
								<?if($month==$date[1]):?>
									<li><?=$item3?></li>
								<?else:?>
									<li><a href="/<?=Funcs::$uri[0]?>/<?=Funcs::$uri[1]?>/?d=<?=$year?>-<?=$month?>"><?=$item3?></a></li>
								<?endif?>
							<?endforeach?>
						</ul>
					</li>
				<?endforeach?>
				</ul>
			</li>
		<?else:?>
			<li><a href="<?=$item['path']?>"><?=$item['name']?></a></li>
		<?endif?>
	<?endforeach?>
	</ul>
</div>
<?/*?><a href="/rss/" class="icon ic_rss auto_icon is_gray">RSS-подписка</a><?*/?>