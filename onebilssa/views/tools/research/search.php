<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/research/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								Всего записей в дереве: <?=$tree?><br />
								Всего записей в таблице поиска: <?=$search?><br /><br />
								<input type="hidden" name="temp" value="<?=rand(0,1000000)?>" />
								<span class="button" onclick="$('#frm').submit()">Переиндексировать поиск</span>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>