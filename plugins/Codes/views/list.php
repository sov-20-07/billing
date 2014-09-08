<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Управление промо-кодами
				</h1>
			</div>
		</div>
		<div class="link_step_back_holder">
			<a class="link_step_back" href="/<?=Funcs::$uri[0]?>/codes/"></a>
		</div>
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				Двойной клик по коду для редактирования
			</div>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="<?=Funcs::$uri[1]?>" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Код</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Дата активации</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Пользователь</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row">
								<td class="sections_table_cell">
									<span class="editable"><?=$item['code']?></span>
									<input class="editcode" type="text" value="<?=$item['code']?>" style="display:none;" ids="<?=$item['id']?>">
								</td>
								<td class="sections_table_cell"><?if($item['edate']!='0000-00-00 00:00:00'):?><?=date('H:i d.m.Y',strtotime($item['edate']))?><?endif?></td>
								<td class="sections_table_cell"><?=$item['iuser']?></td>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/delcode/?id=<?=$item['id']?>&parent=<?=Funcs::$uri[2]?>" onclick="return confirm('Удалить?')" class="icon icon_remove"></a>
									</div>
								</td>
							</tr>
						<?endforeach?>
					</table>
					<script>
						$(document).ready(function(){
							$(".editcode").blur(function(){
								$(this).hide().prev().show().text($(this).val());
								var data="id="+$(this).attr('ids');
								data+="&code="+$(this).val();
								$.ajax({
									type: "POST",
									url: onessapath+"codes/editstr/",
									data: data,
									success: function(msg){
						
									}
								});
							});
						});
					</script>
				</div>
			</div>
		</div>
		<div class="ltRow">
			<div class="sections_footer clearfix">
				<?=PaginationWidget::run($pagination)?>
			</div>
		</div>
	</div>
</div>