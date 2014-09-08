<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Склад
				</h1>
				<br><br><br>
				<form method="POST" id="importForm" enctype="multipart/form-data" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/import/">
					<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/export/" class="button-white">Экспорт</a>
					<span class="button-white" id="importButton" onclick="$('#upload').click();">Импорт</span>
					<img class="imgwait" src="/<?=Funcs::$cdir?>/i/wait18.gif" style="display:none;">
					<input type="file" name="upload" id="upload" style="display: none;" onchange="$('#importButton').hide();$('.imgwait').show();$('#importForm').submit();">
				</form>
				<br><br><br>
				<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/recalculate/" class="button">Привести цены к рублям</a>
			</div>
		</div>
	</div>
</div>