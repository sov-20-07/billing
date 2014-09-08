<div class="ltCell cell_site-tree sizeParent jsSizeable">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="widget_search input_text_holder"><span class="icon_search"></span><input type="text" class="input_text treeSearchInput" onkeyup="treeSearch()"></div>
			<div class="treeSearchResult"></div>
			<hr class="widget_search_separator">
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll grayOverflow">
					<?if(count($tree)==0):?>

					<?else:?>
						<ul class="catalog-menu main catalog-menu_item active">
						<?foreach($tree as $item):?>
							<li class="catalog-menu_item jsMenuItem jsOpened jsCurrent active">
								<a class="catalog-menu_link main" href="/<?=Funcs::$cdir?>/work/<?=$item['id']?>/"><?=$item['name']?> <span class="catalog-menu_toggle"></span></a>											
								<?if(count($item['sub'])>0):?>
									<?View::render('tree/branch',$item)?>
								<?endif?>
							</li>
						<?endforeach?>
						</ul>
					<?endif?>
				</div>
			</div>
		</div>
		<div class="ltRow cell_site-tree_footer">
		</div>
	</div>
</div>
<script>
	function treeSearch(){
		$.ajax({
			type: "POST",
			url: onessapath+"tree/getsearch/",
			data: "q="+$(".treeSearchInput").val(),
			success: function(msg){
				$(".treeSearchResult").html(msg);
			}
		});
	}
</script>
<?/*if(count($tree)==0):?>
	Не создана главная страница сайта<br /><br />
	<span onclick="$('.treeform').slideToggle()" class="pseudo">Добавить</span><br /><br />
<?else:?>
	<div class="menutree">
		<ul id="tree">
		<?foreach($tree as $item):?>
			<li>
				<div id="tmc<?=$item['id']?>" <?if($item['selected'] && count($item['sub'])>0):?>class="menuminus" onclick="treemenuClick(<?=$item['id']?>)"<?elseif($item['inner']):?>class="menuplus" onclick="treemenuClick(<?=$item['id']?>)"<?else:?>class="menudot"<?endif?>></div>
				<a href="/<?=Funcs::$cdir?>/<?=$item['id']?>" <?if($item['selected']):?>class="selected"<?endif?>><?=$item['name']?></a>
				<div class="holder<?=$item['id']?>"></div>
				<?if(count($item['sub'])>0):?>
					<?View::render('tree/branch',$item)?>
				<?endif?>
			</li>
		<?endforeach?>
		</ul>
	</div>
	<script>
		function treemenuClick(id){
			if($("#tmc"+id).hasClass('menuminus')){
				$("#tmc"+id).parent().find('ul').slideUp('fast', function() {
					$("#tmc"+id).parent().find('ul').detach();
  				});
				$("#tmc"+id).removeClass('menuminus');
				$("#tmc"+id).addClass('menuplus');
			}else{
				var obj=$("#tmc"+id).parent();
				$.ajax({
					type: "POST",
					url: onessapath+"tree/treemenu/",
					data: "id="+id,
					success: function(msg){
						obj.append(msg);
					}
				});
				$("#tmc"+id).removeClass('menuplus');
				$("#tmc"+id).addClass('menuminus');
			}
		}
	</script>
<?endif?>
<div class="treeform" style="display:none">
	<form action="/<?=Funcs::$cdir?>/tree/add" method="post">
		<table>
			<tr>
				<td width="100">Название:</td>
				<td><input type="text" name="name" value="<?if(count($tree)==0):?>Главная страница<?endif?>" /></td>
			</tr>
			<tr>
				<td>Путь</td>
				<td><input type="text" name="path" value="<?if(count($tree)==0):?>index<?endif?>" /></td>
			</tr>
			<tr style="display:none">
				<td>
					<div>
						<input type="text" name="seo_title" /><br />
						<input type="text" name="seo_keywords" /><br />
						<input type="text" name="seo_description" /><br />
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="hidden" name="parent" value="0" />
					<input type="hidden" name="id" value="0" />
					<input type="submit" value="Добавить" />
				</td>
			</tr>
		</table>
	</form>
</div>

<div class="treesort"></div>

</div>
<div class="standart_menu">
	<div class="section_header minus_padd">Поиск по дереву</div>

	<input type="text" class="treeSearchInput" onkeyup="treeSearch()">
	<div class="treeSearchResult"></div>
	<script>
		function treeSearch(){
			$.ajax({
				type: "POST",
				url: onessapath+"tree/getsearch/",
				data: "q="+$(".treeSearchInput").val(),
				success: function(msg){
					$(".treeSearchResult").html(msg);
				}
			});
		}
	</script>
<?*/?>