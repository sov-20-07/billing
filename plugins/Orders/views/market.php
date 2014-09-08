<script type="text/javascript">
	$("#s_lide").toggleClass("standart_menu_wide");
	$(this).css("display", "none");		
	$(".standart_menu").css("display", "none");
</script>
<div class="standart_menu_slim">
	<?=View::getPluginEmpty('menu')?>
	<table class="spisok" cellspacing="0" cellpadding="0" width="100%" id="new"><thead>
		<tr>
			<th>Заказ</th><th>Имя</th><th>Email</th><th>Оставлен</th>
		</tr></thead>
		<tbody>
		<?foreach($list as $item): ?>
		<tr>
			<td><a href="/<?=Funcs::$cdir?>/orders/<?=$editpath?>/<?=$item['id']?>/" title="редактировать"><?=str_repeat('0',6-strlen($item['id'])).$item['id']?></a><br /></td>
			<td><?=$item['name']?></td>
			<td><?=$item['email']?></td>
			<td><?=$item['cdate']?></td>
		</tr>
		<?endforeach?>
		</tbody>
	</table>
	<div>Итого: <nobr><?=number_format($count,0,',',' ')?></nobr></div>
	<div class="gray_line_navigation">
		<table width="100%"><tbody><tr>
			<td width="20%">
				<?/*?>
				<a onclick="$('#ids_post').submit()" href="javascript:;"><img height="16" width="15" src="/<?=Funcs::$cdir?>/i/ic_edit.gif" alt="Редактировать" title="Редактировать"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:void(0)"><img height="18" width="16" onclick="toogleVisAll('/<?=Funcs::$cdir?>/ajax/visible', this, 'modules')" src="/<?=Funcs::$cdir?>/i/v.gif" alt="Опубликовать" title="Опубликовать"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a title="удалить" onclick="removeAllItems('/<?=Funcs::$cdir?>/ajax/delete', 'modules')" href="javascript:void(0)"><img border="0" alt="удалить" src="/<?=Funcs::$cdir?>/i/ic_trash.gif"></a>
				<?*/?>
			</td>
			<td width="60%">
				<?=PaginationWidget::run()?>
			</td>
			<td width="20%">
				<span class="light_gray">Выводить </span>
				<form method="post" action="/<?=Funcs::$cdir?>/tree/perpage/" style="display:inline">
					<select class="small_select" onchange="this.parentNode.submit()" name="new_kol">
                    	<option value="10" <?if($_SESSION['user']['perpage']==10):?>selected<?endif?>>10</option>
                    	<option value="20" <?if($_SESSION['user']['perpage']==20):?>selected<?endif?>>20</option>
                    	<option value="50" <?if($_SESSION['user']['perpage']==50):?>selected<?endif?>>50</option>
                    	<option value="5000000" <?if($_SESSION['user']['perpage']==5000000):?>selected<?endif?>>все</option>
                    	
					</select>
				</form>
				<img height="1" width="130" src="./i/pix.gif">
			</td>
		</tr></tbody></table>
	</div>
</div>