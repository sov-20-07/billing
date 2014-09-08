<select id="ModuleList" onchange="getModuleItems()">
	<option value=""></option>
	<?foreach($modules as $item):?>
		<option value="<?=$item['id']?>"><?=$item['name']?></option>
	<?endforeach?>
</select>
<div id="container"></div>
<script>
var path="/<?=Funcs::$cdir?>/";
function getModuleItems(obj){
	var id=$('#ModuleList option:selected').val();
	$.ajax({
		type: "POST",
		url: path+"work/getmoduleitems/",
		data: "id="+id+"&tree=<?=Funcs::$uri[1]?>",
		success: function(msg){
			$("#container").html(msg);
		}
	});
}
</script>