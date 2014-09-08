<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/sql/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Выполнить SQL запрос:</h1>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table width="100%">
									<tr>
										<td>
											Префикс таблиц: <b><?=BDPREFIX?></b> | без префикса <b>{{table_name}}</b> | <a href="http://dev.mysql.com/doc/" target="_blank">Документация</a>
											<div class="input_text_holder"><textarea class="input_text" name="query" id="query"><?=$_POST['query']?></textarea></div><br>
											<span class="button button_save" onclick="if(jQuery.trim($('#query').val())!=''){if(confirm('Выполнить запрос?')==true){$('#frm').submit()}}">Выполнить</span>
										</td>
										<td style="padding-left: 10px;">
											<b>Перечень таблиц:</b><br>
											<?foreach($tables as $i=>$item):?>
												<?if($i<7):?>
													<?=$item?><br>
												<?endif?>
											<?endforeach?>
											<div style="display: none;">
												<?foreach($tables as $i=>$item):?>
													<?if($i>=7):?>
														<?=$item?><br>
													<?endif?>
												<?endforeach?>
											</div>
											<a href="javascript:;" onclick="$(this).prev().toggle();resizeContent();">...</a>
										</td>
									</tr>
									<?if(!empty($list)):?>
										<tr>
											<td colspan="2">
												<table class="simplaeTable">
													<tr>
														<?foreach($list[0] as $key=>$item):?>
															<th style="background: #<?if($key=='Ошибка'):?>FF3333<?elseif($key=='Ответ'):?>99FF99<?else:?>EEEEEE<?endif?>"><?=$key?></th>
														<?endforeach?>
													</tr>
													<?foreach($list as $items):?>
														<tr>
															<?foreach($items as $item):?>
																<td><?=$item?></td>
															<?endforeach?>
														</tr>
													<?endforeach?>
												</table>
											</td>
										</tr>
									<?endif?>
								</table>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>