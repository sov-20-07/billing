<div id="content"><div class="common_padds"><div class="inline_block">
	<?CrumbsWidget::run()?>
	<div id="right_part" class="without_left"><div class="right_padds">
		<h1><?=$name?></h1>
		<div class="faq_note_wide"><div class="note_padds">
			<p>Мы&nbsp;ценим Ваше время и&nbsp;стремимся максимально быстро и&nbsp;качественно предоставить ответ на&nbsp;Ваш вопрос.</p>
			<p>Для этого мы&nbsp;предлагаем Вам ознакомиться с&nbsp;дополнительной информацией по&nbsp;интересующим Вас вопросам&nbsp;Вы можете в&nbsp;разделе &laquo;<a href="/faq/">Вопрос-ответ</a>&raquo;.</p>
			<p>Если Вы&nbsp;хотите отправить нам сообщение, пожалуйста, выберите подходящую категорию и&nbsp;тему Вашего вопроса из&nbsp;предложенных вариантов. Для отправки вопроса необходимо корректно заполнить все приведенные в&nbsp;форме поля.</p>
			<p>
				Также вы&nbsp;можете обратиться в&nbsp;Службу по&nbsp;работе с&nbsp;клиентами по&nbsp;телефону:<br />
				<nobr class="phone"><?=Funcs::$conf['setting']['phone']?></nobr><br />
				или <span class="pseudo popup_call">заказать обратный звонок</span>, и&nbsp;мы&nbsp;позвоним Вам сами, чтобы ответить на&nbsp;Ваши вопросы.
			</p>
		</div></div>
		<div class="faq_content ask_question">
			<form id="oneform" method="post" onsubmit="return checkoneform()">
				<div class="field_block">
					<div class="field_name">Категория</div>
					<div class="field">
						<select name="parent">
							<option value="">Выберите категорию сообщения</option>
							<?foreach($rubrics as $i=>$item):?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?endforeach?>
						</select>
					</div>
				</div>
				<div class="field_block">
					<div class="field_name">Сообщение</div>
					<div class="field"><textarea rows="7" class="with_back required" name="name"></textarea></div>
				</div>
				<div class="field_block">
					<div class="field_name">Ваше имя</div>
					<div class="field"><input type="text" class="text required" name="fio" /></div>
				</div>
				<div class="field_block">
					<div class="field_name">Email</div>
					<div class="field"><input type="text" class="text required" name="email" /></div>
				</div>
				<label class="i_agree"><input type="checkbox" onchange="if($(this).attr('checked')=='checked'){$('#sbmt1').attr('disabled',false)}else{$('#sbmt1').attr('disabled',true)}" />Я соглашаюсь на хранение и обработку моих персональных данных, необходимых для выполнения заказов</label>
				<input type="submit" class="is_button is_button2 with_shadow" value="Отправить сообщение" id="sbmt1" disabled />
				<script>
					function checkoneform(){
						var f=0;
						$('#oneform .required').each(function(){
							if (jQuery.trim($(this).val())==''){
								$(this).css('border','solid 1px red');
								f=1;
							}else{
								$(this).css('border','');
							}
						});
						if (f==1){
							 return false;
						}else return true;
					}
				</script>
			</form>
		</div>
	</div></div>
</div></div></div>