<li class="edit_form_section edit_form_section_other clearfix">
	<?=View::widget('fields/addtd')?>
	<table class="edit_form_table">
		<tr>
			<td><?=$name?></td>
			<td>
				<ul class="edit_form_multiselect multiselect<?=$path?>">
				<?if(empty($list)):?>
					<li>Не выбрано ни одного элемента</li>
				<?else:?>
					<?foreach($list as $item):?>
						<li>
							<label class="form_label jsPreviewToggle" <?if($item['gal'][0]['path']):?>data-src="/of/<?=$item['gal'][0]['path']?>?h=100&w=100&c=1"<?endif?>>
								<input type="checkbox" name="data[<?=$path?>][]" value="<?=$item['value']?>" checked><span class="form_label_text"><?=$item['name']?></span>
							</label>
						</li>
					<?endforeach?>
				<?endif?>
				</ul>
				<a href="/<?=Funcs::$cdir?>/fields/treeselect/?id=<?=$id?>&tree=<?=$_GET['id']?>&path=<?=$path?>" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 500, height: 500,contentId: 'highslide-html', cacheAjax: false } ); return false;" class="button-white uploadtree">
					<?if(empty($list)):?>Добавить<?else:?>Изменить<?endif?>
				</a>
				<input type="hidden" class="text" value="empty" name="data[<?=$path?>][]">
				<input type="hidden" class="text" value="treeselect" name="fieldtypes[]">
				<input type="hidden" class="text" value="<?=$id?>" name="fieldrelations[<?=$path?>]">
			</td>
		</tr>
	</table>
	<script>
		$(document).ready(function(){
			$('.imgover').hover(
				function(){
					$(this).css('font-weight','bold').next().show();
				},
				function(){
					$(this).css('font-weight','').next().hide();
				}
			);
		});
		function recalcTreeSel<?=$path?>(ids){
			var select = $('.multiselect<?=$path?>');
			select.text('');
			var items = ids.split("|||4|||");
			for (var key in items) {
			    var val = items [key];
				var text = val.split("!__e3__!");
				select.append("<li><label class='form_label jsPreviewToggle'><input type='checkbox' name='data[<?=$path?>][]' value='"+text[0]+"' checked><span class='form_label_text'>"+text[1]+"</span></label></li>");				
			}
			
			select.find('input').iCheck({
				labelHover: false,
				cursor: true
			});
			select.next().text('Изменить');
			resizeContent();
		}
	</script>
</li>