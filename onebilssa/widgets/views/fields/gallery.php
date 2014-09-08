<li class="edit_form_section edit_form_section_gallery">
	<?=View::widget('fields/addtd')?>
	<header class="edit_form_section_header">
		<?if($name):?>
			<strong><?=$name?></strong>
		<?else:?>
			<div class="new-field_layout">
				<span class="new-field_name">Имя галереи (только транслит)</span>
				<input type="text" class="input_text" onfocus="$(this).next().fadeIn(400);" onblur="$(this).next().fadeOut(400);" onkeyup="keypressMe($(this))" name="galname[<?=$path?>]" />
				<div style="position:absolute;display:none;background: #FFFFFF;border:1px solid #999999;padding:3px;">
					<?foreach($select as $item):?>
						<a href="javascript:;" onclick="selectMe($(this))"><?=$item?></a><br />
					<?endforeach?>
				</div>
			</div>
		<?endif?>
	</header>
	<ul class="gallery_list jsMoveContainerLI_inner gallery <?=$path?>" data-listidx="0" id="<?=$path?>" datagal="<?=$id?>">
		<?foreach($files as $item):?>
			<?=View::widget('/fields/gallery_one',array('file'=>$item, 'parent'=>$id))?>
		<?endforeach?>
	</ul>
	<div class="gallery_addfiles">
		Добавить один или несколько файлов:
		<div class="gallery_addfiles_buttons">
			<iframe iframe src="/<?=ONESSA_DIR?>/fields/fileframe/?id=<?=$tree?>&path=<?=$path?>&parent=<?=$id?>" style="width:180px; height: 33px;"></iframe>
			<span class="button-white" onclick="openCKFinderForGal<?=$path?>()">Загрузить из галереи</span>
		</div>											
	</div>
	<input type="hidden" class="sethere" value="<?=$value?>" name="data[<?=$path?>]">
	<input type="hidden" value="gallery" name="fieldtypes[]">
</li>
<script type="text/javascript">
	var upload<?=$path?>;
	$(document).ready(function() {
		$("#<?=$path?>").dragsort({ dragSelector: ".jsMoveDragInner", dragBetween: false, dragEnd: function(){saveOrder<?=$path?>();},placeHolderTemplate: "<li style='height: 10px; background: #ccc;'></li>" }); 
	});
	function uploadSuccess<?=$path?>(o, str, resp){
		$("#<?=$path?>").append(str);
		resizeContent();
	}
	var queueComplete = function (file, server_data, receivedResponse) {
		$('#fsUploadProgress<?=$path?>').html('<span class="legend">Выберите один или несколько файлов</span>');
	};
	function saveOrder<?=$path?>() {
		var data = $(".gallery.<?=$path?> li").map(function(){return $(this).attr('ids'); }).get();
		$.ajax({
			type: "POST",
			url: onessapath+"fields/orderfile/",
			data: "ids="+data,
			success: function(msg){resizeContent();}
		});
	};
	function removeFile<?=$id?>(obj,id){
		$.ajax({
			type: "POST",
			url: onessapath+"fields/removefile/",
			data: "id="+id+"&data=<?=$id?>",
			success: function(msg){
				obj.parent().parent().detach();
				resizeContent();
			}
		});
	}
	function editFile<?=$id?>(id){
		$.ajax({
			type: "POST",
			url: onessapath+"fields/editfile/",
			data: "id="+id+"&data=<?=$id?>"+"&name="+$('#name'+id).val()+"&dop="+$('#dop'+id).val(),
			success: function(msg){}
		});
	}
	function openCKFinderForGal<?=$path?>(){
		var finder = new CKFinder();
		finder.basePath = '/ckfinder/';
		finder.selectActionData = "hiddenFieldForCKFinder<?=$path?>";
		finder.selectActionFunction = function( fileUrl, data ) {
			$.ajax({
				type: "GET",
				url: onessapath+"fields/ckfinderupload/",
				data: "filepath="+fileUrl+"&<?=$_SESSION['getstr']?>&path=<?=$path?>",
				success: function(msg){
					$("#<?=$path?>").append(msg);
					resizeContent();
				}
			});
		}
		finder.popup();
	}
	function removeGallary(){
		$.ajax({
			type: "POST",
			url: onessapath+"fields/removegallery/",
			data: "id=<?=$id?>",
			success: function(msg){resizeContent();}
		});
	}
</script>	
<?/* ?>


<tr>
	<td colspan="2">
		
		<ul class="gallery <?=$path?>" data-listidx="0" id="<?=$path?>" datagal="<?=$id?>">
			<?foreach($files as $item):?>
				<?=View::widget('/fields/gallery_one',array('file'=>$item, 'parent'=>$id))?>
			<?endforeach?>
		</ul>
		<br style="clear: both" />
		<script type="text/javascript">
			var upload<?=$path?>;
			$(document).ready(function() {
				$("#<?=$path?>").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder<?=$path?>, placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });
				upload<?=$path?> = new SWFUpload({
					flash_url : "/<?=Funcs::$cdir?>/js/swfupload.swf",			
					upload_url: "/<?=Funcs::$cdir?>/fields/multiupload/?<?=$_SESSION['getstr']?>&path=<?=$path?>",
					post_params: {"PHPSESSID" : "<?=session_id()?>"},
		
					// File Upload Settings
					file_size_limit : "100 MB",	// 100MB
					file_types : "*.*",
					file_types_description : "All Files",
					file_upload_limit : 0,
					file_queue_limit : 0,
		
					// Event Handler Settings (all my handlers are in the Handler.js file)
					file_queued_handler : fileQueued,
					file_queue_error_handler : fileQueueError,
					file_dialog_complete_handler : fileDialogComplete,
					upload_start_handler : uploadStart,
					upload_progress_handler : uploadProgress,
					upload_error_handler : uploadError,
					upload_success_handler : uploadSuccess<?=$path?>,
					upload_complete_handler : uploadComplete,
					queue_complete_handler : queueComplete,
		
					// Button Settings
					button_image_url : "/<?=Funcs::$cdir?>/js/XPButtonUploadText_61x22.png",
					button_placeholder_id : "spanButtonPlaceholder<?=$path?>",
					button_width: 61,
					button_height: 22,
		
					// Flash Settings
						// Relative to this file (or you can use absolute paths)
						
					//swfupload_element_id : "flashUI<?=$path?>",		// Setting from graceful degradation plugin
					//degraded_element_id : "degradedUI<?=$path?>",		// Setting from graceful degradation plugin
		
					custom_settings : {
						progressTarget : "fsUploadProgress<?=$path?>",
						cancelButtonId : "btnCancel<?=$path?>"
					},
						
					// Debug Settings
					debug: false
				});
				upload<?=$path?>.movieName="SWFUpload_<?=$path?>";	
			});
			function uploadSuccess<?=$path?>(o, str, resp){
				$("#<?=$path?>").append(str);
			}
			var queueComplete = function (file, server_data, receivedResponse) {
				$('#fsUploadProgress<?=$path?>').html('<span class="legend">Выберите один или несколько файлов</span>');
			};
			function saveOrder<?=$path?>() {
				var data = $(".gallery.<?=$path?> li").map(function() { return $(this).children().attr('id'); }).get();
				var datagal =$(".gallery.<?=$path?>").attr("datagal");
				str=data.join("|");
				$.ajax({
					type: "POST",
					url: onessapath+"fields/orderfile/",
					data: "ids="+data+"&data="+datagal,
					success: function(msg){

					}
				});
			};
			function removeFile<?=$id?>(obj,id){
				$.ajax({
					type: "POST",
					url: onessapath+"fields/removefile/",
					data: "id="+id+"&data=<?=$id?>",
					success: function(msg){
						obj.parent().parent().detach();
					}
				});
			}
			function editFile<?=$id?>(id){
				$.ajax({
					type: "POST",
					url: onessapath+"fields/editfile/",
					data: "id="+id+"&data=<?=$id?>"+"&name="+$('#name'+id).val()+"&dop="+$('#dop'+id).val(),
					success: function(msg){

					}
				});
			}
			function openCKFinderForGal<?=$path?>(){
				var finder = new CKFinder();
				finder.basePath = '/ckfinder/';
				finder.selectActionData = "hiddenFieldForCKFinder<?=$path?>";
				finder.selectActionFunction = function( fileUrl, data ) {
					//$('#hiddenFieldForCKFinder<?=$path?>').val(fileUrl);
					//alert(fileUrl);
					$.ajax({
						type: "GET",
						url: onessapath+"fields/multiupload/",
						data: "filepath="+fileUrl+"&<?=$_SESSION['getstr']?>&path=<?=$path?>",
						success: function(msg){
							$("#<?=$path?>").append(msg);
						}
					});
				}
				finder.popup();
			}
			function removeGallary(){
				$.ajax({
					type: "POST",
					url: onessapath+"fields/removegallery/",
					data: "id=<?=$id?>",
					success: function(msg){

					}
				});
			}
		</script>	
		<div>
			<div class="fieldset flash" id="fsUploadProgress<?=$path?>">
				<span class="legend">Выберите один или несколько файлов</span>
			</div>
			<div style="padding-left: 5px;">
				<span id="spanButtonPlaceholder<?=$path?>"></span>
				<input id="btnCancel<?=$path?>" type="button" value="Отмена" onclick="cancelQueue(upload<?=$path?>);" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 8pt;" /><br />
			</div>
		</div>
		<span class="pseudo" style="cursor: pointer;" onclick="openCKFinderForGal<?=$path?>()">Выбрать файл из галереи</span>
		<input type="hidden" value="<?=$value?>" name="data[<?=$path?>]">
		<input type="hidden" value="gallery" name="fieldtypes[]">
	</td>
	<?=View::widget('fields/addtd')?>
</tr>
<?*/?>