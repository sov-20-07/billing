<div class="ltRow">
	<div class="cell_page-content_control-panel">		
		<div class="jsTabs">
			<form>
				Поиск пользователя
				<div class="input_text_label"><input type="text" name="q" placeholder="Имя" class="input_text" value="<?=$_GET['q']?>" /></div>
				Сумма покупок
				<div class="input_text_label"><input type="text" name="from" placeholder="от" class="input_text" value="<?=$_GET['from']?>" /></div>
				<div class="input_text_label"><input type="text" name="to" placeholder="до" class="input_text" value="<?=$_GET['to']?>" /></div>
				<span class="button-white"onClick="$(this).parent().submit();">Показать</span>
			</form>
			<a class="button" href="/<?=Funcs::$cdir?>/orders/export/<?=Funcs::getFG(NULL,'?');?>">Экспорт</a>
		</div>
	</div>
</div>

