<div class="option_block rating <?if($act==1):?>act<?endif?>">
	<div class="head sliding" id="opt6">Рейтинг<span class="icon down_arrow2 <?if($act==1):?>up_arrow2<?endif?>"></span></div>
	<div class="padds sliding_opt6">
		<label><input type="checkbox" value="5" onchange="getOpt('ra',this,'cb');" /><span class="stars s5"></span></label>
		<label><input type="checkbox" value="4" onchange="getOpt('ra',this,'cb');" /><span class="stars s4"></span></label>
		<label><input type="checkbox" value="3" onchange="getOpt('ra',this,'cb');" /><span class="stars s3"></span></label>
		<label><input type="checkbox" value="2" onchange="getOpt('ra',this,'cb');" /><span class="stars s2"></span></label>
		<label><input type="checkbox" value="1" onchange="getOpt('ra',this,'cb');" /><span class="stars s1"></span></label>
		<label class="with_review"><input type="checkbox" value="r" onchange="getOpt('ra',this,'cb');" />только с отзывами</label>
	</div>
</div>