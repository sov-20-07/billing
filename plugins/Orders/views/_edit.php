<div class="ltCell cell_page-content sizeParent">
	<?=View::getPluginEmpty('header')?>
	<script type='text/javascript' src='/<?=Funcs::$cdir?>/js/basket.js'></script>
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow jsScrollContainer">
		<div class="link_step_back_holder">
			<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/"></a>
		</div>
		<div class="jsScrollWrapper">
			<div class="jsScroll whiteOverflow edit_container">
				<div class="ltRow">
					<div class="ltCell cell_page-content_header">
						<h1 class="cell_page-content_header_text"><?=$title?></h1>
					</div>
				</div>
				<div class="gray_line_top">
					<a style="float: left;margin-right: 10px;" href="<?=$_SERVER['HTTP_REFERER']==''?'/<?=Funcs::$cdir?>/orders/':$_SERVER['HTTP_REFERER']?>"><img src="/oneelssa/i/dirup.gif"></a>
					<a href="/<?=Funcs::$cdir?>/orders/basket/?id=<?=$id?>" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 780, height: 450,contentId: 'highslide-html', cacheAjax: false } ); return false;">Добавить товар</a>
				</div>
				<form method="post" enctype="multipart/form-data" id="form" action="/<?=Funcs::$cdir?>/orders/dowork/">
					<table class="goods" cellpadding="3" border="1">
						<tr><th>Артикул/№</th><th>Товар</th><th>Цена</th><th>Вес 1ед.</th><th>Кол-во</th><th>Сумма</th><th>Вес всего</th><th></th></tr>
						<?foreach($goods as $item):?>
							<tr>
								<td><?if($item['art']):?><?=$item['art']?><?else:?><?=str_repeat('0',6-strlen($item['id'])).$item['id']?><?endif?></td>
								<td><img src="/of/<?=$item['info']['pics'][0]['path']?>?w=50&h=50" style="float:left;margin-right:10px" /> <?=$item['name']?></td>
								<td><?=$item['price']?> руб.</td>
								<td><?=$item['info']['weight']?> гр.</td>
								<td><?=$item['num']?></td>			
								<td><?=$item['num']*$item['price']?> руб.</td>
								<td><?=$item['num']*$item['info']['weight']?> гр.</td>
								<td align="center"><a href="/<?=Funcs::$cdir?>/orders/basketdel/?id=<?=$id?>&tree=<?=$item['tree']?>" title="Удалить из корзины" onclick="return confirm('Удалить объект?\nВсе несохраненные данные будут утеряны')">[X]</a></div></td>
							</tr>
						<?endforeach?>
						<tr>
							<td colspan="5" style="text-align: right">Итого:</td>
							<td><span id="itogo"><b><?=number_format($price,0,',',' ')?> руб.</b></span></td>
							<td><?=number_format($weight,0,',',' ')?> гр.</td>
						</tr>
					</table>
					<fieldset class="fieldset">
						<legend>Клиент:</legend> 
						<table cellpadding="3">
							<tr>
								<td class="tdname">Заказ №</td>
								<td><?=$id?> от <?=date("d.m.Y H:i",strtotime($cdate))?></td>
							</tr>
							<?if($iuser==0):?>
								<tr>
									<td class="tdname">Нет пользователя</td>
									<td>
										<a href="/<?=Funcs::$cdir?>/iuser/popup/<?=Funcs::$uri[3]?>/" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 600, height: 700,contentId: 'highslide-html', cacheAjax: false } ); return false;">Добавить</a>
									</td>
								</tr>
							<?else:?>
								<tr>
									<td class="tdname">Пользователь № <?=$iuser?> </td>
									<td>
										<a href="/<?=Funcs::$cdir?>/iuser/edituser/?id=<?=$iuser?>" target="_blank"><?=$client['name']?> (<?=$client['email']?>)</a> |
										<a href="/<?=Funcs::$cdir?>/iuser/popup/<?=Funcs::$uri[3]?>/" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 600, height: 700,contentId: 'highslide-html', cacheAjax: false } ); return false;">Сменить</a> |
										<?if(isset($_GET['user'])):?>
											<a href="/<?=Funcs::$cdir?>/orders/edit/<?=Funcs::$uri[3]?>/">Поля заказа</a>
										<?else:?>
											<a href="/<?=Funcs::$cdir?>/orders/edit/<?=Funcs::$uri[3]?>/?user">Поля пользователя</a>
										<?endif?>
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
								<td class="tdname">Имя</td>
								<td><input type="text" class="input" name="name" value="<?=isset($_GET['user'])?$client['name']:$name?>" /></td>
							</tr>
							<tr>
								<td class="tdname">Телефон</td>
								<td><input type="text" class="input" name="phone" value="<?=isset($_GET['user'])?$client['phone']:$phone?>" /></td>
							</tr>
							<tr>
								<td class="tdname">Email</td>
								<td><input type="text" class="input" name="email" value="<?=isset($_GET['user'])?$client['email']:$email?>" /></td>
							</tr>
							<tr>
								<td class="tdname">Пожелания к заказу</td>
								<td><textarea name="message"><?=nl2br($message)?></textarea></td>
							</tr>
						</table>
					</fieldset>
					<?Delivery::getDelivery();?>
					<?Payment::getPayment();?>
					<fieldset class="fieldset">
						<legend>Дополнительная информация:</legend> 
						<textarea name="info"><?=$info?></textarea>
						<script language="javascript">
				  			CKEDITOR.replace("info",{
				       			filebrowserUploadUrl : '/onessa/dor/upload.php',
				       			filebrowserBrowseUrl : '/onessa/dor/ckfinder/ckfinder.html',
				 				filebrowserImageBrowseUrl : '/onessa/dor/ckfinder/ckfinder.html?type=Images',
				 				filebrowserFlashBrowseUrl : '/onessa/dor/ckfinder/ckfinder.html?type=Flash' 
				   			});
				   		</script>
					</fieldset>
					<input type="hidden" name="id" value="<?=$id?>">
					<fieldset class="fieldset">
						<legend>Изменить статус заказа:</legend> 
						<div style="color: green; position:relative; padding-left:5px">
							<select name="status">
							<?foreach(Orders::$statuses as $key=>$item):?>
								<option value="<?=$item['path']?>" <?if($status==$item['path']):?>selected<?endif?>><?=$item['name']?></option>
							<?endforeach?>
							</select>
							<label style="display: inline;"><input type="checkbox" name="sendemail" value="1" checked /> &mdash; уведомить клиента</label> <br />
							<label style="display: inline;"><input type="checkbox" name="loyalty" value="1" /> &mdash; клиент лоялен</label><br/>
							<input type="submit" name="submit" value="Обработать" onClick="return confirm('Сохранить изменения и обработать?')">
							<input type="button" name="submit" value="Вернуться" onClick="document.location.href='<?=$_SERVER['HTTP_REFERER']?>'">
						</div>
					</fieldset>
					<br /><br /><br />
		</form>
	</div>
</div>