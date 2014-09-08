<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					<?if(Funcs::$uri[2]==''):?>
						Новые заявки
					<?else:?>
						История заявок
					<?endif?>
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<div class="ltCell cell_page-content_control-panel">
				<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/" class="button">Новые</a>
				<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/history/" class="button">История</a>
			</div>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="<?=Funcs::$uri[1]?>" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Дата</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Имя</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Email</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Телефон</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Сообщение</span>
								</div>
							</th>
							<?if(Funcs::$uri[2]=='history'):?>
								<th class="sections_table_cell">
									<div class="sections_table_caption-holder jsFixedY">
										<span class="sections_table_caption">Комментарий</span>
									</div>
								</th>
							<?else:?>
								<th class="sections_table_cell">
									<div class="sections_table_caption-holder jsFixedY"></div>
								</th>
							<?endif?>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell">
									<?=date('H:i d.m.Y',strtotime($item['cdate']))?>
									<?if(Funcs::$uri[2]=='history'):?><br><?=date('H:i d.m.Y',strtotime($item['fdate']))?><?endif?>
								</td>
								<td class="sections_table_cell"><?=$item['name']?></td>
								<td class="sections_table_cell"><a href="mailto:<?=$item['email']?>"><?=$item['email']?></a></td>
								<td class="sections_table_cell"><?=$item['phone']?></td>
								<td class="sections_table_cell"><?=$item['message']?></td>
								<?if(Funcs::$uri[2]=='history'):?>
									<td class="sections_table_cell"><?=$item['comment']?></td>
								<?else:?>
									<td class="sections_table_cell">
										<div class="sections_table_control-panel">
											<span class="icon icon_edit" onclick="$(this).next().toggle()"></span>
											<form action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/done/" method="post" style="display: none;">
												О чем договорились?
												<div class="input_text_holder">
													<textarea name="comment" class="input_text"></textarea>
												</div>
												<input type="hidden" name="id" value="<?=$item['id']?>">
												<span class="button" onclick="$(this).parent().submit()">Обработать</span>
											</form>
										</div>
									</td>
								<?endif?>
							</tr>
						<?endforeach?>
					</table>
				</div>
			</div>
		</div>
		<div class="ltRow">
			<div class="sections_footer clearfix">
				<?=PaginationWidget::run($pagination)?>
			</div>
		</div>
	</div>
</div>