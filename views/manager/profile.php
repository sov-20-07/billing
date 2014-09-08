<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::CabinetMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Мой Профиль</div>
		<form method="post" action="/cabinet/profilesave/" name="myprofileform">
			<table class="default three_columns_table">
				<tr>
					<td <?if($_SESSION['iuser']['role']=='designer'):?>rowspan="7"<?else:?>rowspan="5"<?endif?> class="pic_rating">
						<a href="/popup/avatar/" title="Сменить фото" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 421, height: 200,contentId: 'highslide-html', cacheAjax: false } ); return false;"><?if($_SESSION['iuser']['avatar']):?><img src="<?=$_SESSION['iuser']['avatar']?>" /><?else:?><img src="/i/no_photo80.jpg" /><?endif?></a>
						<span class="light_gray">Рейтинг:</span>
						<div class="rating_line"></div>
						<span class="light_gray">7.2 из 10</span><br/>
						<a href="#">ОТЗЫВЫ(12)</a>
					</td>
					<td class="center"><span class="light_gray">Никнейм:</span></td>
					<td><span class="price"><input type="text" class="text" name="login" value="<?=$_SESSION['iuser']['login']?>"></span></td>
				</tr>
				<tr>
					<td class="center"><span class="light_gray">Фамилия:</span></td>
					<td><input type="text" class="text" name="lname" value="<?=$_SESSION['iuser']['lname']?>"></td>
				</tr>
				<tr>
					<td class="center"><span class="light_gray">Имя:</span></td>
					<td><input type="text" class="text" name="fname" value="<?=$_SESSION['iuser']['fname']?>"></td>
				</tr>
				<?if($_SESSION['iuser']['role']=='designer'):?>
					<tr>
						<td class="center"><span class="light_gray">Стоимость за разворот:</span></td>
						<td>
							<div class="clicker" id="number_page">
								<input id="number_of_page" value="0" type="hidden" name="price">
								<div class="number">0</div><div class="up"></div><div class="down"></div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="center"><span class="light_gray">Специализация:</span></td>
						<td class="specialty">
							<span class="specialtes" id="specialtes"></span>
							<div class="change_specialty">
								<div class="change" id="change_button">Изменить...</div>
								<div class="drop">
									<ul>
										<?foreach(Funcs::$reference['spec'] as $item):?>
											<li><span <?if(key_exists($item['id'],$_SESSION['iuser']['spec'])):?>class="select"<?endif?>>Живопись</span><div class="main <?if($item['id']==$_SESSION['iuser']['specmain']):?>select<?endif?>"></div></li>
										<?endforeach?>
									</ul>
								</div>
							</div>
						</td>
					</tr>
				<?endif?>
				<tr>
					<td class="center"><span class="light_gray">Город:</span></td>
					<td><input type="text" class="text" name="city" value="<?=$_SESSION['iuser']['city']?>" /></td>
				</tr>
				<tr>
					<td class="center"><span class="light_gray">О себе:</span></td>
					<td><textarea class="text about" name="about"><?=$_SESSION['iuser']['about']?></textarea></td>
				</tr>
				<tr class="dotted">
					<td></td><td class="center"><span class="light_gray">Телефон:</span></td>
					<td><input type="text" class="text" name="phone" value="<?=$_SESSION['iuser']['phone']?>" /></td>
				</tr>
				<tr>
					<td></td><td class="center"><span class="light_gray">e-mail:</span></td>
					<td>
						<input type="text" class="text" name="email" value="<?=$_SESSION['iuser']['email']?>" />
						<label class="hide_mail label_check" for="hide_mail"><input type="checkbox" id="hide_mail" name="emailhide" value="1" <?if($_SESSION['iuser']['emailhide']==1):?>checked<?endif?>>Скрыть e-mail</label>
					</td>
				</tr>
				<tr>
					<td></td>
					<td class="center"><span class="light_gray">Дата рождения:</span></td>
					<td class="calendar">
						<input type="text" class="text" id="datepicker" name="birthday" value="<?if($_SESSION['iuser']['birthday']!='0000-00-00'):?><?=date('d.m.Y',strtotime($_SESSION['iuser']['birthday']))?><?endif?>" />
						<script>
							$(function() {
								$("#datepicker").datepicker({
									showOn: "button",
									buttonImage: "/i/calendar.gif",
									buttonImageOnly: true,
									changeMonth: true,
									changeYear: true,
									showOtherMonths: true,
									selectOtherMonths: true,
									monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн','Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
									dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
									firstDay: 1,
									dateFormat: "dd.mm.yy",									
									yearRange:"c-100:c-14"
								});
							});
						</script>
					</td>
				</tr>
				<tr class="dotted">
					<td></td><td class="center"><span class="light_gray">Старый пароль:</span></td>
					<td class="old_pass"><input id="old-pass" type="password" class="text" name="pass"><span class="visible"></span></td>
				</tr>
				<tr>
					<td></td><td class="center"><span class="light_gray">Новый пароль:</span></td>
					<td class="new_pass"><input id="new-pass" type="password" class="text" name="newpass"><span class="visible"></span></td>
				</tr>
			</table>
			<div class="save_changed"><span class="is_button right_top_corner" onclick="myprofileform.submit()">Сохранить изменения<span></span></span></div>
		</form>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>
<!-- /контент -->
<?/* ?>
		<script>
			function checkForm(){
				var f=0
				$('#infoform .required').each(function(){
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
			function changePass(){
				var pass=$('input:[name="pass"]').val();
				if(jQuery.trim(pass)!=''){
					$.ajax({
						type: "POST",
						url: "/registration/setpass/",
						data: "id="+$('input:[name=id]').val()+"&pass="+pass,
						success: function(msg){
							alert('Пароль успешно изменен');
						}
					});
				}else{
					alert('Введите пароль');
				}
			}
		</script>
<?*/?>