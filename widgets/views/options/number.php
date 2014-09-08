<div class="filter price">
	<?=$title?>
	<div class="inline_block">
		от<input type="text" class="text" name="<?=$name?>_f<?=$list['type']?>" value="<?=$_GET[$name.'_f'.$list['type']]==''?$list['minv']:$_GET[$name.'_f'.$list['type']]?>" id="<?=$name?>_field_from" onkeyup="checknumbrintnull(this,<?=$_GET[$name.'_f'.$list['type']]==''?$list['minv']:$_GET[$name.'_f'.$list['type']]?>);" />
		до<input type="text" class="text" name="<?=$name?>_t<?=$list['type']?>" value="<?=$_GET[$name.'_t'.$list['type']]==''?$list['maxv']:$_GET[$name.'_t'.$list['type']]?>" id="<?=$name?>_field_to" onkeyup="checknumbrintnull(this,<?=$_GET[$name.'_t'.$list['type']]==''?$list['maxv']:$_GET[$name.'_t'.$list['type']]?>);" />
	</div>
	<div class="slider_pos"><div id="slider-range<?=$name?>"></div></div>
</div>
<script>
	$(document).ready(function(){
		$( "#slider-range<?=$name?>" ).slider({
				range: true,
				min: <?=$list['minv']?>,
				max: <?=$list['maxv']?>,
				step:  <?=round($list['maxv']/100,2)?>,
				values: [<?=$_GET[$name.'_f'.$list['type']]==''?$list['minv']:$_GET[$name.'_f'.$list['type']]?>, <?=$_GET[$name.'_t'.$list['type']]==''?$list['maxv']:$_GET[$name.'_t'.$list['type']]?>],
				slide: function( event, ui ) {
					$("#<?=$name?>_field_from").val( $("#slider-range<?=$name?>").slider("values", 0));
					$("#<?=$name?>_field_to").val( $("#slider-range<?=$name?>").slider("values", 1));
				}
		});
		$("#<?=$name?>_field_from").val( $("#slider-range<?=$name?>").slider("values", 0));
		$("#<?=$name?>_field_to").val( $("#slider-range<?=$name?>").slider("values", 1));
	});
</script>