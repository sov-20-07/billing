<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1"><?=$name?></div>
		<script>
			function changeBlock(obj){
				if(!obj.hasClass('active')){
					$('.inset').hide();
					$('#'+obj.attr('show')).show();
					$('.bookmark').removeClass('active');
					obj.addClass('active');
				}
			}
		</script>
		<div id="delivery">
			<div class="head">
				<span class="bookmark active" show="mailrussia" onclick="changeBlock($(this))">Почта России</span><span class="bookmark"  show="pickpoint" onclick="changeBlock($(this))">Пункты выдачи</span><span class="bookmark"  show="courier" onclick="changeBlock($(this))">Доставка курьером</span>
			</div>
			<div class="city_block">
				<div id="mailrussia" class="inset">
					<?=$fields['fulltext']?>
					<form method="post" id="uploadform">
						<div class="delivery_calc">
							<div class="size_book">
								<table class="list_book">
									<tr>
									<?foreach(Funcs::$reference['booksize'] as $key=>$item):?>
										<td id="td<?=$key?>">
											<div class="one_book book_delivery size<?=$key?>">
												<label for="size<?=$key?>" class="label_check">
													<input <?if($key=='20x15'):?>checked<?endif?> type="radio" id="size<?=$key?>" name="booksize" class="booksize" value="<?=$key?>" <?if($item['id']==$_SESSION['iuser']['upload']['booksize']):?>checked<?endif?> onclick="getPrice()" />
													<img src="/i/calc_book<?=$key?>.png" />
													<span style="color: #2CB4B4;"><?=$item['name']?></span><br />
													<span><?=$key?></span><br />
												</label>
											</div>
										</td>
									<?endforeach?>
									</tr>
								</table>
							</div>
							<br />
							<div class="clicker_area">
								<div><span>Количество книг:</span><div class="clicker" id="number_book"><input id="number_of_book" name="countbook" value="1" type="hidden"><div class="number">1</div><div class="up"></div><div class="down"></div></div></div>
							</div>
							<div class="clicker_area">
								<div><span>Количество страниц:</span><div class="clicker" id="number_page"><input id="number_of_page" name="countpage" value="20" type="hidden"><div class="number">20</div><div class="up"></div><div class="down"></div></div></div>
							</div>
							<div class="fieldset_radio_buttoms">
								<div class="name" style="background: #F2F2F2">Вид переплета
									<div class="question" style="top:4px;">
										<div class="hint">Если Вы сделаете книгу приватной её не смогут просматривать другие пользователи. Также Вы не сможете выставить ей на продажу.<div class="st"></div></div>
									</div>
								</div>
								<ul>
									<li>
										<label class="label_radio">
											<input type="radio" onclick="getPrice()" value="<?=Funcs::$reference['weight']['soft']['value']?>" kind="standart" name="binding" class="binding" checked />
											Мягкий переплет
										</label>
									</li>
									<li>
										<label class="label_radio">
											<input type="radio" onclick="getPrice()" value="<?=Funcs::$reference['weight']['hard']['value']?>" kind="premium" name="binding" class="binding" />
											Твердый переплет
										</label>
									</li>
								</ul>
							</div>
							<div class="fieldset_radio_buttoms">
								<div class="name" style="background: #F2F2F2">Вид бумаги
									<div class="question" style="top:4px;">
										<div class="hint">Если Вы сделаете книгу приватной её не смогут просматривать другие пользователи. Также Вы не сможете выставить ей на продажу.<div class="st"></div></div>
									</div>
								</div>
								<ul>
									<li>
										<label class="label_radio">
											<input type="radio" value="<?=Funcs::$reference['weight']['standart']['value']?>" name="paper" class="paper" onclick="getPrice()" checked />
											Стандартная
										</label>
									</li>
									<li>
										<label class="label_radio">
											<input type="radio" value="<?=Funcs::$reference['weight']['premium']['value']?>" name="paper" class="paper" onclick="getPrice()" />
											Премиум
										</label>
									</li>
								</ul>
							</div>
							<div style="clear: both"></div>
						</div>
						<input type="hidden" name="act" value="step2" /> 
						<div class="next_step">
							<div style="float: left;color: #000000;">Общий вес: <span id="weight" style="font-weight: bold;">0</span> г.</div><br />
							<div style="float: left;color: #000000;">Стоимость доставки книги: <span id="cost" style="font-weight: bold;">0</span> руб.</div><br />
							<?/*?><span class="is_button right_top_corner" onclick="checkForm()">следующий шаг<span></span></span><?*/?>
						</div>
					</form>
					<script>
						$(document).ready(function(){
							getPrice();
							var number_page=parseInt($('#number_page .number').text());
							$('#number_page .up').click(function(){
								number_page=number_page+2;
								$('#number_page .number').text(number_page);
								$('#number_of_page').val(number_page)
								getPrice();
							});
							$('#number_page .down').click(function(){
								if(number_page>20){
									number_page=number_page-2;
									$('#number_page .number').text(number_page);
									$('#number_of_page').val(number_page);
									getPrice();
								}
							});
							var number_book =parseInt($('#number_book .number').text());
							$('#number_book .up').click(function(){
								number_book=number_book+1;
								$('#number_book .number').text(number_book);
								$('#number_of_book').val(number_book);
								getPrice();
							});
							$('#number_book .down').click(function(){
								if (number_book!=1){
									number_book=number_book-1;
									$('#number_book .number').text(number_book);
									$('#number_of_book').val(number_book);
									getPrice();
								}
							});
						});
						function getPrice(){
							
							var booksize=$('.booksize:checked').val();
							var koef=booksize.substr(0,2)*1*booksize.substr(3,2)*1/10000;
							var binding=0;
							if($('.binding:checked').attr('kind')=='standart'){
								binding=$('.paper:checked').val()*2;
							}else{
								binding=$('.binding:checked').val()*2;
							}
							var weight=$('#number_of_book').val()*($('#number_of_page').val()*$('.paper:checked').val()*koef+binding*koef);
							var sum=35+((weight-100)/20)*1.50;
							sum=Math.ceil(sum);
							weight=Math.round(weight);
							$('#weight').text(weight);
							$('#cost').text(sum);
						}
					</script>
				</div>
				<div id="pickpoint" style="display: none;" class="inset">
					<?=$fields['fulltext2']?>
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
								var obcl=document.getElementById('zones');
								
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
		
								if(obcl.innerHTML.indexOf(textToFind)=="-1")
									alert("Ничего не найдено, проверьте правильность ввода!");
		
								if(copy_page.length>0)
									obcl.innerHTML=copy_page;
								else copy_page=obcl.innerHTML;
		
		
								obcl.innerHTML = obcl.innerHTML.replace(eval("/name="+lastResFind+"/gi")," ");//стираем предыдущие якори для скрола
								obcl.innerHTML = obcl.innerHTML.replace(eval("/"+textToFind+"/gi"),"<a name="+textToFind+" style='background:red'>"+textToFind+"</a>"); //Заменяем найденный текст ссылками с якорем;
								lastResFind=textToFind; // сохраняем фразу для поиска, чтобы в дальнейшем по ней стереть все ссылки
								window.location = '#'+textToFind;//перемещаем скрол к последнему найденному совпадению
							}
							$(document).ready(function(){
								$('.zones td').hover(function(){
									$(this).addClass('active');
								},
								function(){
									$(this).removeClass('active');
								});
							});
						</script>
						<form name="city_search" action="#" class="city_search">
						  <input id="city_search_input" type="text" value=""><label id="city_search_label" for="city_search_input">Введите название города</label>
						  <input id="city_search_button" type="image" src="/i/city_search_but.png" onclick="javascript: FindOnPage('city_search_input'); return false;">
						</form>
						<br/>
						<?/* ?>
						<input type="text" id="text-to-find" value="">
						<input type="button" onclick="javascript: FindOnPage('text-to-find'); return false;" value="Искать"/>
						<?*/?>
					</div>
					<div class="zones" id="zones">
					   <table>
							<tr>
							<?foreach(Funcs::$referenceId['pickpoint'] as $item):?>
								<td class="zone1">
								  <div class="zone"><?=$item['name']?></div>
								  <div class="price"><?=$item['path']?> руб. </div>
								  <div class="city"><?=$item['value']?></div>
								</td>
							<?endforeach?>
							</tr>
					   </table>
					</div>
				</div>
				<div id="courier" style="display: none;" class="inset">
					Доставка курьером
				</div>
			</div>
		</div>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>