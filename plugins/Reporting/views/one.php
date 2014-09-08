<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">	
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					<?=$name?>
				</h1><br><br>
				<form method="post">
					<b>Баланс &mdash; <?=number_format($balance,0,'',' ')?> Р</b><br>
					<b>Запрос на вывод &mdash; <?=number_format($amount,0,'',' ')?> Р</b><br>
					<b>Остаток на балансе после вывода &mdash; <?=number_format($balance-$amount,0,'',' ')?> Р</b><br><br>
					<span class="button" onClick="$(this).parent().submit();">Подтвердить</span> &nbsp; &nbsp; &nbsp;
					<a class="button" href="/<?=Funcs::$cdir?>/requests/">Отмена</a>
					<input type="hidden" name="id" value="<?=Funcs::$uri[2]?>">
					<input type="hidden" name="amount" value="<?=$amount?>">
				</form>
			</div>
		</div>
	</div>
</div>