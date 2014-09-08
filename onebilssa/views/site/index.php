<!--style>
.ltContainer {width: 386px !important;}
</style-->
<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" id="frm" action="/<?=Funcs::$cdir?>/tree/add">
		<div class="ltContainer ltFullWidth sizeChild">
			<?if($countTree==0):?>
				<div class="ltRow jsScrollContainer">
					<div class="jsScrollWrapper">
						<div class="jsScroll whiteOverflow edit_container">
							<div class="ltRow">
								<div class="ltCell cell_page-content_header">
									<h1 class="cell_page-content_header_text">Не создана главная страница сайта</h1>
								</div>
							</div>
							<ul class="edit_form_layout jsMoveContainerLI">
								<li class="edit_form_section jsMoveFixed">
									<table class="edit_form_table">
										<tr>
											<td>Название</td>
											<td><div class="input_text_holder"><input type="text" class="input_text" name="name" value="<?=SITE_NAME?>"></div></td>
										</tr>
									</table>
								</li>
							</ul>
							<input type="hidden" name="path" value="index">
							<input type="hidden" name="seo_title">
							<input type="hidden" name="seo_keywords">
							<input type="hidden" name="seo_description">
							<input type="hidden" name="parent" value="0">
							<input type="hidden" name="id" value="0">
						</div>
					</div>
				</div>
				<div class="ltRow">
					<div class="edit_footer">
						<span class="button button_save" onclick="$('#frm').submit()">Добавить</span>
					</div>
				</div>
			<?else:?>
				<div class="ltRow jsScrollContainer">
					<div class="jsScrollWrapper">
						<div class="jsScroll whiteOverflow edit_container">
							<div class="ltRow">
								<div class="ltCell cell_page-content_header">
									<?=$version?>
									<br /><br />
									Элементов дерева <?=$countTree?>
									<br /><br />
								</div>
							</div>
						</div>
					</div>
				</div>
			<?endif?>
		</div>
	</form>
</div>