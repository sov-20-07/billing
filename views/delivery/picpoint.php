<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1"><?=$name?></div>
		<div id="delivery">
			<div class="head">
				<a href="/delivery/calc/" class="bookmark">Почта России</span><?/*?><a href="/delivery/calc/courier/" class="bookmark">Доставка курьером</a><?*/?><a href="/delivery/calc/picpoint/" class="bookmark">ПикПоинт</a>
			</div>
			<div class="city_block">
				<img src="/i/post_pic.jpg" alt="" title=""  />
				Ваш заказ будет доставлен в указанное отделение связи. О поступлении заказа Вы будете проинформированы почтовым уведомлением.
				Дополнительно, при получении посылки в местном почтовом отделении,
				клиент оплачивает сумму наложенного платежа в размере от 3% до 8% от стоимости посылки. При доставке в труднодоступные регионы воздушным транспортом, услуги по доставке авиа оплачивает клиент.
				<div class="search_city">
					<span class="light_gray">Найдите Ваш город:</span>
					<script type="text/javascript">
						var lastResFind=""; // последний удачный результат
						var copy_page=""; // копия страницы в ихсодном виде
						function TrimStr(s) {
							s = s.replace( /^\s+/g, '');
							return s.replace( /\s+$/g, '');
						}
						function FindOnPage(inputId) {//ищет текст на странице, в параметр передается ID поля для ввода
							var obj = window.document.getElementById(inputId);
							var textToFind;
	
							if (obj) {
								textToFind = TrimStr(obj.value);//обрезаем пробелы
							} else {
								alert("Введенная фраза не найдена");
								return;
							}
							if (textToFind == "") {
								alert("Вы ничего не ввели");
								return;
							}
	
							if(document.body.innerHTML.indexOf(textToFind)=="-1")
								alert("Ничего не найдено, проверьте правильность ввода!");
	
							if(copy_page.length>0)
								document.body.innerHTML=copy_page;
							else copy_page=document.body.innerHTML;
	
	
							document.body.innerHTML = document.body.innerHTML.replace(eval("/name="+lastResFind+"/gi")," ");//стираем предыдущие якори для скрола
							document.body.innerHTML = document.body.innerHTML.replace(eval("/"+textToFind+"/gi"),"<a name="+textToFind+" style='background:red'>"+textToFind+"</a>"); //Заменяем найденный текст ссылками с якорем;
							lastResFind=textToFind; // сохраняем фразу для поиска, чтобы в дальнейшем по ней стереть все ссылки
							window.location = '#'+textToFind;//перемещаем скрол к последнему найденному совпадению
						}
					</script>
					<form name="city_search" action="#" class="city_search">
					  <input id="city_search_input" type="text" value=""><label id="city_search_label" for="city_search_input">Введите название города</label>
					  <input id="city_search_button" type="image" src="/i/city_search_but.png" onclick="javascript: FindOnPage('text-to-find'); return false;">
					</form>
					<br/>
					<input type="text" id="text-to-find" value="">
					<input type="button" onclick="javascript: FindOnPage('text-to-find'); return false;" value="Искать"/>
	
				</div>
				<div class="zones">
				   <table>
						<tr>
							<td class="zone1">
							  <div class="zone">Зона 1</div>
							  <div class="price">100 руб. </div>
							  <div class="city"><span>Белгород</span><span> Брянск,</span><span> Владимир,</span><span> Воронеж,</span><span> Иваново,</span><span> Калуга,</span><span> Кострома,</span><span> Курск,</span><span> Липецк,</span><span> Н. Новгород,</span><span> Орел,</span><span> Пенза,</span><span> Рязань,</span><span> Смоленск,</span><span> Тамбов,</span><span> Тверь,</span><span> Тула</span></div>
							</td>
							<td class="zone2 active">
								<div class="zone">Зона 2</div>
								<div class="price">200 руб. </div>
								<div class="city"><span>В. Новгород,</span><span> Вологда,</span><span> Ижевск,</span><span> Йошкар-Ола,</span><span> Казань,</span><span> Киров,</span><span> Краснодар,</span><span> Петрозаводск,</span><span> Псков,</span><span> Ростов-на-Дону,</span><span> Самара,</span><span> Саранск,</span><span> Саратов,</span><span> Ульяновск,</span><span> Чебоксары</span></div>
							</td>
							<td class="zone3">
								<div class="zone">Зона 3</div>
								<div class="price">300 руб. </div>
								<div class="city"><span>Волгоград,</span><span> Екатеринбург,</span><span> Калининград,</span><span> Майкоп,</span><span> Нальчик,</span><span> Новороссийск,</span><span> Сочи,</span><span> Оренбург,</span><span> Ставрополь,</span><span> Уфа,</span><span> Челябинск</span></div>
							</td>
							<td class="zone4">
								<div class="zone">Зона 4</div>
								<div class="price">400 руб. </div>
								<div class="city"><span>Махачкала,</span><span> Новосибирск,</span><span> Омск,</span><span> Пермь,</span><span> Сургут,</span><span> Тюмень,</span><span> Черкесск</span></div>
							</td>
							<td class="zone5">
								<div class="zone">Зона 5</div>
								<div class="price">500 руб. </div>
								<div class="city"><span>Абакан,</span><span> Астрахань,</span><span> Архангельск,</span><span> Барнаул,</span><span> Владикавказ,</span><span> Иркутск,</span><span> Кемерово,</span><span> Красноярск,</span><span> Курган,</span><span> Мурманск,</span><span> Новокузнецк,</span><span> Сыктывкар,</span><span> Томск</span></div>
							</td>
							<td class="zone6">
								<div class="zone">Зона 6</div>
								<div class="price">600 руб. </div>
								<div class="city"><span>Благовещенск,</span><span> Владивосток,</span><span> Горно-Алтайск,</span><span> Грозный,</span><span> Кызыл,</span><span> Магас,</span><span> Нарьян-Мар,</span><span>Улан-Удэ,</span><span> Хабаровск,</span><span> Ханты-Мансийск,</span><span> Элиста,</span><span> Чита,</span><span> Южно-Сахалин ск,</span><span> Биробиджан</span></div>
							</td>
	
	
						</tr>
				   </table>
				</div>
			</div>
		</div>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>