<div class="search_container">
	<div class="left_part_search">
		<div class="title_searching">Выбрать себе автомобиль</div>
	</div>
	<div class="center_part_search">
		<label>
			<select id="selectedPath">
				<option></option>
				<?foreach($list as $key=>$item):?>
					<option value="<?=$item['path']?>"><?=$item['name']?></option>
				<?endforeach?>
			</select>
		</label>
	</div>
	<div class="right_part_search">
		<label><input type="button" class="submit" value="" onclick="goSelectedPath()" /></label>
	</div>
	<script>
		function goSelectedPath(){
			if($('#selectedPath option:selected').val()){
				document.location.href=$('#selectedPath option:selected').val();
			}
		}
	</script>
</div>