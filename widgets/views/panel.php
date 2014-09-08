<div class="recent">
	<a href="/favorite/" class="link"><span>Отложенные (<span id="favorite"><?if($_COOKIE['favorite']!=''):?><?=count(explode(',',$_COOKIE['favorite']))?><?else:?>0<?endif?></span>)</span></a>
	<span class="viewed in-block dotted">Просмотренные</span>
	<div class="recent-pop-up">
		<div class="head">
			<div class="close to-click"></div>
		</div>
		<div class="recent-block">
			<div id="recent">
				<h2>Просмотренные товары</h2>
				<?if(count($viewed)>0):?>
					<?if(count($viewed)>4):?>
						<span class="ic_nav prev to-click"></span>
						<span class="ic_nav next to-click"></span>
					<?endif?>
					<div class="lenta">
						<ul>
						<?foreach($viewed as $item):?>
							<li>
								<a href="<?=$item['path']?>" class="pic" style="background-image: url('/of/2<?=$item['pics'][0]['path']?>')"></a>
								<a href="<?=$item['path']?>"><?=$item['name']?></a><br/>
								<span class="price rub14"><?=number_format($item['price'],0,'',' ')?></span>
	
							</li>
						<?endforeach?>
						</ul>
					</div>
				<?endif?>
			</div>
		</div>
	</div>
</div>
<?/* ?>
<div id="panel"><div class="fixed_width"><div class="panel_block"><div class="padds">
	<div class="top_line"></div>
	<div class="toggler"><span></span></div>
	<ul class="switcher">
		<li class="case n1 act">недавно просмотренные</li>
		<li class="case n2">избранное</li>
	</ul>
	<div class="carousel_nav"><div class="nav_pos"><span class="is_left"></span><span class="is_right"></span></div></div>
	<div class="carousel">
		<div class="lenta_pos"><div class="lenta">
			<div class="catalog_pos lenta1"><div class="table_shifts"><table class="default">
				<tr>
				<?foreach($viewed as $item):?>
					<td>
						<div class="t_block">
							<a href="<?=$item['path']?>" title="<?=$item['name']?>">
								<div class="pseudo_td"><img src="/of/3<?=$item['files_gal'][0]['path']?>" alt="<?=$item['files_gal'][0]['name']?>" /></div>
								<div style="overflow: hidden;width:190px;height:42px">
									<?=$item['name']?>
								</div>
							</a>
							<div class="price"><span class="rur18_bold"><?=number_format($item['price'],0,',',' ')?></span></div>
						</div>
					</td>
				<?endforeach?>
				</tr>
			</table></div></div>
			<div class="catalog_pos lenta2"><div class="table_shifts"><table class="default">
				<tr>
				<?foreach($favorite as $item):?>
					<td>
						<div class="t_block">
							<a href="<?=$item['path']?>" title="<?=$item['name']?>">
								<div class="pseudo_td"><img src="/of/3<?=$item['files_gal'][0]['path']?>" alt="<?=$item['files_gal'][0]['name']?>" /></div>
								<div style="overflow: hidden;width:190px;height:42px">
									<?=$item['name']?>
								</div>
							</a>
							<div class="price"><span class="rur18_bold"><?=number_format($item['price'],0,',',' ')?></span></div>
							<a href="javascript:;" ids="<?=$item['tree']?>" class="delete_from del_from_favorite" onclick="$(this).parent().parent().detach()"><span class="pseudo is_dark">Удалить из избранного</span></a>
						</div>
					</td>
				<?endforeach?>
				</tr>
			</table></div></div>
		</div></div>
	</div>
</div></div></div></div>
<?*/?>

<?/* ?>
<?if(count($list)>0 && $_SESSION['showpanel']==0):?>
<script>
	var clockkkk=setTimeout("openPanel()", 1500);
	function openPanel(){
		$("#panel .fixed_width .panel_block").animate({top: "-5px"}, 400, "linear");
		$(".on_off .icon_panel").parent().animate({top: 409}, 400, "linear", function(){
			setTimeout( function(){
				$("#panel .fixed_width .panel_block").animate({top: "-404px"}, 250, "linear");
				$(".on_off .icon_panel").parent().animate({top: 0}, 250, "linear");
			}, 1500 );
		});
	}
</script>
<?endif?>
<div id="panel"><div class="fixed_width">
	<div class="panel_block">
		<?if($_SESSION['iuser']):?>
			<div class="cabinet_block"><div class="padds">
				Ваш кабинет:
				<ul>
					<li><a href="/cabinet/">Персональные данные</a></li>
					<li><a href="/cabinet/delivery/">Параметры доставки</a></li>
					<li><a href="/cabinet/history/">История заказов</a></li>
					<li><a href="/cabinet/notification/">Уведомления и рассылка</a></li>
				</ul>
			</div></div>
		<?endif?>
		<div class="head">Недавно просмотренные товары</div>
		<div class="lenta_padds">
			<div class="panel_grad"></div>
			<div class="lenta"><table class="default catalog">
				<tr>
				<?foreach($list as $item):?>
					<td>
						<div class="border_pos">
							<div class="good_block">
								<a href="<?=$item['path']?>">
									<div class="good_img">
										<div class="img_default"><img src="/of/2<?=$item['files_gal'][0]['path']?>" alt="<?=$item['files_gal'][0]['name']?>" /></div>
										<?if($item['files_gal'][1]['path']):?>		
											<div class="img_over"><img src="/of/2<?=$item['files_gal'][1]['path']?>" alt="<?=$item['files_gal'][1]['name']?>" /></div>
										<?else:?>
											<div class="img_over"><img src="/of/2<?=$item['files_gal'][0]['path']?>" alt="<?=$item['files_gal'][0]['name']?>" /></div>
										<?endif?>
									</div>
									<div class="half_hidden"><ins><?=$item['name']?></ins><div class="grad"></div></div>
								</a>
							</div>
						</div>
					</td>
				<?endforeach?>
				</tr>
			</table></div>
		</div>
	</div>
	<div class="on_off"><span class="icon icon_panel"></span></div>
</div></div>
<?*/?>