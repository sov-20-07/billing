<script>
	function number_format( number, decimals, dec_point, thousands_sep ) {
		var i, j, kw, kd, km;
		if( isNaN(decimals = Math.abs(decimals)) ){decimals = 2;}
		if( dec_point == undefined ){dec_point = ",";}
		if( thousands_sep == undefined ){thousands_sep = ".";}	
		i = parseInt(number = (+number || 0).toFixed(decimals)) + "";	
		if( (j = i.length) > 3 ){j = j % 3;} else{j = 0;}	
		km = (j ? i.substr(0, j) + thousands_sep : "");
		kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
		kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");	
		return km + kw + kd;
	}
</script>
<div class="ltCell cell_page-content sizeParent">
	<form method="post" enctype="multipart/form-data" id="frm" action="/<?=Funcs::$cdir?>/orders/dowork/">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="<?=$_SERVER['HTTP_REFERER']==''?'/<?=Funcs::$cdir?>/orders/':$_SERVER['HTTP_REFERER']?>"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<h1 class="cell_page-content_header_text edit_container_header">
							Заказ № C<?=date("dmY",strtotime($cdate))?>-<?=$id?> от <?=date("d.m.Y H:i",strtotime($cdate))?>
						</h1>
						<ul class="edit_form_layout">
							<li class="edit_form_section edit_form_section_info">
								<?/*?><a class="button" href="/<?=Funcs::$cdir?>/orders/basket/?id=<?=$id?>" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 780, height: 450,contentId: 'highslide-html', cacheAjax: false } ); return false;">Добавить товар</a><?*/?>
								<script>
								$(document).ready(function(){
									$("#q").keyup(function(){
										var q=$(this).val();
										$.ajax({
											type: "POST",
											url: "/<?=Funcs::$cdir?>/orders/basket/",
											data: "id=<?=Funcs::$uri[3]?>&q="+q,
											success: function(msg){
												$(".plugin_orders_search_result").html(msg);
												resizeContent();
											}
										});
										
									});	
								});
								</script>
								
								<div class="plugin_orders_search">
									<strong class="plugin_orders_search_header">Поиск товара</strong>
									<input type="text" class="input_text" id="q" >
								</div>
								
								<div class="plugin_orders_search_result"></div>
							</li>
							<li class="edit_form_section edit_form_section_info">
								<div>
									<table class="plugin_orders_table_goods">
										<tr><th>Артикул/№</th><th></th><th>Название</th><th>Размер</th><th>Цена</th><th>Кол-во</th><th>Сумма</th><th></th></tr>
										<?foreach($goods as $item):?>
											<tr>
												<td><?if($item['art']['value']):?><?=$item['art']['value']?><?else:?><?=str_repeat('0',6-strlen($item['id'])).$item['id']?><?endif?></td>
												<td class="plugin_orders_table_img"><img src="/of/<?=$item['info']['pics'][0]['path']?>?w=50&h=50" alt="<?=$item['name']?>"></td>
												<td><?=$item['name']?></td>
												<td><?=$item['size']?></td>
												<td><?=$item['price']?> руб.</td>
												<td><?=$item['num']?></td>			
												<td><?=$item['num']*$item['price']?> руб.</td>
												<td style="text-align: center;"><a class="icon_remove" href="/<?=Funcs::$cdir?>/orders/basketdel/?id=<?=$id?>&tree=<?=$item['tree']?>" title="Удалить из корзины" onclick="return confirm('Удалить объект?\nВсе несохраненные данные будут утеряны')"></a></div></td>
											</tr>
										<?endforeach?>
										<tr class="plugin_orders_table_goods_result-row">
											<td colspan="6">Общая стоимость</td>
											<td colspan="2">
												<strong><span id="itogo"><?=number_format($sum,0,',',' ')?></span> руб.</strong>
												<input type="hidden" id="sum" value="<?=$sum?>">
											</td>
										</tr>
										<tr class="plugin_orders_table_goods_result-row">
											<td colspan="6">
												Скидка (<?=$sale?> руб., <?=$saleperc?>%)<br>
												<i><?=$saletype?></i>
											</td>
											<td colspan="2"><input class="input_text" type="text" id="sale" name="sale" value="<?=$sum/100*$saleperc?>" onblur="recalculateTotal()"> руб.</td>
										</tr>
										<tr class="plugin_orders_table_goods_result-row">
											<td colspan="6">
												Использование бонусов (всего <strong><?=$client['bonuses']?> бон.</strong>)<br>
												<i><?if($bonusesinfo['out']['amount']):?><?=$bonusesinfo['out']['reason']?> <?=$bonusesinfo['out']['amount']?> бон.<?endif?></i>
											</td>
											<td colspan="2"><input class="input_text" type="text" id="bonuses" name="bonusesamount" value="<?=$bonusesamount?>" onblur="recalculateTotal()"> руб.</td>
										</tr>
										<tr class="plugin_orders_table_goods_result-row">
											<td colspan="6" style="font-weight: bold;">Итого</td>
											<td colspan="2">
												<strong><span id="total"><?=number_format($sum-$sum/100*$saleperc-$bonusesamount,0,',',' ')?></span> руб.</strong>
												<input type="hidden" id="price" name="price" value="<?=$sum-$sum/100*$saleperc-$bonusesamount?>">
											</td>
										</tr>
										<tr class="plugin_orders_table_goods_result-row">
											<td colspan="6">Стоимость доставки</td>
											<td colspan="2"><strong><span id="itogodelivery"><?=$deliveryprice?></span> руб.</strong></td>
										</tr>
										<tr class="plugin_orders_table_goods_result-row">
											<td colspan="6">Использовать личный счет (всего <strong><?=$client['balance']?> руб.</strong>):</td>
											<td colspan="2"><input class="input_text" type="text" id="balance" name="balanceamount" value="<?=$balanceamount?>" onblur="recalculateTotal()"> руб.</td>
										</tr>
										<tr class="plugin_orders_table_goods_result-row">
											<td colspan="6" style="font-weight: bold;">К оплате</td>
											<td colspan="2"><strong><span id="totaldelivery"><?=number_format($sum+$deliveryprice-$sum/100*$saleperc-$bonusesamount-$balanceamount,0,',',' ')?></span> руб.</strong></td>
										</tr>
										<tr class="plugin_orders_table_goods_result-row">
											<td colspan="6">
												Начисление бонусов (<?=$bonusesinfo['in']['amount']?> бон., <?=$bonusesinfo['in']['perc']?>%):<br>
												<i><?=$bonusesinfo['in']['reason']?></i>
											</td>
											<td colspan="2">
												<input class="input_text" type="text" name="bonusesinnew" value="<?=floor(($sum-$sum/100*$saleperc)/100*$bonusesinfo['in']['perc'])?>"> бон.
												<input type="hidden" name="bonusesin" value="<?=$bonusesinfo['in']['amount']?>">
												<input type="hidden" name="bonusesinid" value="<?=$bonusesinfo['in']['id']?>">
											</td>
										</tr>
									</table>
								</div>
							</li>
							<li class="edit_form_section edit_form_section_info plugin_orders_info">
								<header class="edit_form_section_header">
									<strong>Клиент</strong>
								</header>
								<table class="edit_form_table plugin_orders_custom-table">
									<?if($iuser==0):?>
										<tr>
											<td>Нет пользователя</td>
											<td>
												<span class="plugin_orders_buttons-after-name">
													<a href="/<?=Funcs::$cdir?>/iuser/popupselect/<?=Funcs::$uri[3]?>/" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 550, height: 500,contentId: 'highslide-html', cacheAjax: false } ); return false;">Выбрать</a> |
													<a href="/<?=Funcs::$cdir?>/iuser/popupedit/?orderid=<?=Funcs::$uri[3]?>" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 500, height: 500,contentId: 'highslide-html', cacheAjax: false } ); return false;">Добавить</a>
												</span>
											</td>
										</tr>
									<?else:?>
										<tr>
											<td>
												Пользователь № <?=$iuser?> 
												<input type="hidden" name="iuser" value="<?=$iuser?>">
											</td>
											<td>
												<a class="plugin_orders_user-link" href="/<?=Funcs::$cdir?>/iuser/edituser/?id=<?=$iuser?>" target="_blank"><?=$client['name']?> (<?=$client['email']?>)</a>
												<span class="plugin_orders_buttons-after-name">
													<a class="button-white" href="/<?=Funcs::$cdir?>/iuser/popupselect/<?=Funcs::$uri[3]?>/" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 550, height: 500,contentId: 'highslide-html', cacheAjax: false } ); return false;">Выбрать</a>
													<a class="button-white" href="/<?=Funcs::$cdir?>/iuser/popupedit/?orderid=<?=Funcs::$uri[3]?>" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 500, height: 500,contentId: 'highslide-html', cacheAjax: false } ); return false;">Добавить</a>
												</span>
												<?/*if(isset($_GET['user'])):?>
													<a href="/<?=Funcs::$cdir?>/orders/edit/<?=Funcs::$uri[3]?>/">Поля заказа</a>
												<?else:?>
													<a href="/<?=Funcs::$cdir?>/orders/edit/<?=Funcs::$uri[3]?>/?user">Поля пользователя</a>
												<?endif*/?>
											</td>
										</tr>
									<?endif?>
									<?if($iuser && $client['adds']['company']):?>
										<tr><td colspan="2"><b><a href="javascript:;" onclick="$('#clientcard').toggle()">Карточка клиента</a></b></td></tr>
										<tbody id="clientcard" style="display:none;">
										<?foreach(OneSSA::$iuserStandartAdds as $title=>$items):?>
											<?foreach($items as $key=>$item):?>
												<tr><td class="tdname"><?=$item['name']?></td><td><?=$client['adds'][$key]?></td></tr>
											<?endforeach?>
										<?endforeach?>
										</tbody>
										<tr><td colspan="2"><b>Данные пользователя</b></td></tr>
									<?endif?>
									<tr>
										<td>Имя</td>
										<td><?=isset($_GET['user'])?$client['name']:$name?></td>
									</tr>
									<tr>
										<td class="tdname">Телефон</td>
										<td><?=isset($_GET['user'])?$client['phone']:$phone?></td>
									</tr>
									<tr>
										<td class="tdname">Email</td>
										<td><?=isset($_GET['user'])?$client['email']:$email?></td>
									</tr>
									<tr>
										<td class="tdname">Пожелания к заказу</td>
										<td><?=nl2br($message)?></td>
									</tr>
								</table>
							</li>
							<li class="edit_form_section edit_form_section_info plugin_orders_info">
								<?Delivery::getDelivery()?>
							</li>
							<li class="edit_form_section edit_form_section_info plugin_orders_info">
								<?Payment::getPayment()?>
							</li>
							<li class="edit_form_section edit_form_section_description">
								<header class="edit_form_section_header">
									<strong>Дополнительная информация</strong>
								</header>
								<div class="ckeditor_layout">
									<textarea class="ckeditor_textarea input_text" id="info" name=info><?=$info?></textarea>
									<script language="javascript">
										$(document).ready( function(){	
											initEditor($("#info"));
										});
									</script>
								</div>
							</li>	
							<li class="edit_form_section edit_form_section_status">
								<header class="edit_form_section_header">
									<strong>Состояние заказа</strong>
								</header>
								<div class="edit_form_status">
									<span class="edit_form_status_caption">Статус:</span>
									<?foreach(Orders::$statuses as $key=>$item):?>
										<label class="form_label">
											<input type="radio" name="status" value="<?=$item['path']?>" <?if($status==$item['path']):?>checked<?endif?>><span class="form_label_text"><?=$item['name']?></span>
										</label>
									<?endforeach?>
								</div>
								<div class="edit_form_client">
									<label class="form_label">
										<input type="checkbox" name="sendemail" value="1" checked><span class="form_label_text">Уведомить клиента</span>
									</label>
									<label class="form_label">
										<input type="checkbox" name="sendgoods" value="1"><span class="form_label_text">Отправить весь состав заказа</span>
									</label>
									<label class="form_label">
										<input type="checkbox" name="loyalty" value="1"><span class="form_label_text">Клиент лоялен</span>
									</label>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="id" value="<?=Funcs::$uri[3]?>"> 
					<span class="button button_save" onClick="if(confirm('Сохранить изменения и обработать?')){$('#frm').submit();}">Сохранить</span>
					<span class="edit_changes">Последние изменения внесены <?=date('H:i d.m.Y',strtotime($wdate))?>, под логином <?=$author?></span>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
function recalculateTotal(){
	var deliveryprice=$('#deliveryprice').val()*1; 
	var sale=$('#sale').val()*1; 
	var sum=$('#sum').val()*1; 
	var bonuses=$('#bonuses').val()*1; 
	var balance=$('#balance').val()*1; 
	var price=sum-sale-bonuses;
	var total=sum+deliveryprice-sale-bonuses-balance;
	$('#deliverypriceshow').text(number_format(deliveryprice,0,',',' '));
	$('#price').val(price);
	$('#total').text(number_format(price,0,',',' '));
	$('#totaldelivery').text(number_format(total,0,',',' '));
}
</script>