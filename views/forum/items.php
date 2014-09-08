<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1"><?=$name?></div>
		<div class="forum">
			<?if($_SESSION['iuser']['id']):?>
				<a href="#create" class="maketop icon ic_plus auto_icon">Создать топик</a>
			<?else:?>
				Только зарегистрированные пользователи могут участвовать в форуме
			<?endif?>
			<table class="default messages fcategories">
				<col width="270"><col><col width="70">
				<tr><th>Топик</th><th>Последнее сообщение</th><th>Сообщения</th></tr>
				<?foreach($list as $item):?>
					<tr>
						<td><a href="<?=$item['path']?>"><?=$item['name']?></a></td>
						<td>
							<?if($item['count']!=0):?>
								<?=$item['author']['name']?>
								<div class="date_time"><?=$item['cdatewide']?></div>
							<?endif?>
						</td>
						<td><a href="/forum/topic/203/" class="icon ic_message auto_icon light_gray"><?=$item['count']?></a></td>
					</tr>
				<?endforeach?>						
			</table>
			<?if($_SESSION['iuser']['id']):?>
				<a href="#create" class="maketop icon ic_plus auto_icon">Создать топик</a>
			<?else:?>
				Только зарегистрированные пользователи могут участвовать в форуме
			<?endif?>
		</div>
		<?if($_SESSION['iuser']['id']):?>
			<a name="create"></a>
			<div id="makearea" style="display:none">
				<form method="post" id="frm">
					Заголовок<br/>
					<input name="name" class="finp required" style="width: 100%" /><br/>
					<input type="hidden" name="cap_check" value="no" id="cap_check"/>
					Текст <br/>
					<textarea name="message" class="forum_text required" id="editor" style="width: 100%;height: 200px;"></textarea>
					<br/><br/>
					<span onclick="checkForm()" class="is_button right_top_corner">Создать топик<span></span></span>
				</form>
			</div><br />
			<a href="/<?=Funcs::$uri[0]?>/<?=Funcs::$uri[1]?>/">Все категории</a><br/><br clear="all"/>
			<?PaginationWidget::run()?>
			<script type="text/javascript" src="/js/editor/editor.js"></script>
			<link rel="stylesheet" href="/js/editor/css/editor.css" type="text/css" />
			<script>
				<?if($_POST):?>alert('Ошибка ввода символов с картинки');<?endif?>
				$(document).ready(function(){
					$("#cap_check").val("yes");
					$(".maketop").click(function(){
						$("#makearea").slideDown();
					});
					redactor = $('#editor').editor();
				});
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
		<?endif?>
	</div>
	<?PaginationWidget::run()?>
	<br clear="all" />
</div>