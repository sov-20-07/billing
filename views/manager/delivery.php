<div class="top_block fixed_width">
	<div id="navigation">
		<span class="icon right_arrow"></span><a href="/" class="icon ic_home" title="На главную"></a><span class="icon right_arrow"></span>Ваш кабинет
	</div>
</div>
<div class="content fixed_width"><div class="padds10"><div class="inline_block">
	<div id="left_part"><div class="inline_block"><div class="padds10">
		<?MenuWidget::CabinetMenu()?>
	</div></div></div>
	<div id="right_part"><div class="padds020"><div class="inline_block">
		<h1>Параметры доставки</h1>
		<b class="font_14">Ваши адреса</b>
		<div class="cabinet_addresses inline_block">
			<?foreach($adds as $item):?>
				<div class="float_block"><div class="border_block"><div class="padds">
					<p><b><?=$item['title']?></b></p>
					<p><?=$item['address']?></p>
					<div class="font_11">
						<a href="/cabinet/adds/edit/<?=$item['id']?>/">Изменить</a><br />
						<a href="/cabinet/adds/del/<?=$item['id']?>/" onclick="return confirm('Удалить адрес?')" class="pseudo">Удалить</a>
					</div>
				</div></div></div>
			<?endforeach?>
			<br clear="all" />
		</div>
		<div class="add_address_button"><a href="/cabinet/adds/add/" class="is_button2">Добавить адрес</a></div>
		<form class="set_default_address inline_block border_top" action="/cabinet/delivery/save/" method="post">
			<div class="form_block one_row inline_block float_block2 ip">
				<div class="param_name">Адрес по умолчанию</div>
				<div class="right_param">
					<select name="address">
						<option value="0">выбрать</option>
						<?foreach($adds as $item):?>
							<option value="<?=$item['id']?>" <?if($item['id']==$_SESSION['iuser']['options']['address']):?>selected<?endif?>><?=$item['title']?></option>
						<?endforeach?>
					</select>
				</div>
			</div>
			<div class="form_block one_row inline_block float_block2">
				<div class="param_name font_12">Служба доставки по умолчанию</div>
				<div class="right_param">
					<select name="delivery">
						<option value="0">выбрать</option>
						<?foreach(Funcs::$reference['delivery'] as $item):?>
							<option value="<?=$item['path']?>" <?if($item['path']==$_SESSION['iuser']['options']['delivery']):?>selected<?endif?>><?=$item['name']?></option>
						<?endforeach?>
					</select>
				</div>
			</div>
			<div class="form_note border_top top_space inline_block">Для изменения настроек, выберите желаемые параметры и нажмите кнопку «Сохранить»</div>
			<div class="button_block one_more"><input type="submit" class="is_button2" value="Сохранить" /><input type="reset" class="is_button2 is_light" value="Отменить" /> </div>
		</form>
	</div></div></div>
</div></div></div>