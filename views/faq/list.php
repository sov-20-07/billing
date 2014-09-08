<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1"><?=$name?></div>
		<p>Есть вопрос? Возможно вы найдете его в списке</p>
		<span onclick="$('#ask').slideToggle()" class="is_button right_top_corner">задать вопрос<span></span></span><br/><br/>
		<div id="ask" style="<?if(!$_POST):?>display:none;<?endif?>background:#f9f9f9;padding:10px">
			<form action="/help/faq/" id="frm" method="post" enctype="multipart/form-data">
				<div class="inp" style="padding:3px; background-color:#c97383; color:#fff; display:none" id="error"></div>
				<table class="form_tab" width="100%"> 
					<col width="155"><col>
					<tr>
						<td>Ваш email<sup>*</sup></td>
						<td><input type="text" class="inp required" name="email" value="<?=$_POST['email']?>" /></td>
					</tr>
					<tr>
						<td>Вопрос<sup>*</sup></td>
						<td>
							<textarea class="inp required" name="question" cols="50" rows="5"><?=$_POST['question']?></textarea><br />
						</td>
					</tr>
					<tr>
						<td align="center">
							<img src="/captcha/" id="captcha" />
							<a href="javascript:;" onclick="$('#captcha').attr('src','/captcha/?'+Math.random())">обновить</a>
						</td>
						<td><input type="text" name="kcaptcha" value="" class="inp required"/></td>
					</tr>
					<tr>
						<td align="right" colspan="2">
							<span onclick="checkForm()" class="is_button right_top_corner">отправить<span></span></span>
						</td>
					</tr>
				</table>
			</form>
			<script>
			<?if($_POST):?>alert('Ошибка ввода символов с картинки');<?endif?>
			function checkForm(){
				var f=0;
				$('#frm .required').each(function(){
					if (jQuery.trim($(this).val())==''){
						$(this).css('border','solid 1px red');
						f=1;
					}else{
						$(this).css('border','');
					}
				});
				if (f==1){
					return false;
				}else {
					$('#frm').submit()
				}
			}
			</script>
		</div>
		<ul>
		<?foreach($list as $i=>$item):?>
			<li style="padding-bottom: 10px;">
				<a href="javascript:;" onclick="$(this).next().slideToggle()" class="dota" style="border-bottom: 1px dotted #2CB4B4;text-decoration: none"><?=$item['name']?></a>
				<div style="display:none"><?=$item['answer']?></div>
			</li>
		<?endforeach?>
		</ul>
		<br />
		<?PaginationWidget::run()?>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>