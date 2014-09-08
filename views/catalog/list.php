<a name="up"></a>
<div id="content">
	<?CrumbsWidget::run()?>
	<div class="filter">
		<div class="left-coll">
			<?/*if((Funcs::$uri[0]=='catalog')&&(Funcs::$uri[1]=='videoregistratory')&&(count(Funcs::$uri)==2)){?>
			<div class="filter-box" style="padding: 0;" onclick="_gaq.push(['_trackEvent', 'Banner', 'Click'])"><a href="http://dvr-group.ru/catalog/videoregistratory/AvtoVision/319/">
			<script src="/js/jquery.easing.1.3.js"></script>
		<script src="/js/jquery.transform-0.8.0.min.js"></script>
		<script src="/js/jquery.banner.js"></script>
		
		<div id="ca_banner1" class="ca_banner ca_banner1">
			<div class="ca_slide ca_bg1">
				<div class="ca_zone ca_zone1">
					<div class="ca_wrap ca_wrap1">
						<img style="position: absolute; top: 0px; right: 0px; z-index: 1;" src="/i/banner/s1pic1.png" class="ca_shown" alt="">
						<img style="position: absolute; top: 53px; left: 21px; z-index: 1; display:none;" src="/i/banner/s2pic1.png" alt="">
						<img style="position: absolute; top: 44px; right: 10px; z-index: 1; display:none;" src="/i/banner/s3pic1.png" alt="">
						<img style="position: absolute; top: 48px; right: 30px; z-index: 1; display:none;" src="/i/banner/s4pic1.png" alt="">
						<img style="position: absolute; top: 16px; right: 26px; z-index: 1; display:none;" src="/i/banner/s5pic1.png" alt="">
					</div>
				</div>
				<div class="ca_zone ca_zone2">
					<div class="ca_wrap ca_wrap2">
						<img style="position: absolute; top: 15px; left: 24px; z-index: 2;" src="/i/banner/s1pic2.png" class="ca_shown" alt="">
						<img style="position: absolute; top: -9px; left: 43px; z-index: 2; display:none;" src="/i/banner/s2pic2.png" alt="" style="display:none;">
						<img style="position: absolute; top: 19px; right: 35px; z-index: 2; display:none;" src="/i/banner/s3pic2.png" alt="">
						<img style="position: absolute; top: 77px; right: 13px; z-index: 2; display:none;" src="/i/banner/s4pic2.png" alt="">
						<img style="position: absolute; top: 60px; right: 0px; z-index: 2; display:none;" src="/i/banner/s5pic2.png" alt="">
					</div>
				</div>
				<div class="ca_zone ca_zone3">
					<div class="ca_wrap ca_wrap3">
						<img style="position: absolute; top: -58px; left: 22px; z-index: 3;" src="/i/banner/s1pic3.png" class="ca_shown" alt="">
						<img style="position: absolute; top: -31px; right: 30px; z-index: 3; display:none;" src="/i/banner/s2pic3.png" alt="">
						<img style="position: absolute; top: 21px; right: 42px; z-index: 3; display:none;" src="/i/banner/s5pic3.png" alt="">
					</div>
				</div>
			</div>
		</div>
		
		<script>
			$(document).ready( function(){
				$('#ca_banner1').banner({
					steps : [
						[
							//1 шаг:
							[{"to" : "1"}, {"effect": "slideOutTop-slideInTop"}],
							[{"to" : "1"}, {"effect": "slideOutRight-slideInRight"}],
							[{"to" : "1"}, {"effect": "slideOutLeft-slideInLeft"}]
						],
						[
							//1 шаг:
							[{"to" : "1"}, {}],
							[{"to" : "1"}, {}],
							[{"to" : "1"}, {}]
						],
						[
							//1 шаг:
							[{"to" : "1"}, {}],
							[{"to" : "1"}, {}],
							[{"to" : "1"}, {}]
						],
						[
							//1 шаг:
							[{"to" : "1"}, {}],
							[{"to" : "1"}, {}],
							[{"to" : "1"}, {}]
						],
						[
							//1 шаг:
							[{"to" : "1"}, {}],
							[{"to" : "1"}, {}],
							[{"to" : "1"}, {}]
						],
						[
							//2 шаг:
							[{"to" : "2"}, {"effect": "slideOutTop-slideInTop"}],
							[{"to" : "2"}, {"effect": "slideOutLeft-slideInLeft"}],
							[{"to" : "2"}, {"effect": "slideOutRight-slideInRight"}]
						],
						[
							//2 шаг:
							[{"to" : "2"}, {}],
							[{"to" : "2"}, {}],
							[{"to" : "2"}, {}]
						],
						[
							//2 шаг:
							[{"to" : "2"}, {}],
							[{"to" : "2"}, {}],
							[{"to" : "2"}, {}]
						],
						[
							//3 шаг:
							[{"to" : "3"}, {"effect": "slideOutRight-slideInRight"}],
							[{"to" : "3"}, {"effect": "slideOutLeft-slideInLeft"}],
							[{"to" : "0"}, {}]
						],
						[
							//3 шаг:
							[{"to" : "3"}, {}],
							[{"to" : "3"}, {}],
							[{"to" : "0"}, {}]
						],
						[
							//3 шаг:
							[{"to" : "3"}, {}],
							[{"to" : "3"}, {}],
							[{"to" : "0"}, {}]
						],
						[
							//4 шаг:
							[{"to" : "4"}, {"effect": "slideOutTop-slideInBottom"}],
							[{"to" : "4"}, {"effect": "slideOutBottom-slideInTop"}],
							[{"to" : "0"}, {}]
						],
						[
							//4 шаг:
							[{"to" : "4"}, {}],
							[{"to" : "4"}, {}],
							[{"to" : "0"}, {}]
						],
						[
							//4 шаг:
							[{"to" : "4"}, {}],
							[{"to" : "4"}, {}],
							[{"to" : "0"}, {}]
						],
						[
							//5 шаг:
							[{"to" : "5"}, {"effect": "slideOutTop-slideInTop"}],
							[{"to" : "5"}, {"effect": "slideOutRight-slideInRight"}],
							[{"to" : "3"}, {"effect": "slideOutLeft-slideInLeft"}]
						],
						[
							//5 шаг:
							[{"to" : "5"}, {}],
							[{"to" : "5"}, {}],
							[{"to" : "3"}, {}]
						],
						[
							//5 шаг:
							[{"to" : "5"}, {}],
							[{"to" : "5"}, {}],
							[{"to" : "3"}, {}]
						],
						[
							//5 шаг:
							[{"to" : "5"}, {}],
							[{"to" : "5"}, {}],
							[{"to" : "3"}, {}]
						],
						[
							//5 шаг:
							[{"to" : "5"}, {}],
							[{"to" : "5"}, {}],
							[{"to" : "3"}, {}]
						]
					],
					total_steps	: 19,
					speed : 1000
				});
            });
        </script>
		
		</a>
		</div>
			<?}else{*/?>
			<div class="filter-box">
				<?OptionsWidget::run($options)?>
			</div>
			<?/*}*/?>

			<?PanelWidget::vert()?>
		</div>
		<div class="right-coll">
			<h1><?=Funcs::$seo['name']['value']?Funcs::$seo['name']['value']:$name?></h1>
			<?=Funcs::$seo['textpre']['value']?>
			<div class="nav-bar" style="height:30px;">
				<span  style="display: inline-block;position: absolute;top:4px;">Сортировать по</span>

				<div class="select" style="display: inline-block; width: 139px; margin-left: 6px;position: absolute;left: 108px;">
					<div class="select-val">
						<div class="val"><?if($_GET['s']==''):?>актуальности<?else:?><?=Funcs::$sort[$_GET['s']]?><?endif?></div>
						<div class="but"></div>
					</div>
					<input type="hidden" value="">
					<div class="select-list">
						<ul>
							<?foreach(Funcs::$sort as $key=>$item):?>
								<li onclick="catalogSort('<?=$key?>')"><?=$item?></li>
							<?endforeach?>
						</ul>
					</div>
					<script>
						function catalogSort(val){
							if(val=='a'){
								document.location.href="<?=Funcs::getFG('s','?')?>";
							}else{
								document.location.href="?s="+val+"<?=Funcs::getFG('s','&')?>";
							}
						}
					</script>
				</div>

				<span  style="display: inline-block;margin-left: 15px;position: absolute;left: 255px;top:4px;">Товаров на странице</span>
				<div class="select" style="display: inline-block; width: 70px; margin-left: 6px;position: absolute;left: 406px;">
					<div class="select-val">
						<div class="val"><?=$_SESSION['perpage']['catalog']?></div>
						<div class="but"></div>
					</div>
					<input type="hidden" value="">
					<div class="select-list">
						<ul>
							<li onclick="perpage(15)">15</li>
							<li onclick="perpage(30)">30</li>
							<li onclick="perpage(60)">60</li>
							<li onclick="perpage(120)">120</li>
						</ul>
					</div>
					<script>
						function perpage(val){
							document.location.href="?pp="+val+"<?=Funcs::getFG(array('p','pp'),'&')?>";
						};
					</script>
				</div>
				<?PaginationWidget::run()?>
			</div>
			<div class="hr" style="margin-top: 14px;margin-bottom: 15px;"></div>
			<div class="producers">
			<?foreach($vendors['list'] as $item): ?>
				<nobr><a href="/<?=implode('/',Funcs::$uri)?>/<?=$item['path']?>/<?=substr(Funcs::getFG(array('p','ve'),'?'),0,1)=='?'?Funcs::getFG(array('p','ve'),'?'):'';?>"><?=$item['name']?></a><span>(<?=$item['count']?>)</span></nobr>
			<?endforeach?>
			</div>
			<div class="hr" style="margin-top: 18px;margin-bottom: 15px;"></div>
			<table class="catalog-list">
			<?foreach($list as $items):?>
				<tr>
				<?foreach($items as $key=>$item):?>
					<?if($item['name']):?>
						<td><?=View::getRenderEmpty('catalog/listmodel',$item)?></td>
						<?if($key<2):?><td class="sep">&nbsp;</td><?endif?>
					<?else:?>
						<td>&nbsp;</td>
						<?if($key<2):?><td class="sep">&nbsp;</td><?endif?>
					<?endif?>
				<?endforeach?>
				</tr>
			<?endforeach?>
			</table>
			<div class="hr" style="margin-bottom: 18px;"></div>
		   	<div class="nav-bar">
				<a href="#up" class="up-but"></a>
				<?PaginationWidget::run()?>
		   </div>
		</div>
	</div>
	<?
		if((empty($url[3]) || strpos($url[3], "?") !== false) && !empty($fields["fulltext"]))
		{
			echo '<div style="clear: right;">'.$fields["fulltext"].'</div>';
		}
	?>
	<div style="clear: right;"><?=Funcs::$seo['textpost']['value']?></div>
	<div class="clear"></div>
</div>


<?/* ?>
<div id="content"><div class="common_padds"><div class="inline_block">
	<?PaginationWidget::run()?>
	<?CrumbsWidget::run()?>
	<div id="left_part"><div class="left_padds">
		<?OptionsWidget::run($options)?>
	</div></div>
	<div id="right_part"><div class="right_padds">
		<div class="num_on_page">
			<div class="show_on_page">Показывать на странице:</div>
			<div class="select_block">
				<select id="perpage">
					<option value="20" <?if($_SESSION['perpage']['catalog']==20):?>selected<?endif?>>20</option>
					<option value="40" <?if($_SESSION['perpage']['catalog']==40):?>selected<?endif?>>40</option>
					<option value="80" <?if($_SESSION['perpage']['catalog']==80):?>selected<?endif?>>80</option>
					<option value="all" <?if($_SESSION['perpage']['catalog']==500000):?>selected<?endif?>>все</option>
				</select>
			</div>
			<a href="?pp=all&<?=Funcs::getFG('pp')?>" class="is_button">Все товары</a>
			<div class="shown">Показано <?=$_GET['p']==''?1:$_GET['p']*$_SESSION['perpage']['catalog']?>-<?=$quantity<(($_GET['p']+1)*$_SESSION['perpage']['catalog'])?$quantity:(($_GET['p']+1)*$_SESSION['perpage']['catalog'])?> из <?=$quantity?></div>
			<script>
				$(document).ready(function(){
					$("#perpage").change(function(){
						document.location.href="?pp="+$("#perpage option:selected").val()+"<?=Funcs::getFG('pp','&')?>";
					});
				});
			</script>
		</div>
		<div class="catalog_head"><h1><?=$name?><span class="num"><?=$quantity?></span></h1></div>
		<div class="sort_by">
			<div class="s_t">Сортировать по:</div>
			<div class="select_block">
				<select id="sort">
					<option value="a" <?if($_GET['s']=='a'):?>selected<?endif?>>актуальности</option>
					<option value="o" <?if($_GET['s']=='o'):?>selected<?endif?>>популярности</option>
					<option value="r" <?if($_GET['s']=='r'):?>selected<?endif?>>рейтингу</option>
					<option value="pd" <?if($_GET['s']=='pd'):?>selected<?endif?>>цене &darr;</option>
					<option value="pu" <?if($_GET['s']=='pu'):?>selected<?endif?>>цене &uarr;</option>
					<option value="d" <?if($_GET['s']=='d'):?>selected<?endif?>>обновлению</option>
				</select>
			</div>
			<script>
				$(document).ready(function(){
					$("#sort").change(function(){
						if($("#sort option:selected").val()=='a'){
							document.location.href="<?=Funcs::getFG('s','?')?>";
						}else{
							document.location.href="?s="+$("#sort option:selected").val()+"<?=Funcs::getFG('s','&')?>";
						}
					});
				});
			</script>
		</div>
		<div class="catalog_shifts"><table class="default catalog">
			<col width="25%"><col width="25%"><col width="25%"><col width="25%">
			<?foreach($list as $items):?>
				<tr>
				<?foreach($items as $item):?>
					<?if($item['name']):?>
						<?=View::getRenderEmpty('catalog/listmodel',$item)?>
					<?else:?>
						<td>&nbsp;</td>
					<?endif?>
				<?endforeach?>
				</tr>
			<?endforeach?>
		</table></div>
		<?PaginationWidget::run()?>
		<div class="recommended">
			<div class="pattern_head"><div class="padds">Также рекомендуем</div></div>
			<div class="catalog_shifts"><table class="default catalog">
				<col width="25%"><col width="25%"><col width="25%"><col width="25%">
				<tr>
				<?foreach($recommended as $item):?>
					<?=View::getRenderEmpty('catalog/listmodel',$item)?>
				<?endforeach?>
				</tr>
			</table></div>
		</div>
	</div></div>
</div></div></div>
<?*/?>