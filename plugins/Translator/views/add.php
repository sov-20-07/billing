<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=Funcs::$uri[2]?>/<?if(Funcs::$uri[3]):?><?=Funcs::$uri[3]?>/<?endif?>" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
							<div class="ltRow">
								<div class="ltCell cell_page-content_header">
									<h1 class="cell_page-content_header_text">Перевод</h1>
								</div>
							</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<?foreach(Translator::getLanguage() as $item):?>
										<tr>
											<td><?=$item['name']?></td>
											<td>
												<div class="input_text_holder"><textarea class="input_text" name="translator[<?=$item['value']?>]" style="<?if($item['value']=='he'):?>direction:rtl;<?endif?>"><?=$list[$item['value']]['text']?></textarea></div>
											</td>
										</tr>
									<?endforeach?>
								</table>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<span class="button button_save" onclick="$('#frm').submit()">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>