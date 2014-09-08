<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Статусы</h1>
							</div>
						</div>
						<table class="sections_table jsMoveContainerTR" tab="iusers_status" page="<?=$_GET['p']?>">
							<tr class="sections_table_caption_row jsMoveFixed">
								<th class="sections_table_cell">
									<div class="sections_table_caption-holder jsFixedY">
										<span class="sections_table_caption">Название</span>
									</div>
								</th>
								<th class="sections_table_cell">
									<div class="sections_table_caption-holder jsFixedY">
										<span class="sections_table_caption">Краткое название</span>
									</div>
								</th>
								<th class="sections_table_cell">
									<div class="sections_table_caption-holder jsFixedY">
										<span class="sections_table_caption">Скидка</span>
									</div>
								</th>
								<th class="sections_table_cell">
									<div class="sections_table_caption-holder jsFixedY">
										<span class="sections_table_caption">Пиктограмма</span>
									</div>
								</th>
								<th class="sections_table_cell">
									<div class="sections_table_caption-holder jsFixedY"></div>
								</th>
								<th class="sections_table_cell">
									<div class="sections_table_caption-holder jsFixedY"></div>
								</th>
							</tr>
							<?foreach($list as $item):?>
								<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
									<td class="sections_table_cell"><?=$item['name']?></td>
									<td class="sections_table_cell"><?=$item['shortname']?></td>
									<td class="sections_table_cell"><?=$item['sale']?></td>
									<td class="sections_table_cell"><img src="/u/images/dealers_status/<?=$item['id']?>.png"></td>
									<td class="sections_table_cell">
										<div class="sections_table_control-panel">
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/editstatus/?id=<?=$item['id']?>" class="icon icon_edit"></a>
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdelstatus/?id=<?=$item['id']?>" onclick="return confirm('Удалить?')" class="icon icon_remove"></a>
										</div>
									</td>
									<td class="sections_table_cell">
										<div class="sections_table_move-panel">
											<input class="sections_input_order input_text" value="<?=$item['num']?>" onblur="if($(this).val()!=<?=$item['num']?>){defineSortNum(<?=$item['id']?>,'dealers_status',$(this).val());}">
											<span class="icon_move jsMoveDrag"></span>
										</div>
									</td>
								</tr>
							<?endforeach?>
						</table>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<tr>
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="name" value="<?=$status['name']?>"></div></td>
									</tr>
									<tr>
										<td>Краткое название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="shortname" value="<?=$status['shortname']?>"></div></td>
									</tr>
									<tr>
										<td>Скидка %</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="sale" value="<?=$status['sale']?>"></div></td>
									</tr>
									<tr>
										<td>Пиктограмма</td>
										<td>
											<?if($status):?><img src="<?=UPLOAD_DIR.'images/dealers_status/'.$status['id']?>.png"><?endif?>
											<div class="input_text_holder"><input type="file" class="input_text required" name="icon" value=""></div></td>
									</tr>
								</table>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="id" value="<?=$status['id']?>" />
					<span class="button button_save" onclick="checkform();">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	function checkform(o){
		var f=0
		$('#frm input:text').each(function(){
			if($(this).attr('name')=='login'){
				if (jQuery.trim($(this).val())==''){
					$(this).css('border','solid 1px red');
					f=1;
				}else{
					$(this).css('border','');
				}
			}
		});
		if (f==1){
			$('.error').text('Не все поля заполнены');
			 return false;
		}else{
			$('#frm').submit();
		}
	}
</script>
