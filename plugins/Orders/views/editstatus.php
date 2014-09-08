<script type="text/javascript">
	$("#s_lide").toggleClass("standart_menu_wide");
	$(this).css("display", "none");		
	$(".standart_menu").css("display", "none");
</script>
<div class="standart_menu_slim">
	<?=View::getPluginEmpty('menu')?>
	<form id="ids_post" method="post">
		<table cellspacing="0" cellpadding="0" tab="orders_status" class="spisok" page="<?=$_GET['p']?>">
			<thead>
				<tr>
					<th class="header">№</th>
					<th class="header">Название</th>
					<th class="header">Системное название</th>
					<th width="120" class="header" colspan="3">Действия</th>
				</tr>
			</thead>
			<tbody>
			<?foreach(Orders::$statuses as $item):?>
				<tr id="row<?=$item['id']?>">
					<td><?=$item['id']?></td>
					<td><?=$item['name']?></td>
					<td><?=$item['path']?></td>
					<td class="padd_5"><a href="/<?=Funcs::$cdir?>/orders/editstatus/?id=<?=$item['id']?>"><img height="16" width="15" title="Редактировать" alt="Редактировать" src="/<?=Funcs::$cdir?>/i/ic_edit.gif"></a></td>
					<td class="padd_5"><a href="/<?=Funcs::$cdir?>/orders/editstatus/?id=<?=$item['id']?>&act=del" onclick="return confirm('Удалить объект?')" title="удалить"><img border="0" src="/<?=Funcs::$cdir?>/i/ic_trash.gif" alt="удалить"></a></td>
	       			<td class="padd_5">
		       			<div style="cursor: move;" title="Переместить" alt="Переместить" src="/<?=Funcs::$cdir?>/i/ic_move.gif" class="mover"></div>
	       			</td>
				</tr>
			<?endforeach?>
			</tbody>
		</table>
		<fieldset style="width: 490px">
			<legend><?=$action?>:</legend>
			Имя: <input type="text" name="name" value="<?=Orders::$statuses[$_GET['id']]['name']?>" /> &nbsp;&nbsp;&nbsp; Путь: <input type="text" name="path" value="<?=Orders::$statuses[$_GET['id']]['path']?>" /><br />
			<input type="hidden" name="id" value="<?=$_GET['id']?>" />
			<input type="submit" value="Сохранить" />
		</fieldset>
	</form>
	
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
				<img height="1" width="130" src="/<?=Funcs::$cdir?>/i/pix.gif">
			</td>
		</tr></tbody></table>
	</div>
</div>