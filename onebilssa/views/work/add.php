<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow jsScrollContainer">
			<div class="link_step_back_holder">
				<a class="link_step_back" href="/<?=Funcs::$cdir?>/work/<?=$row['parent']?>/"></a>
			</div>
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow edit_container">
					<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/work/<?=$path?>/" id="frm" onsubmit="return checkform();">
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<tr>
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" value="<?=$row['name']?>" name="name"></div></td>
									</tr>
									<tr>
										<td>Дата</td>
										<td><div class="widget_time input_text_holder"><input type="text" class="input_text" value="<?=date('d.m.Y H:i',strtotime($row['udate']))?>" name="udate"></div></td>
									</tr>
									<tr>
										<td>Путь</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" value="<?=$row['path']?>" name="path"></div></td>
									</tr>
									<tr>
										<td>Title</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" value="<?=$row['seo_title']?>" name="seo_title"></div></td>
									</tr>
									<tr>
										<td>Description</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" value="<?=$row['seo_description']?>" name="seo_description"></div></td>
									</tr>
									<tr>
										<td>Keywords</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" value="<?=$row['seo_keywords']?>" name="seo_keywords"></div></td>
									</tr>
									<?if($row['parent']!=0):?>
										<tr>
											<td>Сменить родителя</td>
											<td>
												<span class="button-white uploadtree" onclick="setTreeHere()">Загрузить карту сайта</span>
												<div id="treehere">
													<input type="hidden" name="parent" value="<?=$row['parent']?>" />
												</div>
												<script>
													function setTreeHere(){
														$('.uploadtree').html('<img src="'+onessapath+'i/wait18.gif" style="position: relative; margin: 0 0 -4px;" />').removeClass('pseudo');
														$.ajax({
															type: "GET",
															url: onessapath+"fields/gettree/",
															data: "parent=<?=$row['parent']?>&id=<?=$row['id']?>",
															success: function(msg){
																$('.uploadtree').detach();
																$('#treehere').html(msg);
																cuSel({
																	changedEl: "#treehere select",
																	visRows: 8,
																	scrollArrows: true
																});
															}
														});
													}
												</script>
											</td>
										</tr>
									<?else:?>
										<tr style="display:none">
											<td colspan="3"><input type="hidden" name="parent" value="<?=$row['parent']?>" /></td>
										</tr>
									<?endif?>
								</table>
							</li>
							<?if($_GET['tree']!='new' && $module['type']=='struct'):?>
								<li class="edit_form_section jsMoveFixed jsSlideInfoContainer edit_form_section_other edit_form_section_row">
									<header class="edit_form_section_header">
										<strong><a href="javascript:;" class="jsSlideInfoToggle">Поля характеристик раздела</a></strong>
									</header>
									
									<div class="jsSlideInfoContent">
										<section class="features_section">
											<header class="features_section_header">Группы характеристик:</header> 
											<ul class="features_group_list" id="groupFeatures">
												<?=View::getRenderEmpty('fields/groupfeatureslist')?>
											</ul>
											<div class="features_group_add">
												<div class="inline-label">Имя <input class="input_text" type="text" id="groupFeaturesName" /></div>
												<div class="inline-label">Алиас <input class="input_text" type="text" id="groupFeaturesPath" /></div>
												<div class="inline-label">
													<span class="button-white" id="groupFeaturesButton" onclick="addFeaturesGroup(0)">Добавить</span>
													<span class="button-white" id="groupFeaturesCancel" style="display:none;" onclick="cancelFeaturesGroup();">Отменить</span>
												</div>
											</div>
										</section>
										<section class="features_section">
											<header class="features_section_header">Поля характеристик раздела:</header>
											<div class="features_table_layout jsScrollContainer">
												<div class="jsScrollWrapper">
													<div class="jsScroll">
														<div class="features_table_pane">
															<table class="features_table" id="featuresset">
																<?foreach($features as $item):?>
																	<?FeaturesWidget::set($item);?>
																<?endforeach?>
															</table>
														</div>
													</div>
												</div>
											</div>
											<a class="button-white" href="javascript:;" onclick="addFeaturesRow()">Добавить</a>
										</section>
										<script>
											var numFeatures=<?=count($features)+1?>;
											var ftree=<?=$_GET['id']?>;
											function addFeaturesGroup(id){
												var fname=$('#groupFeaturesName').val();
												var fpath=$('#groupFeaturesPath').val();
												if(jQuery.trim(fname)!=''){
													$.ajax({
														type: "POST",
														url: path+"fields/setfeaturesgroup/",
														data: "name="+fname+"&path="+fpath+"&tree="+ftree,
														success: function(msg){
															$("#groupFeatures").html(msg);
														}
													});
												}
											}
											function showeditFeaturesGroup(id,fname,fpath){
												$('#groupFeaturesName').val(fname);
												$('#groupFeaturesPath').val(fpath);
												$('#groupFeaturesButton').val('Сохранить').attr('onclick','editFeaturesGroup('+id+')');
												$('#groupFeaturesCancel').show();
											}
											function cancelFeaturesGroup(){
												$('#groupFeaturesName').val();
												$('#groupFeaturesPath').val();
												$('#groupFeaturesButton').val('Добавить').attr('onclick','addFeaturesGroup(0)');
												$('#groupFeaturesCancel').hide();
											}
											function editFeaturesGroup(id){
												var fname=$('#groupFeaturesName').val();
												var fpath=$('#groupFeaturesPath').val();
												if(jQuery.trim(fname)!=''){
													$.ajax({
														type: "POST",
														url: path+"fields/setfeaturesgroup/",
														data: "name="+fname+"&path="+fpath+"&tree="+ftree+"&id="+id,
														success: function(msg){
															$("#groupFeatures").html(msg);
														}
													});
												}
											}
											function delFeaturesGroup(id){
												if(confirm("Удалить группу?")){
													$.ajax({
														type: "POST",
														url: path+"fields/delfeaturesgroup/",
														data: "tree="+ftree+"&id="+id,
														success: function(msg){
															$("#groupFeatures").html(msg);
														}
													});
												}
											}
											function addFeaturesRow(){
												var type=$('#FeaturesFieldList option:selected').val();
												$.ajax({
													type: "POST",
													url: path+"fields/addfeatures/",
													data: "tree="+ftree+"&num="+numFeatures,
													success: function(msg){
														numFeatures++;
														$("#featuresset").append(msg);
														defineSortFeatures();
														resizeContent();
													}
												});
											}
											$(document).ready(function(){
												defineSortFeatures();
											});
										</script>
									</div>
								</li>
							<?endif?>
							<?if($_GET['tree']!='new' && $module['type']=='cat' && count($features)>0):?>
								<li class="edit_form_section edit_form_section_chars jsMoveFixed">
									<table class="edit_form_table">
										<tr>
											<td colspan="2"><strong>Характеристики</strong></td>
										</tr>
										<?foreach($features as $items):?>
											<tr>
												<td colspan="2"><?=$items['name']==''?'Общие':$items['name']?></td>
											</tr>
											<?foreach($items['list'] as $item):?>
												<?FeaturesWidget::run($item);?>
											<?endforeach?>
										<?endforeach?>
									</table>
								</li>
							<?endif?>
							<?foreach($fields as $item):?>
								<?FieldWidget::run($item)?>
							<?endforeach?>
						</ul>
						<?if($_GET['tree']!='new'):?>
							<div class="edit_form_section edit_form_section_other create-additional">
								<table class="edit_form_table">
									<tr>
										<td><strong>Создать дополнительно</strong></td>
										<td>
											<select class="jsSelectStyled" id="FieldList" onchange="addRow()">
												<option value=""></option>
												<?foreach(Fields::additional() as $item):?>
													<option value="<?=$item['path']?>"><?=$item['name']?> (<?=$item['path']?>)</option>
												<?endforeach?>
											</select>
										</td>
									</tr>
								</table>
							</div>
						<?endif?>
						<input type="hidden" name="id" value="<?=$row['id']?>" />
						<input type="hidden" name="module" value="<?=$module['id']?>" />
						<input type="hidden" name="tree" value="<?=$row['id']?>" />
						<input type="hidden" name="item" value="<?=$fields[0]['item']?>" />
						<input type="hidden" name="redirect" value="<?=$_SESSION['HTTP_REFERER']?>" />
					</form>
				</div>
			</div>
		</div>
		<div class="ltRow">
			<div class="edit_footer">
				<span class="button button_save" onclick="$('#frm').submit()">Сохранить</span>
				<span class="edit_changes">Последние изменения внесены <?=date('H:i d.m.Y',strtotime($row['mdate']))?><?if($user['login']):?>, под логином <?=$user['login']?><?endif?></span>
			</div>
		</div>
	</div>
</div>
<script>
	function checkform(o){
		var f=0
		$('#frm input:text').each(function(){
			if($(this).attr('name')=='name'){
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
		}else return true;
	}
	var path="/<?=Funcs::$cdir?>/";
	function addRow(){
		var type=$('#FieldList').val();
		$.ajax({
			type: "POST",
			url: path+"work/addfield/",
			data: "<?=$_SESSION['getstr']?>&type="+type,
			success: function(msg){
				$(".edit_form_layout").append(msg);
				$('#cusel-scroll-FieldList span').removeClass('cuselActive').first().addClass('cuselActive');
				$("#cuselFrame-FieldList .cuselText").text('');
				$("#FieldList").val('');
				defineSort();
				resizeContent(); 
			}
		});
	}
</script>