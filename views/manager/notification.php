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
		<h1>Уведомления и рассылка</h1>
		<form class="cabinet_form" action="/cabinet/notification/" method="post">
			<label class="actions_subscribe"><input type="checkbox" name="notify" value="1" <?=$notify?> />Уведомлять меня о специальных акциях, скидках и изменениях в работе WOMEN MARKET.</label>
			<div class="font_14"><b>Я хочу получать информацию о новинках из следующих категорий</b></div>
			<div class="mailing_shifts"><table class="default mailing_list">
				<col width="25%"><col width="25%"><col width="25%"><col width="25%">
				<tr>
				<?foreach($tree as $list):?>
					<td>
						<?foreach($list as $items):?>
							<label><input type="checkbox" name='trees[]' value="<?=$items['id']?>" <?=$items['checked']?> /><b><?=$items['name']?></b></label>
							<?foreach($items['sub'] as $item):?>
                                <label><input type="checkbox" name='trees[]' value="<?=$item['id']?>" <?=$item['checked']?> /><?=$item['name']?></label>
							<?endforeach?>
						<?endforeach?>
					</td>
				<?endforeach?>
					<td></td>
				</tr>
			</table></div>
			<div class="subscribe_buttons"><input type="submit" class="is_button2" value="Применить" /><input type="submit" class="is_button2 is_light" value="Отмена" /></div>
		</form>
	</div></div></div>
</div></div></div>