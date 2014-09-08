<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/orders/?id=<?=$dealer['id']?>"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Данные <?if($order['preorder']):?>пред<?endif?>заказа</h1>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							
							<pre><?//print_r($cons)?></pre>
							
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<tr>
										<td>Статус</td>
										<td>
											<div class="input_text_holder">
												<select name="status" class="input_text required">
													<?foreach ($statuses as $item):?>
														<option value="<?=$item['id']?>" <?if($item['id']==$order['status']):?>selected<?endif?>><?=$item['name']?></option>
													<?endforeach?>
												</select>												
											</div>
										</td>
									</tr>
									<tr>
										<td>Способ доставки</td>
										<td>
											<div class="input_text_holder">
												<select name="delivery" class="input_text required">
													<?foreach ($delivery as $item):?>
														<option value="<?=$item?>"
															<?if($item==$order['delivery']):?>selected<?endif?>
														><?=$item?></option>
													<?endforeach?>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td>ГП</td>
										<td>
											<div class="input_text_holder">
												<select name="cons" class="input_text required">
													<?foreach ($cons as $item):?>
														<option value="<?=$item['id']?>"
															<?if($item['id']==$order['cons']):?>selected<?endif?>
														><?=$item['title']?> (<?=$item['address']?>)</option>
													<?endforeach?>
												</select>
											</div>											
										</td>
									</tr>
									<tr>
										<td>Стоимость доставки</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="delivery_price" value="<?=$order['delivery_price']?>"></div></td>
									</tr>
									<tr>
										<td>Трекинг</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="tracking" value="<?=$order['tracking']?>"></div></td>
									</tr>
									<tr>
										<td>Высылать уведомления</td>
										<td><div class="input_text_holder"><input type="checkbox" class="input_text required" name="send_notification" <?if($order['send_notification']):?>checked<?endif?>></div></td>
									</tr>									
									<tr>
										<td>Квитанция</td>
										<td><div class="input_text_holder"><?=pathinfo($order['ticket'],PATHINFO_FILENAME)?>
											<a href="javascript:;" onclick="$('#ticket').click();">Добавить квитанцию</a>
											<input type="file" id="ticket" name="ticket" style="display:none;">
										</div></td>
									</tr>
									<tr>
										<td>Тип скидки</td>
										<td>
											<div class="input_text_holder">
												<select name="sale_type" class="input_text required">
													<option value="1" <?if($order['sale_type'] == '0'):?>selected<?endif?>>По умолчанию</option>
													<option value="1" <?if($order['sale_type'] == '1'):?>selected<?endif?>>Разовая</option>
													<option value="2" <?if($order['sale_type'] == '2'):?>selected<?endif?>>Накопительная</options>
												</select>
											</div>
										</td>
									</tr>
									<tr>
										<td>Основная скидка (<?=$order['saleperc']?>%)</td>
										<td><div class="input_text_holder"><?=$order['sale']?>$</div></td>
									</tr>
									<tr>
										<td>Дополнительная скидка (%)</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="add_sale" value="<?=$order['add_sale']?>"></div></td>
									</tr>
									<tr>
										<td>Основание дополнительной скидки</td>
										<td><div class="input_text_holder"><textarea class="input_text" name="add_sale_text"><?=$order['add_sale_text']?></textarea></div></td>
									</tr>
									<tr>
										<td>Комментарий</td>
										<td><div class="input_text_holder"><textarea class="input_text" name="comment"><?=$order['comment']?></textarea></div></td>
									</tr>
									
								</table>
							</li>
						</ul>
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Состав заказа</h1>
							</div>
						</div>
								
						<style>
							.order_table {
								width:100%;
							}
							.plugin_dealers_orders_head td{
								padding: !important 2px;
							}
						</style>			
						<!-- СПИСОК ТОВАРОВ -->
						<ul class="neworder_list">
							<li class="neworder_item">
								<div class="neworder_header neworder_header_opened">
									<span class="neworder_header_text" style="margin-left: 0">Каталог</span>
								</div>
								<?=View::getPluginEmpty('orders/editbranch',array('catalog' => $catalog,'goods'=>$goods,'depth'=>0))?>
							</li>
						</ul>
						<ul class="neworder_list">
							<li class="neworder_item">
								Общая сумма клиента: <?=$order['price']?>$
							</li>
							<li class="neworder_item">
								Общая сумма клиента (1$=<?=Funcs::$conf['currency']['USD']?>руб.): <?=number_format($order['price']*Funcs::$conf['currency']['USD'],2,',',' ')?>руб.
							</li>
						</ul>
						<div style="height:50px"></div>
				
						<pre><?//=print_r($catalog,true)?></pre>
					</div>
				</div>
			</div>
			
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="id" value="<?=$order['id']?>" />
					<input type="hidden" name="dealer" value="<?=$dealer['id']?>" />
					<input type="hidden" name="old_status" value="<?=($order['status'])?$order['status']:'0'?>" />
					<span class="button button_save" onclick="checkForm();">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>
<script src="/<?=ONESSA_DIR?>/js/jquery.treetable.js"></script>
<script>
	$(document).ready( function(){
		( function(){
			var moscow = $("#register_moscow");
			var other = $("#register_other-city");
			var region  = $("#register_region");
			var region_select = $("#register_region_select");
			var city = $("#register_city");
			/*											
			other.on( "click", function(){
				region.fadeIn(400, "easeInOutQuart");
			});
			moscow.on( "click", function(){
				region.fadeOut(400, "easeInOutQuart");
				city.fadeOut(400, "easeInOutQuart");
			});
			*/
			region_select.on( "change", function(){
				getCities($(this).find('option:selected').val(),'register_city_div','');
				city.fadeIn(400, "easeInOutQuart");
			});
			
			getCities($("#register_region_select").find('option:selected').val(),'register_city_div','Курск');
		})();										
	});
	function getCities(regionId,objId,city){
		var obj=$('#'+objId);
		$.ajax({
			type: "POST",
			url: "/onemfssa/dealers/getcities/",
			data: "id="+regionId+"&city="+city,
			success: function(msg){
				obj.html(msg);
			}
		});
	}
	function checkForm(){
		var f=0;
		$('#frm .required').each(function(){
			if (jQuery.trim($(this).val())==''){
				$(this).css('border','1px solid red');
				f=1;
			}else{
				$(this).css('border','');
			}
		});
		if (f==1){
			return false;
		}else{
			$('#frm').submit();
		}
	}
	
	function reinit(){
		
	}
	
	$(document).ready(function(){
		$("#goods").treetable({
			clickableNodeNames: true,
			expandable: true,
			onNodeExpand: function(){$(".edit_container").data('jsp').reinitialise()},
			onNodeCollapse: function(){$(".edit_container").data('jsp').reinitialise()}
			
		});
		/*$('.plugin_dealers_orders_head td').click(function(){
			var id = $(this).parent().attr('id');
			//alert(id);
			$('#body'+id).toggle();
			//$(this).toggleClass('opened');
			var jsp = $(".edit_container").data('jsp');
			jsp.reinitialise();	
		});*/		
		
		
		
		$(".neworder_header").on( "click", function(){
			var $this = $(this);
			$this.toggleClass("neworder_header_opened");
			$this.next().stop(true).slideToggle( 400, "easeOutQuart",function(){
				$(".edit_container").data('jsp').reinitialise();
			});
		});
	});
</script>
