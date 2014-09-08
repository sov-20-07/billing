<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?if($parent!=0):?><?=$parent?>/<?endif?>"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
							<div class="ltRow">
								<div class="ltCell cell_page-content_header">
									<h1 class="cell_page-content_header_text"><?=$title?></h1>
								</div>
							</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<tr>
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="name" value="<?=$name?>"></div></td>
									</tr>
									<tr>
										<td>Алиас</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="path" value="<?=$path?>"></div></td>
									</tr>
									<?if($parent):?>
										<tr>
											<td>Дата начала</td>
											<td>
												<div class="widget_time input_text_holder"><input type="text" class="input_text" value="<?=$bdate==''?date('d.m.Y H:i:s'):date('d.m.Y H:i:s',strtotime($bdate))?>" name="bdate"></div>
												<script>
												$('input:[name=bdate]').datetimepicker({
													dateFormat: 'dd.mm.yy',
													timeFormat: 'hh:mm:ss',
													separator: ' '
												});
												</script>
											</td>
										</tr>
										<tr>
											<td>Дата окончания</td>
											<td>
												<div class="widget_time input_text_holder"><input type="text" class="input_text" value="<?=$edate==''?date('d.m.Y H:i:s',strtotime('+1 month')):date('d.m.Y H:i:s',strtotime($edate))?>" name="edate"></div>
												<script>
												$('input:[name=edate]').datetimepicker({
													dateFormat: 'dd.mm.yy',
													timeFormat: 'hh:mm:ss',
													separator: ' '
												});
												</script>
											</td>
										</tr>
										<tr>
											<td>
												<label><input type="radio" name="type" value="editor" <?if($type=='editor' || $type==''):?>checked<?endif?>> редактор</label><br><br>
												<label><input type="radio" name="type" value="text" <?if($type=='text'):?>checked<?endif?>> текст</label>
											</td>
											<td <?if($type=='text'):?>style="display:none;"<?endif?> class="editored">
												<textarea name="description" id="editor" <?if($type=='text'):?>disabled<?endif?>><?=$description?></textarea>
												<script language="javascript">
													$(document).ready( function(){	
														initEditor($("#editor"));
														$('.iradio').on('ifChecked',function(){
															if($(this).find('input').val()=='editor'){
																$('.texted').hide().find('textarea').prop('disabled',true);$('.editored').show();
															}else{
																$('.editored').hide().prop('disabled',true);$('.texted').show().find('textarea').prop('disabled',false);
															}
														});
													});
												</script>
											</td>
											<td <?if($type=='editor' || $type==''):?>style="display:none;"<?endif?> class="texted">
												<div class="input_text_holder"><textarea <?if($type=='editor' || $type==''):?>disabled<?endif?> class="input_text" name="description" style="height:300px;"><?=$description?></textarea></div>
											</td>
										</tr>
									<?endif?>
								</table>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="id" value="<?=$id?>" />
					<input type="hidden" name="parent" value="<?=$parent?>" />
					<span class="button button_save" onclick="$('#frm').submit()">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>