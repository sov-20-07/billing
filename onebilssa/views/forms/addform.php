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
								<h1 class="cell_page-content_header_text"><?=$title?></h1>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<tr>
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="name" value="<?=$form['name']?>"></div></td>
									</tr>
									<tr>
										<td>Алиас</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="path" value="<?=$form['path']?>"></div></td>
									</tr>
									<tr>
										<td>Класс формы</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="formclass" value="<?=$form['formclass']?>"></div></td>
									</tr>
									<tr>
										<td>Переход</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="action" value="<?=$form['action']?>"></div></td>
									</tr>
									<tr>
										<td>Метод</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="method" value="<?=$form['method']?>"></div></td>
									</tr>
									<tr>
										<td>Класс кнопки</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="submitclass" value="<?=$form['submitclass']?>"></div></td>
									</tr>
									<tr>
										<td>Тема письма</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="theme" value="<?=$form['theme']?>"></div></td>
									</tr>
									<tr>
										<td>Страница после отправки</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="redirect" value="<?=$form['redirect']?>"></div></td>
									</tr>
									<tr>
										<td>Email</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="email" value="<?=$form['email']?>"></div></td>
									</tr>
								</table>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="id" value="<?=$form['id']?>" />
					<span class="button button_save" onclick="$('#frm').submit()">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>