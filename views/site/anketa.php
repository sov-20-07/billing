<div class="right-block-content">
	<?CrumbsWidget::run()?>
	<h1><?=$name?></h1>
	<?=$fields['fulltext']?>
	<form method="post" id="anketaform" action="/registration/anketa/" onsubmit="return checkForm();">
		<table class="cabinet noborder ">
			<thead>
				<th colspan="2">
				  <h3>1. Обязательная информация</h3>
				</th>
			</thead>
			<tr>
				<td style="width: 270px;">Наименование организации (например Орион Экспресс)<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="company" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Организационно-правовая форма (ЗАО, ООО, ОАО, ИП и т.д.)<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Comooo" /></td>
			</tr>
			<tr>
				<td>Контактный телефон (в формате +7ХХХХХХХХХХ)<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Comphone" style="width: 200px;"/></td>
			</tr>
			<tr>
				<td>Номер участника партнерской программы «Орион Экспресс» в формате XX.XXXX.XX (если есть)<span class="check">*</span></td>
				<td><input type="text" class="text change-input" name="code" style="width: 200px;"/></td>
			</tr>
			<thead>
				<th colspan="2">
					<h5>1.1 Руководитель организации</h5>
				</th>
			</thead>
			<tr>
				<td>Фамилия<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="CEOlname" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Имя<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="CEOfname" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Отчество<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="CEOmname" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Телефон<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="CEOphone" style="width: 200px;"/></td>
			</tr>
			<thead>
			<th colspan="2">
				<h5>1.2 Фактический адрес</h5>
			</th>
			</thead>
			<tr>
				<td>Регион<span class="check">*</span></td>
				<td>
					<div class="select" style="width: 200px;">
						<div class="select-val">Москва</div>
						<input value="Москва" type="hidden" name="Aregion"/>
						<div class="select-list" >
							<ul>
							<?foreach(Funcs::$referenceId['regions'] as $key=>$item):?>
							   	<li><?=$item['name']?></li>
							<?endforeach?>
							</ul>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>Индекс<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Aindex" style="width: 200px;"/></td>
			</tr>
			<tr>
				<td>Область<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Aobl" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Город<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Acity" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Улица<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Astreet" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Дом<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Ahouse" /></td>
			</tr>
			<tr>
				<td>Корпус / строение</td>
				<td><input  type="text" class="text change-input" name="Akorp" /></td>
			</tr>
			<tr>
				<td>Офис / квартира</td>
				<td><input type="text" class="text change-input" name="Aoffice" /></td>
			</tr>
			<thead>
			<th colspan="2">
				<h5>1.3 Контактное лицо (для регистрации)</h5>
			</th>
			</thead>
			<tr>
				<td>ФИО<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="name" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Мобильный телефон<span class="check">*</span></td>
				<td><input  type="text" class="text change-input required" name="phone" style="width: 200px;"/></td>
			</tr>
			<tr>
				<td>E-mail<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="email" style="width: 360px;"/></td>
			</tr>
			<thead>
			<th colspan="2">
				<h5>1.4 Данные установщика</h5>
			</th>
			</thead>
			<tr>
				<td>Фамилия<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Enlname" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Имя<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Enfname" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Отчество<span class="check">*</span></td>
				<td><input type="text" class="text change-input required" name="Enmname" style="width: 360px;"/></td>
			</tr>
			<thead>
			<th colspan="2">
				<h5>1.5 Территория по установке оборудования (регионы, области)</h5>
			</th>
			</thead>
			<tr>
				<td colspan="2">
					<textarea style="width: 400px;" name="territory"></textarea>
				</td>
			</tr>
			<thead>
			<th colspan="2">
				<h3>2. Дополнительная информация</h3>
			</th>
			</thead>
			<tr>
				<td>Год основания организации</td>
				<td><input type="text" class="text change-input" name="Enmname" /></td>
			</tr>
			<tr>
				<td>Сайт организации</td>
				<td><input type="text" class="text change-input" name="Csite" style="width: 360px;"/></td>
			</tr>
			<tr>
				<td>Опыт продаж комплектов спутникового ТВ</td>
				<td>
					<label class="label_radio"  style="margin-right: 15px">
						<input type="radio" name="sales" value="1" />
						да
					 </label>
					<label class="label_radio">
						<input type="radio" name="sales" value="0" checked />
						нет
					</label>
				</td>
			</tr>
			<tr>
				<td>Установка комплектов спутникового ТВ</td>
				<td>
					<label class="label_radio"  style="margin-right: 15px">
						<input type="radio" name="installation" value="1" />
						да
					</label>
					<label class="label_radio">
						<input type="radio" name="installation" value="0" checked />
						нет
					</label>
				</td>
			</tr>
			<tr>
				<td>Место приобретения комплектов спутникового ТВ (наименование организации и контактная информация)</td>
				<td><textarea style="width: 360px;" name="Cplace"></textarea></td>
			</tr>
			<tr>
				<td>Разместить контактную информацию на сайте «Орион Экспресс»</td>
				<td>
					<label class="label_radio"  style="margin-right: 15px">
						<input type="radio" name="Ccontact" />
						да
					</label>
					<label class="label_radio">
						<input type="radio" name="Ccontact" checked />
						нет
					</label>
				</td>
			</tr>
			<tr>
				<td>Получать информацию о проводимых акциях, возможностях развития бизнеса, изменениях в пакете телеканалов и профилактических работах по e-mail</td>
				<td>
					<label class="label_radio"  style="margin-right: 15px">
						<input type="radio" name="Cget" checked />
						да
					</label>
					<label class="label_radio">
						<input type="radio" name="Cget" />
						нет
					</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<label class="label_check">
						<input type="checkbox" onclick="if($(this).prop('checked')==true){$('#submitbut').prop('disabled',false);}else{$('#submitbut').attr('disabled','disabled');}" />
						С условиями <a href="#" target="_blank">публичной оферты по участию в партнерской программе</a> согласен
					</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" class="send" id="submitbut" disabled="disabled" />
				</td>
			</tr>
		</table>
	</form>
	<script>
	function checkForm(){
		var f=0;
		$('#anketaform .required').each(function(){
			if (jQuery.trim($(this).val())==''){
				$(this).css('border','solid 1px red');
				f=1;
			}else{
				$(this).css('border','');
			}
		});
		if(f==1){
			return false;
		}else{
			return true;
		}
	}
</script>
</div>
<div class="left-block-content">
	<?MenuWidget::LeftMenu()?>
	<?BannersWidget::run()?>
</div>