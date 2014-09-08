<h3>Выбор стоимости</h3>
<div class="slide-part" style="width: 190px;">
	<div class="inner">
		<div class="slider_in">
			от&nbsp;&nbsp;<input type="text" class="text" name="pf" value="<?=$_GET['pf']==''?$minv:$_GET['pf']?>" id="field_from" onkeyup="checknumbrintnull(this,<?=$_GET['pf']==''?$minv:$_GET['pf']?>);" />&nbsp;
			до&nbsp;&nbsp;<input type="text" class="text" name="pt" value="<?=$_GET['pt']==$maxv?'':$_GET['pt']?>" id="field_to" onkeyup="checknumbrintnull(this,<?=$_GET['pt']==''?$maxv:$_GET['pt']?>);" />
		</div>
		<div class="slider_pos"><div id="slider-range"></div></div>
	</div>
</div>
<input type="hidden" name="hiddenpf" value="<?=$minv?>" />
<input type="hidden" name="hiddenpt" value="<?=$maxv?>" />
<script>
	$(document).ready(function(){
		$( "#slider-range" ).slider({
				range: true,
				min: <?=$minv?>,
				max: <?=$maxv?>,
				step:  <?=round($maxv/100)?>,
				values: [<?=$_GET['pf']==''?$minv:$_GET['pf']?>, <?=$_GET['pt']==''?$maxv:$_GET['pt']?>],
				slide: function( event, ui ) {
					$("#field_from").val( $("#slider-range").slider("values", 0));
					$("#field_to").val( $("#slider-range").slider("values", 1 ));
				}
		});
		$("#field_from").val( $("#slider-range").slider("values", 0));
		$("#field_to").val( $("#slider-range").slider("values", 1));
	});
</script>