<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Управление пользователями
				</h1>
			</div>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="modules" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Ползователь</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Вход</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">IP</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Группа</span>
								</div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<?if($item['ldate']!='0000-00-00 00:00:00'):?>
								<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
									<td class="sections_table_cell">
										<?=$item['name']==''?$item['login']:$item['name']?>
									</td>
									<td class="sections_table_cell">
										<?=date('H:i d.m.Y',strtotime($item['ldate']))?>
									</td>
									<td class="sections_table_cell">
										<?=$item['ip']?>
									</td>
									<td class="sections_table_cell">
										<?foreach($item['groups'] as $group):?>
											<?=$group?><br />
										<?endforeach?>
									</td>
								</tr>
							<?endif?>
						<?endforeach?>
					</table>
				</div>
			</div>
		</div>
		<div class="ltRow">
			<div class="sections_footer clearfix">
				<?=PaginationWidget::run($pagination)?>
				<div class="displayed-quantity">
					<form method="post" action="/<?=Funcs::$cdir?>/tree/perpage/" id="selectPerPageForm">
						Выводить по:
						<select class="jsSelectStyled" onchange="$('#selectPerPageForm').submit()" name="new_kol">
							<option value="10" <?if($_SESSION['user']['perpage']==10):?>selected<?endif?>>10</option>
							<option value="25" <?if($_SESSION['user']['perpage']==25):?>selected<?endif?>>25</option>
							<option value="50" <?if($_SESSION['user']['perpage']==50):?>selected<?endif?>>50</option>
							<option value="100" <?if($_SESSION['user']['perpage']==100):?>selected<?endif?>>100</option>
							<option value="5000000" <?if($_SESSION['user']['perpage']==5000000):?>selected<?endif?>>Все</option>
						</select>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>