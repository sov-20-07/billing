<div class="top_block fixed_width">
	<div id="navigation">
		<span class="icon right_arrow"></span><a href="/" class="icon ic_home" title="На главную"></a><span class="icon right_arrow"></span><a href="/cabinet/" class="is_gray">Ваш кабинет</a><span class="icon right_arrow"></span><a href="/cabinet/delivery/" class="is_gray">Параметры доставки</a>
	</div>
</div>
<div class="content fixed_width"><div class="padds10"><div class="inline_block">
	<div id="left_part"><div class="inline_block"><div class="padds10">
		<?MenuWidget::CabinetMenu()?>
	</div></div></div>
	<div id="right_part"><div class="padds020"><div class="inline_block">
		<h1>Добавить адрес</h1>
		<div class="select_user_type in_cabinet inline_block">
			<label class="individual"><input type="radio" name="rgr_type" <?if($adds['company']==''):?>checked<?endif?> />Физическое лицо</label>
			<label class="legal_person"><input type="radio" name="rgr_type" <?if($adds['company']!=''):?>checked<?endif?> />Юридическое лицо</label>
		</div>
		<div class="block_individual <?if($adds['company']==''):?>act_block<?endif?>">
			<form class="cabinet_form" action="/cabinet/adds/save/" method="post" id="fizform" onsubmit="return checkFizForm()">
				<div class="form_block">
					<div class="param_name">Название</div>
					<div><input type="text" class="text required" name="title" value="<?=$adds['title']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Имя получателя</div>
					<div><input type="text" class="text required" name="name" value="<?=$adds['name']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Email</div>
					<div><input type="text" class="text required" name="email" value="<?=$adds['email']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Номер телефона</div>
					<div><input type="text" class="text required" name="phone" value="<?=$adds['phone']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Адрес доставки</div>
					<div><textarea class="required" name="address"><?=$adds['address']?></textarea></div>
				</div>
				<div class="form_note with_bottom_border">Укажите, пожалуйста, полный адрес с индексом.</div>
				<div class="form_note note2">Для изменения данных заполните поля и нажмите кнопку «Сохранить»</div>
				<div class="i_agree"><label><input type="checkbox" onchange="if($(this).attr('checked')=='checked'){$('#sbmt1').attr('disabled',false)}else{$('#sbmt1').attr('disabled',true)}" />Я соглашаюсь на хранение и обработку моих персональных данных, необходимых для выполнения заказов</label></div>
				<div class="button_block one_more"><input type="submit" class="is_button2" value="Сохранить" id="sbmt1" disabled /><input type="reset" class="is_button2 is_light" value="Отменить" /> </div>
				<input type="hidden" name="id" value="<?=$adds['id']?>" />
			</form>
			<script>
				function checkFizForm(){
					var f=0
					$('#fizform .required').each(function(){
						if (jQuery.trim($(this).val())==''){
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
		</div>
		<div class="block_legal_person <?if($adds['company']!=''):?>act_block<?endif?>">
			<form class="cabinet_form" action="/cabinet/adds/save/" method="post" id="yurform" onsubmit="return checkYurForm()">
				<div class="form_block">
					<div class="param_name">Название</div>
					<div><input type="text" class="text required" name="title" value="<?=$adds['title']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Имя получателя</div>
					<div><input type="text" class="text required" name="name" value="<?=$adds['name']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Email</div>
					<div><input type="text" class="text required" name="email" value="<?=$adds['email']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Номер телефона</div>
					<div><input type="text" class="text required" name="phone" value="<?=$adds['phone']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Адрес доставки</div>
					<div><textarea class="height92 required" name="address"><?=$adds['address']?></textarea></div>
				</div>
				<div class="form_note with_bottom_border">Укажите, пожалуйста, полный адрес с индексом.</div>
				<div class="form_block">
					<div class="param_name">Наименование организации</div>
					<div><input type="text" class="text required" name="company" value="<?=$adds['company']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">ИНН</div>
					<div><input type="text" class="text" name="inn" value="<?=$adds['inn']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">КПП</div>
					<div><input type="text" class="text" name="kpp" value="<?=$adds['kpp']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">ОКПО</div>
					<div><input type="text" class="text" name="okpo" value="<?=$adds['okpo']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Банк</div>
					<div><input type="text" class="text" name="bank" value="<?=$adds['bank']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Расчетный счет</div>
					<div><input type="text" class="text" name="rs" value="<?=$adds['rs']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">Корреспондентский счет</div>
					<div><input type="text" class="text" name="ks" value="<?=$adds['ks']?>" /></div>
				</div>
				<div class="form_block">
					<div class="param_name">БИК</div>
					<div><input type="text" class="text" name="bik" value="<?=$adds['bik']?>" /></div>
				</div>
				<div class="form_block with_bottom_border">
					<div class="param_name">Юридический адрес</div>
					<div><textarea class="height92" name="yura"><?=$adds['yura']?></textarea></div>
				</div>
				<div class="form_note note2">Для изменения данных заполните поля и нажмите кнопку «Сохранить»</div>
				<div class="i_agree"><label><input type="checkbox" onchange="if($(this).attr('checked')=='checked'){$('#sbmt2').attr('disabled',false)}else{$('#sbmt2').attr('disabled',true)}" />Я соглашаюсь на хранение и обработку моих персональных данных, необходимых для выполнения заказов</label></div>
				<div class="button_block one_more"><input type="submit" class="is_button2" value="Сохранить" id="sbmt2" disabled /><input type="reset" class="is_button2 is_light" value="Отменить" /> </div>
				<input type="hidden" name="id" value="<?=$adds['id']?>" />
			</form>
			<script>
				function checkYurForm(){
					var f=0
					$('#yurform .required').each(function(){
						if (jQuery.trim($(this).val())==''){
							$(this).css('border','solid 1px red');
							f=1;
						}else{
							$(this).css('border','');
						}
					});
					if (f==1){
						document.location.href="#";
						return false;
					}else return true;
				}
			</script>
		</div>
	</div></div></div>
</div></div></div>