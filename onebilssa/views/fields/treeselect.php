<div class="ltRow">
	<header class="hspopup_header">
		<?=$name?>
		<span class="hspopup_close" onClick="window.parent.hs.close();" title="Закрыть"></span>
	</header>
</div>

<section class="ltRow jsScrollContainer">
	<div class="jsScrollWrapper">
		<div class="jsScroll hspopup_scroll_layout whiteOverflow edit_container">
			<div class="hspopup_scroll_content">

				<ul class="treeselect_list">
				<?foreach($list as $item):?>
					<li class="treeselect_item">
						<div class="jsBranchHeader">
							<input type="checkbox" name="data[<?=$path?>][]" value="<?=$item['value']?>" <?=$item['checked']?>>
							<span class="treeselect_branch_toggle <?if(count($item['sub'])>0):?>jsBranchToggle treeselect_branch_toggle_hover<?endif?> <?if($item['gal'][0]['path']):?>imgover<?endif?>" style="padding-left: <?=$item['left']*10?>px"> 
								<span class="treeselect_label"><?=$item['name']?></span> <?if($item['admin']):?>(<?=$item['admin']?>)<?endif?>
								<?if($item['gal'][0]['path']):?><img src="/of/<?=$item['gal'][0]['path']?>?h=100&w=100&c=1" /><?endif?> 
							</span>
						</div>
						<?=View::getRenderEmpty('fields/treeselectbranch',$item)?>
					</li>
				<?endforeach?>
				</ul>
				
			</div>
		</div>
	</div>
</section>

<section class="ltRow">
	<div class="hspopup_buttons">
		<span class="button-white" onclick="sendCheckbox()">Сохранить</span>
		<span class="button-white" onclick="window.parent.hs.close();">Закрыть</span>
	</div>
</section>
	
<script>
	function sendCheckbox(){
		var ids='';
		$('input:checkbox:checked').each(function(){
			ids=ids+$(this).val()+"!__e3__!"+$(this).closest(".jsBranchHeader").find(".treeselect_label").text()+"|||4|||";
		});
		ids=ids.substr(0,ids.length-7);
		window.parent.recalcTreeSel<?=$field?>(ids);
		window.parent.hs.close();
	}
	
	$(document).ready( function(){
		$(".jsBranchToggle").on( "click", function(){
			$(this).closest(".jsBranchHeader").next().slideToggle(400,"easeInOutQuart", function(){ resizeContent(); });
		});
	});
</script>