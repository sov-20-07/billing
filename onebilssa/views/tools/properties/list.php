<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
							<div class="ltRow">
								<div class="ltCell cell_page-content_header">
									<h1 class="cell_page-content_header_text">Свойства</h1>
								</div>
							</div>
							<ul class="edit_form_layout jsMoveContainerLI">
							<?foreach($list as $item):?>
								<li class="edit_form_section jsMoveFixed">
									<table class="edit_form_table">
										
											<tr>
												<td><?=$item['name']?></td>
												<td>
													<label><input type="radio" value="0" name="<?=$item['path']?>" <?if($item['value']==0):?>checked<?endif?>> <?=$item['var1']?></label><br><br>
													<label><input type="radio" value="1" name="<?=$item['path']?>" <?if($item['value']==1):?>checked<?endif?>> <?=$item['var2']?></label>
												</td>
											</tr>
										
									</table>
								</li>
							<?endforeach?>
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