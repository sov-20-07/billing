<div class="filter see_goods">
	Показывать
	<select name="industrial" id="shselect" onchange="shcatalog(this)">
		<option value="all">все товары</option>
		<option value="0" <?if($_GET['industrial']=='0'):?>selected<?endif?>>бытовые</option>
		<option value="1" <?if($_GET['industrial']=='1'):?>selected<?endif?>>промышленные</option>
	</select>
</div>
<script>
	function shcatalog(obj){
		if($('#shselect option:selected').val()==1){
			getOpt('ind',obj,'');
		}else if($('#shselect option:selected').val()==2){
			getOpt('ind',obj,'0');
		}else if($('#shselect option:selected').val()==3){
			getOpt('ind',obj,'1');
		}
	}
</script>