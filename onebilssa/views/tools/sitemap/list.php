<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text"><?=$name?></h1>
			</div>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<form id="ids_post" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/sitemap/save/">
						<table cellspacing="0" cellpadding="0" width="100%" class="spisok">
							<thead>
								<tr name="header">
									<th class="header">Название</th>
									<th class="header">URL</th>
									<th class="header">Дата</th>
									<th class="header">Обновление</th>
									<th class="header">Приоритет</th>
									<th class="header">Участие</th>
								</tr>
							</thead>
							<tbody>
							<?foreach($list as $i=>$item):?>
								<tr <?if($i>29):?>class="trnone" style="display:none;<?if($item['checked']):?>background:#d3f4d3<?endif?>"<?else:?><?if($item['checked']):?>style="background:#d3f4d3"<?endif?><?endif?>>
									<td><?=$item['name']?></td>
									<td>
										<?=$item['path']?>
										<input type="hidden" name="loc[<?=$item['id']?>]" value="<?=$item['path']?>" />
									</td>
									<td>
										<?=$item['mdate']?>
										<input type="hidden" name="lastmod[<?=$item['id']?>]" value="<?=$item['mdate']?>" />
									</td>
									<td>
										<select name="changefreq[<?=$item['id']?>]">
											<option value="always" <?if($item['changefreq']=='always'):?>selected<?endif?>>always</option>
											<option value="hourly" <?if($item['changefreq']=='hourly'):?>selected<?endif?>>hourly</option>
											<option value="daily" <?if($item['changefreq']=='daily'):?>selected<?endif?>>daily</option>
											<option value="weekly" <?if($item['changefreq']=='weekly' || $item['changefreq']==''):?>selected<?endif?>>weekly</option>
											<option value="monthly" <?if($item['changefreq']=='monthly'):?>selected<?endif?>>monthly</option>
											<option value="yearly" <?if($item['changefreq']=='yearly'):?>selected<?endif?>>yearly</option>
											<option value="never" <?if($item['changefreq']=='never'):?>selected<?endif?>>never</option>
										</select>
									</td>
									<td><input type="text" name="priority[<?=$item['id']?>]" value="<?=$item['priority']==''?'0.5':$item['priority']?>" size="3" /></td>
									<td><input type="checkbox" name="ids[<?=$item['id']?>]" value="<?=$item['id']?>" <?=$item['checked']?> /></td>
								</tr>
							<?endforeach?>
							</tbody>
						</table>
						<script>
							$(document).ready(function(){
								$('table.spisok tr').click(function(){
									if($(this).find('input:checkbox').attr('checked')=='checked'){
										$(this).find('input:checkbox').attr('checked',false);
										$(this).css('background','#FFFFFF');
									}else{
										$(this).find('input:checkbox').attr('checked','checked');
										$(this).css('background','#d3f4d3');
									}
								});
								$('span.selall').click(function(){
									$('table.spisok').find('input:checkbox').attr('checked','checked');
									$('table.spisok tr:[name!=header]').css('background','#d3f4d3');
								});
								$('span.selnon').click(function(){
									$('table.spisok').find('input:checkbox').attr('checked',false);
									$('table.spisok tr:[name!=header]').css('background','#FFFFFF');
								});
								$('span.selsho').click(function(){
									$('table.spisok tr.trnone').show();
									$('span.selhid').show();
									$(this).hide();
									resizeContent();
								});
								$('span.selhid').click(function(){
									$('table.spisok tr.trnone').hide();
									$('span.selsho').show();
									$(this).hide();
									resizeContent();
								});
							});
						</script>
						<div class="gray_line_navigation">
							<table width="100%"><tbody><tr>
								<td width="20%">
									<span class="pseudo selsho" style="cursor: pointer;">Показать все</span>
									<span class="pseudo selhid" style="cursor: pointer;display:none;">Скрыть</span>
								</td>
								<td width="50%">
									<input type="submit" value="Создать sitemap.xml" style="background: #FFFFFF"> &nbsp;&nbsp;&nbsp;
									<a href="/u/sitemap.xml" target="_blank">Открыть sitemap.xml</a>
								</td>
								<td width="30%">
									<span class="pseudo selall" style="cursor: pointer;">Отметить все</span> /
									<span class="pseudo selnon" style="cursor: pointer;">Снять выделение</span>
									<img height="1" width="130" src="./i/pix.gif">
								</td>
							</tr></tbody></table>
							<br>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>