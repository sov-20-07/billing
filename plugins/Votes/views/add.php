<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Опрос</h1>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								Вопрос<div class="input_text_holder"><textarea class="input_text sethere" name="description"><?=$description?></textarea></div></td>
							</li>
							<li class="edit_form_section jsMoveFixed" id="divSetHere">
								<?if(!empty($list)):?>
									<?foreach($list as $item):?>
										<div style="margin-bottom: 5px;">
											<input type="text" class="input_text" placeholder="Вариант ответа" name="descriptions[]" value="<?=$item['description']?>">
											<input type="text" class="input_text answers" placeholder="кол-во ответов (число)" name="answers[]" value="<?=$item['answers']?>">
											<input type="text" class="input_text num" placeholder="Сортировка (число)" name="num[]" value="<?=$item['num']?>">
											<a href="javascript:;" onclick="if(confirm('Удалить ответ?')){$(this).parent().detach();}" title="Удалить">[x]</a>
										</div>
									<?endforeach?>
								<?endif?>
								<a href="javascript:;" onclick="addNewDiv()">Добавить вариант ответа +</a>
								<div id="takeMe" style="display:none;margin-bottom: 5px;">
									<input type="text" class="input_text" placeholder="Вариант ответа" name="descriptions[]" value="">
									<input type="text" class="input_text answers" placeholder="кол-во ответов (число)" name="answers[]" value="0">
									<input type="text" class="input_text num" placeholder="Сортировка (число)" name="num[]" value="">
									<a href="javascript:;" onclick="if(confirm('Удалить ответ?')){$(this).parent().detach();}" title="Удалить">[x]</a>
								</div>
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
<script>
	var count=<?=$item['num']==''?'10':$item['num']+10?>;
	function addNewDiv(){
		$('#takeMe').clone().attr('id','').prependTo('#divSetHere').show().find('.num').val(count);
		count=count+10;
	}
</script>