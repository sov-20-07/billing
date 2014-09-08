<div class="ltRow">
	<div class="cell_page-content_control-panel">		
		<div class="jsTabs">
			<form>
				От&nbsp; <div class="input_text_label widget_time"><input type="text" name="from" class="input_text" style="width:150px;" value="<?=$_GET['from']?>" /></div>
				до&nbsp; <div class="input_text_label widget_time"><input type="text" name="to" class="input_text" style="width:150px;" value="<?=$_GET['to']?>" /></div>
				<div class="input_text_label"><input type="text" name="number" placeholder="Номер заказа" class="input_text" value="<?=$_GET['number']?>" /></div>
				<div class="input_text_label"><input type="text" name="phone" placeholder="Телефон" class="input_text" value="<?=$_GET['phone']?>" /></div>
				<div class="input_text_label"><input type="text" name="fio" placeholder="ФИО" class="input_text" value="<?=$_GET['fio']?>" /></div>
				<input type="hidden" name="status" value="<?=$_GET['status']?>" />
				<span class="button-white"onClick="$(this).parent().submit();">Найти</span>
			</form>
			<a class="button" href="/<?=Funcs::$cdir?>/orders/export/<?=Funcs::getFG(NULL,'?');?>">Экспорт</a>
		</div>
	</div>
</div>

