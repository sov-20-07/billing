<div class="standart_menu_slim">
	<div class="gray_line_top">
		<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/showadd/"><div class="add_section">Добавить запись</div></a>
	</div>
	<form id="ids_post" method="post" action="/<?=Funcs::$cdir?>/data/one?path=cmode&amp;parent=&amp;page=&amp;cat=">
		<table cellspacing="0" cellpadding="0" width="100%" tab="<?=Funcs::$uri[1]?>" class="spisok">
			<thead>
				<tr>
					<th class="header">Название</th>
					<th class="header">Путь</th>
					<th class="header">Расписание</th>
					<th class="header">Последний запуск</th>
					<th width="120" class="header" colspan="3">Действия</th>
				</tr>
			</thead>
			<tbody>
			<?foreach($list as $item):?>
				<tr id="row<?=$item['id']?>">
					<td><div class="doc_item"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$item['id']?>/"><?=$item['name']?></a></div></td>
					<td><?=$item['path']?></td>
					<td><?=$item['timing']?></td>
					<td><?=date('d.m.Y H:i',strtotime($item['mdate']))?></td>
					<td class="padd_5"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/showedit/?id=<?=$item['id']?>"><img height="16" width="15" title="Редактировать" alt="Редактировать" src="/<?=Funcs::$cdir?>/i/ic_edit.gif"></a></td>
					<td class="padd_5"><a href="javascript:;" class="visible" tab="<?=Funcs::$uri[1]?>" ids="<?=$item['id']?>"><img id="eye2" width="16" height="18" title="Опубликовать" alt="Опубликовать" src="/<?=Funcs::$cdir?>/i/<?if($item['visible']):?>v<?else:?>i<?endif?>.gif"></a></td>
	        		<td class="padd_5"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/del/?parent=<?=Funcs::$uri[2]?>&id=<?=$item['id']?>" onclick="return confirm('Удалить объект?')" title="удалить"><img border="0" src="/<?=Funcs::$cdir?>/i/ic_trash.gif" alt="удалить"></a></td>
				</tr>
			<?endforeach?>
			</tbody>
		</table>
	</form>
	<div class="gray_line_navigation">
		<table width="100%"><tbody><tr>
			<td width="20%">
				&nbsp;
			</td>
			<td width="60%">
				<?=PaginationWidget::run($pagination)?>
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