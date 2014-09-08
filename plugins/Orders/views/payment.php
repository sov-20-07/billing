<header class="edit_form_section_header">
	<strong>Оплата <?=$payment ?></strong>
</header>
<table class="edit_form_table plugin_orders_custom-table">
	<tr>
		<td>Способы оплаты:</td>
		<td>
			<ul>
			<?foreach(Payment::$payments as $item):?>
				<li>
					<label class="form_label">
						<input type="radio" name="payment" value="<?=$item?>" <?if($payment==$item):?>checked<?endif?> /> <?=$item?>
					</label>
				</li>
			<?endforeach?>
			</ul>
		</td>
	</tr>
	<tr>
		<td>Счет на оплату</td>
		<td>
			<?if($filename):?>Добавлен счет <a href="/<?=Funcs::$cdir?>/orders/files/<?=Funcs::$uri[3]?>/<?=$filename?>"><?=$filename?></a><br /><?endif?>
			<a href="javascript:;" onclick="$('#upload').click();">Добавьте счет</a><input type="file" id="upload" name="upload"  style="display:none;" />
		</td>
	</tr>
	<tr>
		<td>Счет отправить письмом</td>
		<td>
			<label class="label_radio ">
				<input type="checkbox" name="sendfile" value="1" />
			</label>
		</td>
	</tr>
	<tr>
		<td>Оплачено</td>
		<td><input type="checkbox" name="paid" value="1" <?if($paid==1):?>checked<?endif?> /></td>
	</tr>
</table>

				