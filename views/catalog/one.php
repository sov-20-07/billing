<div id="content">
	<?CrumbsWidget::run()?>
	<div class="card" id="up">
		<div class="left-coll">
			<div class="photo">
				<div class="product-carousel">
					<div class="bip-pic" style="margin-top: -16px;">
						<a href="<?=$pics[0]['path']?>" title="<?=$pics[0]['name']?>" onclick="return hs.expand(this,galleryOptions)"><img src="/of/4<?=$pics[0]['path']?>" alt="<?=$pics[0]['name']?>" /></a>
					</div>
					<?if(count($pics)>1):?>
						<div class="carousel">
							<ul>
							<?foreach($pics as $i=>$item):?>
								<?if($i>0):?>
									<li><a href="<?=$item['path']?>" title="" onclick="return hs.expand(this,galleryOptions)"><img src="/of/3<?=$item['path']?>" alt="<?=$item['name']?>" /></a></li>
								<?endif?>
							<?endforeach?>
							</ul>
						</div>
						<?if(count($pics)>4):?>
							<span class="prev_pr disabled"></span>
							<span class="next_pr"></span>
						<?endif?>
					<?endif?>
				</div>
				<script type="text/javascript">
					var galleryOptions = {
						slideshowGroup: 1,
						outlineType: 'rounded-white',
						wrapperClassName: 'projects_gallery',
						dimmingOpacity: 0.7,
						align: 'center',
						transitions: ['expand', 'crossfade'],
						fadeInOut: true,
						marginLeft: 100,
						marginBottom: 0,
						captionEval: 'this.thumb.alt',
						useBox: true,
						width: 734,
						height: 512
					};
					hs.addSlideshow({
						slideshowGroup: 1,
						interval: 5000,
						repeat: true,
						useControls: true,
						overlayOptions: {
							thumbnailId: 'art1gallary',
							className: 'text-controls',
							relativeTo: 'highslide-wrapper',
							offsetY: "50%"
						},
						thumbstrip: {
							thumbnailId: 'art1gallary',
							position: 'bottom center',
							mode: 'horizontal',
							relativeTo: 'highslide-wrapper',
							offsetY: 170
						}
					});
					// not dragged
					hs.Expander.prototype.onDrag = function() {
						return false;
					};
					// Keep the position after window resize
					hs.addEventListener(window, 'resize', function() {
						var i, exp;
						hs.page = hs.getPageSize();
						for (i = 0; i < hs.expanders.length; i++) {
							exp = hs.expanders[i];
							if (exp) {
								var x = exp.x,
										y = exp.y;
								// get new thumb positions
								exp.tpos = hs.getPosition(exp.el);
								x.calcThumb();
								y.calcThumb();
								// calculate new popup position
								x.pos = x.tpos - x.cb + x.tb;
								x.scroll = hs.page.scrollLeft;
								x.clientSize = hs.page.width;
								y.pos = y.tpos - y.cb + y.tb;
								y.scroll = hs.page.scrollTop;
								y.clientSize = hs.page.height;
								exp.justify(x, true);
								exp.justify(y, true);
								// set new left and top to wrapper and outline
								exp.moveTo(x.pos, y.pos);
							}
						}
					});
					var ovn=0;
					hs.Expander.prototype.onCreateOverlay=function(){	}
					
					$(document).ready(function(){
					$(".popup_layer .popup_window.added_width #same_price").attr("src", "/popup/sameprice/?id=<?=$id?>");
					});
				</script>
			</div>
			<div class="annotation-card">
				<h1><?=$name?><?/*=$akcia*/?></h1>
				<?if($rst==1):?><span class="rst"></span><?elseif($hit==1):?><span class="hit"></span><?elseif($new==1):?><span class="new"></span><?endif?>
				<span class="stars st<?=$rating?>"></span>
				<?if ($report>0){?>
				<a href="#tabs" onclick="$('#tabs').tabs('select','#comment')"><span class="doted" style="margin-right: 3px;">Отзывы</span></a><span class="grey">(<?=$report?>)</span>
				<?}?>
				<div class="availability">
					<?if($available):?>
						<?/*?><span class="green">Осталось на складе: <?=$instock?></span><? Отключено 14.12.12, т.к. никто за остатком на складе не следит*/?> 
					<?else:?>
						<span class="grey bold" style="margin-right: 15px;">Нет на складе</span><span class="doted">Сообщить о поступлении</span>
					<?endif?>
				</div>
				<?if($akcia=='1'){?>
				<img src="/i/akcia/prize.png" />
				<?}?>
				<?=$description?>
				
				<div class="button-bar">
					<a href="#tabs" class="properties" onclick="$('#tabs').tabs('select','#tabs-1')"><span class="doted">особенности</span></a>
					<a href="#tabs"  class="features" onclick="$('#tabs').tabs('select','#tabs-2')"><span class="doted">характеристики</span></a>
					<a href="#tabs"  class="equipment" onclick="$('#tabs').tabs('select','#tabs-3')"><span class="doted">комплектация</span></a>
				</div>

				<?if (count($same_price)>0){?>
				<span style="margin-top: 12px;" class="doted" onclick="showSamePrice();">! Больше функций за те же деньги</span>

				<?}?>
			</div>
		<div class="clear"></div>
		<div class="hr" style="margin-top: 23px;margin-bottom: 17px;"></div>
			<?if(count($accessories)>0):?>
				<h3>С этим товаром покупают</h3>
				<table class="v-top">
					<tr>
					<?foreach($accessories as $item):?>
						<td><?=View::getRenderEmpty('catalog/listmodelsmall',$item)?></td>
					<?endforeach?>
					</tr>
				</table>
				<div class="hr" style="margin-top: 12px;margin-bottom: 16px;"></div>
			<?endif?>
			<?/*?><h3>Подробное описание</h3><?*/?>
			<div class="detailed-description">
				<div id="tabs" style="margin-top: 14px;">
				<? if(Funcs::$mobile == false)
				{ ?>
					<ul>
						<?if(trim(strip_tags($additional['features']))):?><li class="to-click"><a href="#tabs-1">Функции и особенности</a></li><?endif?>
						<?if(trim(strip_tags($additional['characteristics']))):?><li class="to-click"><a href="#tabs-2">Характеристики</a></li><?endif?>
						<?if(trim(strip_tags($additional['complectation']))):?><li class="to-click"><a href="#tabs-3">Комплектация</a></li><?endif?>
						<?if(trim(strip_tags($additional['video']))):?><li class="to-click"><a href="#tabs-4">Видео-обзор</a></li><?endif?>
						<li class="to-click"><a href="#comment">Отзывы</a></li>
					</ul>
				<? } ?>
				<? if(Funcs::$mobile == true)
				{ ?>
					<ul>
						<?if(trim(strip_tags($additional['features']))):?><li class="to-click"><a class="mobile-button" href="#tabs-1">Функции и особенности</a></li><?endif?>
						<?if(trim(strip_tags($additional['characteristics']))):?><li class="to-click"><a class="mobile-button" href="#tabs-2">Характеристики</a></li><?endif?>
						<?if(trim(strip_tags($additional['complectation']))):?><li class="to-click"><a class="mobile-button" href="#tabs-3">Комплектация</a></li><?endif?>
						<?if(trim(strip_tags($additional['video']))):?><li class="to-click"><a class="mobile-button" href="#tabs-4">Видео-обзор</a></li><?endif?>
						<li class="to-click"><a class="mobile-button" href="#comment">Отзывы</a></li>
					</ul>
				<? } ?>
					<?if(trim(strip_tags($additional['features']))):?><div id="tabs-1"><?=$additional['features']?></div><?endif?>
					<?if(trim(strip_tags($additional['characteristics']))):?><div id="tabs-2"><?=$additional['characteristics']?></div><?endif?>
					<?if(trim(strip_tags($additional['complectation']))):?><div id="tabs-3"><?=$additional['complectation']?></div><?endif?>
					<?if(trim(strip_tags($additional['video']))):?><div id="tabs-4"><?=$additional['video']?></div><?endif?>
					<div id="comment">
						<?if($reportme || count($_SESSION['user'])>0):?>
							<form class="reportform" onsubmit="return checkoneform()" method="post" id="oneform">
								<?if(count($_SESSION['user'])>0):?>
									Здравствуйте, <?=$_SESSION['user']['name']?>!<br />
									Вы можете оставить отзыв.<br /><br />
									<div class="field_block">
										<div class="field_name">Имя</div>
										<div class="field rating_comment"><input type="text" name="name" value="" class="text required"/></div>
									</div>
									<div class="field_block">
										<div class="field_name">Email</div>
										<div class="field rating_comment"><input type="text" name="email" value="" class="text required"/></div>
									</div>
								<?else:?>
									Здравствуйте, <?=$reportme['name']?>!<br />
									<input type="hidden" name="name" value="<?=$reportme['name']?>" />
									<input type="hidden" name="email" value="<?=$reportme['email']?>" />
								<?endif?>
								<div class="ratestars"><span class="font_11 light_gray" style="width: 100px;">Рейтинг товара</span><div class="stars"><div class="inline_block getstars"><span ids="1"></span><span ids="2"></span><span ids="3"></span><span ids="4"></span><span ids="5"></span></div></div></div>
								<div class="field_block">
									<div class="field_name">Отзыв</div>
									<div class="field rating_comment"><textarea name="report" class="with_back required text report" rows="10" ></textarea></div>
								</div>
								<input type="submit" class="is_button send-sm-but " value="" id="sbmt1"><br /><br />
								<input type="hidden" name="stars" class="required" value="" />						
								<script>
									$(document).ready(function(){
										$('.getstars span').click(function(){
											$('input:[name=stars]').val($(this).attr('ids'));
											$('.ratestars').css('background-position','0 -'+($(this).attr('ids')*13)+'px');
										});
										$('.getstars span').hover(
											function(){$(".getstars").css( "background-position", "0 -"+($(this).attr('ids')*13)+"px" );},
											function(){$(".getstars").css( "background-position", $('.ratestars').css('background-position') );}
										);
									});
									function checkoneform(){
										var f=0;
										$('#oneform .required').each(function(){
											if (jQuery.trim($(this).val())==''){
												if($(this).attr('type')=='hidden'){
													alert('Поставьте рейтинг');
												}
												$(this).css('border','solid 1px red');
												f=1;
											}else{
												$(this).css('border','');
											}
										});
										if (f==1){
											 return false;
										}else return true;
									}
								</script>
							</form>
						<?endif?>
						<?if(!$reportme || count($_SESSION['user'])>0):?>
							<?foreach($reports as $item):?>
								<div class="review">
									<span class="stars st<?=$item['stars']?>"></span>
									<span class="r_date"><?=Funcs::convertDate($item['create_date'])?>
										<?if(count($_SESSION['user'])>0):?><a href="/catalog/delreport/?id=<?=$item['id']?>&tree=<?=$id?>" title="Удалить" onclick="return confirm('Удалить отзыв?');">[x]</a><?endif?>
									</span>
									<h5><?=$item['name']?></h5>
									<?=nl2br($item['report'])?>
									<div class="hr" style="margin: 9px 0 16px 0;"></div>
 								</div>
							<?endforeach?>
						<?endif?>
						<div class="comment">Отзыв о данном товаре может быть оставлен только человеком, ранее совершившим его приобретение</div>
					</div>
				</div>
			</div>
			<div class="hr" style="margin-bottom: 16px;"></div>
			<h3>Схожие предложения</h3>
			<table class="catalog-list">
				<tr>
				<?foreach($similargoods as $i=>$item):?>
					<td>
						<?=View::getRenderEmpty('catalog/listmodel',$item)?>
					</td>
					<?if($i<2):?>
						<td class="sep">&nbsp;</td>
					<?endif?>
				<?endforeach?>
				</tr>
			</table>
		</div>
		<div class="right-coll">
			<div class="fixed-block">
			<?if($available){?>
				<div class="buy-block">
					<span class="price"><?=number_format($price,0,'',' ')?><span class="rub" style="font-size: 28px">a</span></span><br/>
					<span class="in-basket-but add_to_basket" path="action" ids="<?=$tree?>" num="1"></span><br/>
					<?/*?><img src="/i/visa.png" /><?*/?>
				</div>
				
				<div class="one-click">
					<h3>Купить в один клик</h3>
					<span class="grey">Менеджер перезвонит вам, узнает все детали и сам оформит заказ на ваше имя.</span><br/>
					<div class="call"> 
						<input type="text" class="text" id="onclickphone" value="телефон" />
						<input type="button" class="order-but add_to_basket_click"  ids="<?=$tree?>" />
						<input type="hidden" id="gnum<?=$tree?>" value="1" />
					</div>
				</div>
				
			<?}else{?>
			<div class="buy-block">
					<span class="price">Нет на складе</span>
				</div>
			<?}?>
				<div class="white-block">
					<?foreach(Funcs::$infoblock['banners'] as $item):?>
					<?if($item['path']=='3'){?>
					<?if(($price>=4000)&&($available)){?>
					<?=$item['description']?>
					<?}?>
					<?}else{?>
						<?=$item['description']?>
					<?}?>
					<?endforeach?>
				</div>
				<div class="up">
					<a class="up-but" href="#up"></a>
				</div>
			</div>

		</div>
		<div class="clear"></div>
		<?PanelWidget::hor()?>
	</div>
	<div class="clear"></div>
</div>

<?/* ?>
<div class="fixed_width">
	<?CrumbsWidget::run()?>
	<div class="content">
		<div id="left_part"><div class="pseudo_border"><div class="white_block">
			<?if(count($fields['files_gal'])>0):?>
				<div class="middle_photo"><a href="<?=$fields['files_gal'][0]['path']?>" onclick="return hs.expand(this,galleryOptions1)"><img src="/of/4<?=$fields['files_gal'][0]['path']?>" alt="<?=$fields['files_gal'][0]['name']?>" /></a></div>
				<div class="icon ic_zoom">Щелкните на фото для увеличения</div>
				<div class="previews"><div class="inline_block">
					<?foreach($fields['files_gal'] as $i=>$item):?>
						<?if($i>0):?>
							<a href="<?=$item['path']?>" onclick="return hs.expand(this,galleryOptions1)"><img src="/of/1<?=$item['path']?>" alt="<?=$item['name']?>" /></a>
						<?endif?>
					<?endforeach?>
				</div></div>
				<script type="text/javascript"> 
					var galleryOptions1 = {
							slideshowGroup: 2,
							wrapperClassName: "dark",
							outlineType: 'rounded-white',
							dimmingOpacity: 0.8,
							align: 'center',
							transitions: ['expand', 'crossfade'],
							fadeInOut: true,
							wrapperClassName: 'borderless floating-caption',
							marginLeft: 100,
							marginBottom: 0,
							numberPosition: 'caption',
							captionEval: 'this.thumb.alt'
						};
						hs.addSlideshow({
							slideshowGroup: 2,
							interval: 5000,
							repeat: true,
							useControls: true,
							overlayOptions: {
								thumbnailId: 'art1gallary',
								className: 'text-controls',
								position: 'bottom center',
								relativeTo: 'viewport',
								offsetY: -60
							},
							thumbstrip: {
								thumbnailId: 'art1gallary',
								position: 'bottom center',
								mode: 'horizontal',
								relativeTo: 'viewport'
							}
						});
				</script>
			<?endif?>
			<?BannersWidget::run()?>

		</div></div></div>
		<div id="right_part"><div class="inline_block">
			<h1><?=$name?></h1>
			<div class="stars s<?=$fields['rating']?>"></div>
			<div class="blue_border"><div class="card_block inline_block"><div class="card_padds">
				<div class="good_options inline_block">
					<div class="price_block">
						<?if($fields['price']>0):?>
							<span class="rur24_bold"><?=number_format($fields['price'],0,'',' ')?></span>
						<?else:?>
							<span class="rur24_bold" style="background:none;">По запросу</span>
						<?endif?>
						<?if($fields['price']>0):?>
							<span class="change_quantity"><span class="nav minus ic_minus_goods" ids="<?=$id?>" disabled></span><input type="text" value="1" id="gnum<?=$id?>" name="gnum<?=$id?>" /><span class="nav plus ic_plus_goods" ids="<?=$id?>"></span></span>
						<?endif?>
						<?if($fields['available']==0):?>
							<span class="is_button buydisabled" ids="<?=$id?>" num="1"></span>
							<div class="no_stock">Нет на складе</div>
							<div id="subscribe" class="report_the_receipt">
								<span class="pseudo" onclick="$(this).next().toggle()">Сообщить мне о поступлении</span>
								<form onsubmit="return checktwoform()" method="post" id="twoform" style="display:none;">
									<input type="text" class="text required" id="sname" name="name" value="Ваше имя" onclick="$(this).val('');" />
									<input type="text" class="text required t2" id="semail" name="email" value="Email" onclick="$(this).val('');" />
									<input type="hidden" name="subscribe" value="1" />
									<input type="submit" value="Отправить" class="is_button_subscribe">
								</form>
								<br />
							</div>
							<div id="subscribedone" style="display:none;">
								Вам будет выслано письмо, <br />как только товар появится в магазине!
							</div>
							<script>
								function checktwoform(){
									var f=0;
									$('#twoform .required').each(function(){
										if (jQuery.trim($(this).val())=='' || $(this).val()=='Ваше имя' || $(this).val()=='Email'){
											$(this).css('border','solid 1px red');
											f=1;
										}else{
											$(this).css('border','');
										}
									});
									if (f==1){
										 return false;
									}else{
										$.ajax({
											type: "POST",
											url: "",
											data: "subscribe=1&name="+$("#sname").val()+"&email="+$("#semail").val(),
											success: function(msg){
												$('#subscribe').slideUp();
												$('#subscribedone').slideDown();
											}
										});
										return false;
									}
								}
							</script>
						<?else:?>
							<?if($fields['price']>0):?>
								<span class="is_button buy add_to_basket" ids="<?=$id?>" num="1" onclick="$(this).attr('num',$('#gnum<?=$id?>').val());" ></span>
							<?endif?>
						<?endif?>
					</div>
					
					
					
					
					
					
					
					
					
					
					<div class="price_block"><br />
						<?if($fields['price']>0):?>
							<span class="rur24_bold"><?=number_format(intval($fields['price']/10),0,'',' ')?></span>
						<?else:?>
							<span class="rur24_bold" style="background:none;">По запросу</span>
						<?endif?>
						<?if($fields['price']>0):?>
							<span class="change_quantity"><span class="nav minus ic_minus_goods1" ids="<?=$id?>" disabled></span><input type="text" value="1" id="gnum1<?=$id?>" name="gnum1<?=$id?>" /><span class="nav plus ic_plus_goods1" ids="<?=$id?>"></span></span>
						<?endif?>
						<?if($fields['available']==0):?>
							<span class="is_button buydisabled" ids="<?=$id?>" num="1"></span>
							<div class="no_stock">Нет на складе</div>
							<div id="subscribe" class="report_the_receipt">
								<span class="pseudo" onclick="$(this).next().toggle()">Сообщить мне о поступлении</span>
								<form onsubmit="return checktwoform()" method="post" id="twoform" style="display:none;">
									<input type="text" class="text required" id="sname" name="name" value="Ваше имя" onclick="$(this).val('');" />
									<input type="text" class="text required t2" id="semail" name="email" value="Email" onclick="$(this).val('');" />
									<input type="hidden" name="subscribe" value="1" />
									<input type="submit" value="Отправить" class="is_button_subscribe">
								</form>
								<br />
							</div>
							<div id="subscribedone" style="display:none;">
								Вам будет выслано письмо, <br />как только товар появится в магазине!
							</div>
							<script>
								function checktwoform(){
									var f=0;
									$('#twoform .required').each(function(){
										if (jQuery.trim($(this).val())=='' || $(this).val()=='Ваше имя' || $(this).val()=='Email'){
											$(this).css('border','solid 1px red');
											f=1;
										}else{
											$(this).css('border','');
										}
									});
									if (f==1){
										 return false;
									}else{
										$.ajax({
											type: "POST",
											url: "",
											data: "subscribe=1&name="+$("#sname").val()+"&email="+$("#semail").val(),
											success: function(msg){
												$('#subscribe').slideUp();
												$('#subscribedone').slideDown();
											}
										});
										return false;
									}
								}
							</script>
						<?else:?>
							<?if($fields['price']>0):?>
								<a href="javascript:;" class="is_button credit" ids="<?=$id?>" num="1" onclick="$(this).attr('num',$('#gnum1<?=$id?>').val());"></a>
							<?endif?>
							<div class="opt_links">
								<?if($pricelist):?>
									<a href="<?=$pricelist['path']?>" target="_blank" class="icon ic_pricelist is_dark">скачать оптовый прайс-лист</a><br />
								<?endif?>
								<a href="javascript:;" class="icon ic_favorite add_to_favorite" ids="<?=$id?>" onclick="alert('Товар добавлен в избранное')"><span class="pseudo is_dark">добавить в избранное</span></a>
							</div>
						<?endif?>
					</div>
					
					
					
					
					
					
					
					
					
					
					
					
					<div class="code_phone is_dark">
						<div class="phone_order">Вы можете заказать этот товар по телефону:</div>
						<b class="font_18"><?=Funcs::$conf['settings']['phone']?></b><br />
						<span class="good_code">Код товара: <b class="font_18"><?=str_repeat('0',5-strlen($id))?><?=$id?></b></span>
					</div>
				</div>
				 <div class="add_services">
				 	<b>Дополнительные услуги</b>
				 	<div class="inline_block"><div class="minus_shifts">
				 		<div class="float_block">
				 			<div class="with_help">
				 				<a href="/services/mounting/"><label class="custom_checkbox mounting" onclick="document.location.href='/services/mounting/'">Монтаж<br /><?if($mounting>0):?><b class="is_black"><span class="rur12_bold"><?=number_format($mounting,0,'',' ')?></span></b><?endif?></label></a>
				 				<span class="icon ic_help open_help"></span>
				 				<div class="help_block"><div class="padds">
				 					<span class="icon ic_close" title="Закрыть"></span>
				 					<div class="help_head">Монтаж&nbsp;<span class="icon ic_help"></span></div>
				 					<?=Funcs::$reference['servicescard']['mounting']['value']?><br />
				 					<a href="/services/mounting/" class="is_white">Подробное описание</a>
				 				</div></div>
				 			</div>
				 		</div>
				 		<?if(Funcs::$uri[0]=='catalog' && Funcs::$uri[1]!='equipment'):?>
				 		<div class="float_block">
				 			<div class="with_help">
				 				<a href="/services/projecting/"><label class="custom_checkbox projecting" onclick="document.location.href='/services/projecting/'">Проектирование</label></a>
				 				<span class="icon ic_help open_help"></span>
				 				<div class="help_block"><div class="padds">
					 				<span class="icon ic_close" title="Закрыть"></span>
					 				<div class="help_head">Проектирование&nbsp;<span class="icon ic_help"></span></div>
					 				<?=Funcs::$reference['servicescard']['projecting']['value']?><br />
					 				<a href="/services/projecting/" class="is_white">Подробное описание</a>
				 				</div></div>
				 			</div>
				 		</div>
				 		<?endif?>
				 		<div class="float_block">
							<div class="with_help">
								<a href="/services/delivery/"><label class="custom_checkbox delivery" onclick="document.location.href='/services/delivery/'">Доставка</label></a>
								<span class="icon ic_help open_help"></span>
								<div class="help_block"><div class="padds">
									<span class="icon ic_close" title="Закрыть"></span>
									<div class="help_head">Доставка&nbsp;<span class="icon ic_help"></span></div>
									<?=Funcs::$reference['servicescard']['delivery']['value']?><br />
									<a href="/services/delivery/" class="is_white">Подробное описание</a>
								</div></div>
							</div>
						</div>
						<div class="float_block">
							<div class="with_help">
								<a href="/services/warranty/"><label class="custom_checkbox warranty" onclick="document.location.href='/services/warranty/'">Сервис</label></a>
								<span class="icon ic_help open_help"></span>
								<div class="help_block"><div class="padds">
									<span class="icon ic_close" title="Закрыть"></span>
									<div class="help_head">Сервис&nbsp;<span class="icon ic_help"></span></div>
									<?=Funcs::$reference['servicescard']['warranty']['value']?><br />
									<a href="/services/warranty/" class="is_white">Подробное описание</a>
								</div></div>
							</div>
						</div>
					</div></div>
				</div>
			</div></div></div>
			<!-- блок с закладками -->
			<div class="bookmarks">
				<ul>
					<li class="bkm act" id="bk1">Технические характеристики</li>
					<li class="bkm" id="bk2">описание</li>
					<?if(count($fields['files'])>0):?>
						<li class="bkm" id="bk4">файлы (<?=count($fields['files'])?>)</li>
					<?endif?>
					<li class="bkm" id="bk3">отзывы (<?=$fields['report']?>)</li>
				</ul>
				<!-- содержимое закладок -->
				<div class="bookmark_content"><div class="bkm_padds">
					<div class="bookmark_block act block_bk1">
						<table class="colored">
						<?foreach($fields['additional'] as $key=>$item):?>
							<?if($key!='novelty' && $key!='sale' && $key!='Рейтинг для каталога' && $key!='industrial'):?>
								<tr>
									<td><?=$key?></td>
									<td><?=$item?></td>
								</tr>
							<?endif?>
						<?endforeach?>
						</table>
					</div>
					<div class="bookmark_block block_bk2">
						<?=$fields['description']?>
					</div>
					<div class="bookmark_block block_bk4">
						<?foreach($fields['files'] as $item):?>
							<div class="file">
								<a class="<?=$item['file']['raz']?>" href="<?=$item['path']?>"><?if($item['name']==''):?><?=$item['file']['name']?><?else:?><?=$item['name']?><?endif?></a>
								<p><?=$item['file']['raz']?>, <?=$item['file']['filesize']?></p>
							</div>
						<?endforeach?>
					</div>
					<div class="bookmark_block block_bk3">
						<?if(is_array($report) || count($_SESSION['user'])>0):?>
							<form class="reportform" onsubmit="return checkoneform()" method="post" id="oneform">
								<?if(count($_SESSION['user'])>0):?>
									Здравствуйте, <?=$_SESSION['user']['name']?>!<br />
									Вы можете оставить отзыв.<br /><br />
									<div class="field_block">
										<div class="field_name">Имя</div>
										<div class="field rating_comment"><input type="text" name="name" value="" /></div>
									</div>
									<div class="field_block">
										<div class="field_name">Email</div>
										<div class="field rating_comment"><input type="text" name="email" value="" /></div>
									</div>
								<?else:?>
									Здравствуйте, <?=$report['name']?>!<br />
									<input type="hidden" name="name" value="<?=$report['name']?>" />
									<input type="hidden" name="email" value="<?=$report['email']?>" />
								<?endif?>
								<div class="set_rating"><span class="font_11 light_gray">Рейтинг товара</span><br /> <div class="stars"><div class="inline_block getstars"><span ids="1"></span><span ids="2"></span><span ids="3"></span><span ids="4"></span><span ids="5"></span></div></div></div>
								<div class="field_block">
									<div class="field_name">Отзыв</div>
									<div class="field rating_comment"><textarea name="report" class="with_back required" rows="10"></textarea></div>
								</div>
								<input type="submit" class="is_button send" value="" id="sbmt1"><br /><br />
								<input type="hidden" name="stars" class="required" value="" />						
								<script>
									$(document).ready(function(){
										$('.getstars span').click(function(){
											$('input:[name=stars]').val($(this).attr('ids'));
											$('.stars span').unbind('hover');
											$('.getstars').parent().css('background-position','0 -'+($(this).attr('ids')*15)+'px');
											
										});
									});
									function checkoneform(){
										var f=0;
										$('#oneform .required').each(function(){
											if (jQuery.trim($(this).val())==''){
												if($(this).attr('type')=='hidden'){
													alert('Поставьте рейтинг');
												}
												$(this).css('border','solid 1px red');
												f=1;
											}else{
												$(this).css('border','');
											}
										});
										if (f==1){
											 return false;
										}else return true;
									}
								</script>
							</form>
						<?endif?>
						<?if(!is_array($report) || count($_SESSION['user'])>0):?>
							<?foreach($reports as $item):?>
								<div class="review">
									<span class="stars s<?=$item['stars']?>"></span>
									<span class="r_date"><?=Funcs::convertDate($item['create_date'])?>
										<?if(count($_SESSION['user'])>0):?><a href="/catalog/delreport/?id=<?=$item['id']?>&tree=<?=$id?>" title="Удалить" onclick="return confirm('Удалить отзыв?');">[x]</a><?endif?>
									</span>
									<span class="r_who"><?=$item['name']?></span>
									
									<br /><?=nl2br($item['report'])?>
 								</div>
							<?endforeach?>
						<?endif?>
						<div class="comment">Отзыв о данном товаре может быть оставлен только человеком, ранее совершившим его приобретение</div>
					</div>
				</div></div>
			</div>
			<a href="<?=strpos($_SERVER['HTTP_REFERER'],'/catalog/')!==false?$_SERVER['HTTP_REFERER']:'/catalog/'?>" class="back_to">Вернуться в каталог</a>
		</div></div>
		<div class="similar_goods">
			<div class="head_padds"><div class="head"><span>Похожие товары</span></div></div>
			<div class="goods">
				<div class="minus_margs">
					<?foreach($recommended as $item):?>
						<?=View::getRenderEmpty('catalog/listmodel',$item)?>
					<?endforeach?>
				</div>
			</div>
		</div>
	</div>
</div>
<?*/?>