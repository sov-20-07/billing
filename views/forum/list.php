<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<script type="text/javascript" src="/js/editor/editor.js"></script>
		<link rel="stylesheet" href="/js/editor/css/editor.css" type="text/css" />
		<div class="head1"><?=$name?></div>
		<div class="forum">
			<a href="/help/forum/" class="icon back_to auto_icon">Вернуться к списку тем</a>
			<table class="default messages">
				<col><col width="100%">
				<?foreach($list as $i=>$item):?>
					<tr class="<?if($i==0):?>act_theme theme_head<?endif?>">
						<td colspan="2"><?=$item['name']?></td>
					</tr>
					<tr class="act_theme">
						<td class="upic"><?if($item['author']['avatar']):?><img src="<?=$item['author']['avatar']?>" /><?endif?></td>
						<td>
							<?if($_SESSION['user']):?>
								<a href="?act=del&id=<?=$item['id']?>" onclick="return confirm('Удалить?')" style="float:right;" title="Удалить">[X]</a>
							<?endif?>
							<span id="user<?=$item['id']?>"><?=$item['author']['name']?></span> <?=$item['cdatewide']?><br />
							<div class="message_text" id="txt<?=$item['id']?>">
								<?=$item['message']?>
							</div>
						</td>
					</tr>
					<tr class="act_theme">
						<td colspan="2" class="comment_link"><span class="pseudo pseudo_gray" onclick="quoteit(<?=$item['id']?>)">Цитировать</span></td>
					</tr>
				<?endforeach?>
			</table>
			<?if($_SESSION['iuser']['id']):?>
				<form action="" method="post" id="frm">
					<div class="is_black">Написать</div>
					<textarea name="message" class="forum_text required" id="editor" style="width: 100%;height: 200px;"></textarea>
					<br/><br/>
					<input type="hidden" name="cap_check" value="no" id="cap_check"/>
					<span onclick="checkForm()" class="is_button right_top_corner">Отправить<span></span></span>
					<script>
						$(document).ready(function(){
							redactor = $('#editor').editor();
							$("#cap_check").val("yes");
						});
						function quoteit(id){
							html=$("#txt"+id).html();
							redactor.execCommand('inserthtml', '<div style="color:#666;background-color:#f7fffb; font-size:10px; border:solid 1px #E0ECF8; padding:5px"><b style="color:#5579B4; font-size:11px">'+$("#user"+id).html()+' писал: </b><br/>'+html+'</div><br/>');
						}
						<?if($_POST):?>alert('Ошибка ввода символов с картинки');<?endif?>
						function checkForm(){
							var f=0;
							$('#frm .required').each(function(){
								if (jQuery.trim($(this).val())==''){
									$(this).css('border','solid 1px red');
									if($(this).hasClass('forum_text')){
										$('.imp_editor_box').css('border','solid 1px red');
									}
									f=1;
								}else{
									$(this).css('border','');
									if($(this).hasClass('forum_text')){
										$('.imp_editor_box').css('border','');
									}
								}
							});
							if (f==1){
								return false;
							}else {
								$('#frm').submit();
							}
						}
					</script>
				</form>
			<?else:?>
				Только зарегистрированные пользователи могут участвовать в форуме<br />
			<?endif?>
			<?/*?>
				<div class="whom" style="padding:0">
					<select id="selectForumRubric" onchange="document.location.href='/<?Funcs::$uri[0]?>/<?Funcs::$uri[1]?>/'+$('#selectForumRubric option:selected').val()+'/'">
					<?foreach($rubrics as $item):?>
						<option value="<?=$item['path']?>" <?if(Funcs::$uri[2]==$item['path']):?>selected<?endif?>>&mdash;<?=$item['name']?></option>
					<?endforeach?>
					</select>
				</div>
			<?*/?>
			<br /><br clear="all" />
			<?PaginationWidget::run()?>
		</div>		
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>