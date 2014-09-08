<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Инструменты</h1>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section">
								<a href="/<?=ONESSA_DIR?>/tools/properties/">Свойства</a>
							</li>
							<li class="edit_form_section">
								<a href="/<?=ONESSA_DIR?>/tools/redirects/">Редиректы 301</a>
							</li>
							<li class="edit_form_section">
								<a href="/<?=ONESSA_DIR?>/tools/research/">Переиндексация поиска</a>
							</li>
							<li class="edit_form_section">
								<a href="/<?=ONESSA_DIR?>/tools/sitemap/">Карта сайта XML</a>
							</li>
							<?if(CACHE_DIR):?>
								<li class="edit_form_section jsMoveFixed">
									Кэширование: <?if(CACHE==1):?><span style="color:#009900">Включено</span><?else:?><span style="color:#FF0000">Выключено</span><?endif?><br />
									Всего закэшировано: <?=$countCache?><br />
									<a href="/<?=ONESSA_DIR?>/cache/clear/">Сбросить кэш</a>
								</li>
							<?endif?>
							<li class="edit_form_section jsMoveFixed">
								<a href="/<?=ONESSA_DIR?>/tools/exportdb/">Экспорт дамп базы данных</a>
							</li>
							<li class="edit_form_section jsMoveFixed">
								<a href="javascript:;" onclick="$('#upload').click();">Импорт дамп базы данных</a>
								<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/tools/importdb/" id="importForm">
									<input id="upload" type="file" onchange="$('#importForm').submit();" style="display: none;" name="upload">
								</form>
							</li>
							<li class="edit_form_section jsMoveFixed">
								<a href="/<?=ONESSA_DIR?>/tools/sql/">Выполнить SQL-запрос</a>
							</li>
							<li class="edit_form_section jsMoveFixed">
								<a href="/<?=ONESSA_DIR?>/tools/phpinfo/" target="_blank">PHP-info</a>
							</li>
							<li class="edit_form_section jsMoveFixed">
								<a href="/<?=ONESSA_DIR?>/changelog.txt" target="_blank">О версии...</a>
							</li>
						</ul>
				</div>
			</div>
		</div>
	</div>
</div>