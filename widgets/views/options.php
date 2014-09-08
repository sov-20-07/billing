<form class="section_filters" id="optionsForm">
	<?foreach($list as $key=>$item):?>
		<?View::widget('options/'.$item['path'],$item)?>
	<?endforeach?>
	<br />
	<span id="optionsButton" class="show-but" path="" onclick="createOptionString();document.location.href=$(this).attr('path');"></span><br/><br/>
	<?/*?>
	                        <!-- мощность охлаждения -->
                        <div class="filter cooling_capacity">
                        	Мощность охлаждения
                            <span class="icon ic_help open_help"></span>
                            <div class="help_block"><div class="padds">
	                            <span class="icon ic_close" title="Закрыть"></span>
                                <div class="help_head">Мощность охлаждения&nbsp;<span class="icon ic_help"></span></div>
                                Типовой расчет позволяет найти мощность кондиционера для небольшого помещения: отдельной комнаты в квартире или коттедже, офиса площадью до 50 – 70 кв. м и других помещений, расположенных в капитальных зданиях.<br />
                                <a href="#" class="is_white">Подробное описание</a>
                            </div></div>
                            <select>
                            	<option>от 2,6 до 3,5 кВт (~50 м2)</option>
                            </select>
                        </div>
                        <!-- /мощность охлаждения -->
	<div class="control">
		<input type="submit" value="" class="is_button select" />
		<a href="/<?=implode('/',Funcs::$uri)?>/" class="pseudo is_gray">Сбросить</a>
	</div>
	<div class="found" style="top: 110px;display:none;"><div class="found_pos">
		<span class="right_corner"></span>
		<div class="found_padds">Найдено товаров: <span id="countgoods">54</span>. <a href="">Показать</a></div>
	</div></div>
	
	<input type="button" value="Подобрать товары" class="is_button is_button2 optbut" path="" onclick="document.location.href=$(this).attr('path');" />
	<a class="icon ic_close2 auto_icon" href="/<?=implode('/',Funcs::$uri)?>/"><span class="pseudo">Сбросить фильтр</span></a>
	<?*/?>
	<script>
	var mouseY=0;
	jQuery(document).ready(function(){
		$(document).mousemove(function(e){
			mouseY=e.pageY;
		}); 
	})
	var entered=0;
	var optionarr = {};
	var opthref='';
	
	function createOptionString(){
		$("#optionsForm input").each(function(){
			if($(this).attr('type')=='text'){
				if($(this).val()!=+$("input[name='hidden"+$(this).attr('name')+"']").val()){
					opthref+="&"+$(this).attr('name')+"="+$(this).val();
				}
			}else if($(this).attr('type')=='checkbox' && $(this).prop('checked')==true){
				opthref+="&"+$(this).attr('name')+"=1";
			}else if($(this).attr('type')=='radio' && $(this).prop('checked')==true){
				opthref+="&"+$(this).attr('name')+"="+$(this).val();
			}
		});
		$("#optionsForm textarea").each(function(){
			opthref+="&"+$(this).attr('name')+"="+$(this).val();
		});
		$("#optionsForm select").each(function(){
			if($(this).find("option:selected").val()!='all'){
				opthref+="&"+$(this).attr('name')+"="+$(this).find("option:selected").val();
			}
		});
		opthref=opthref.substr(1,opthref.length);
		if(opthref!=''){
			$("#optionsButton").attr("path","?opt&"+opthref);
		}else{
			$("#optionsButton").attr("path","<?=strpos($_SERVER['REQUEST_URI'],'?')!==false?substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?')):$_SERVER['REQUEST_URI']?>");
		}
	}
	var optionstr='?';
	function getOpt(name,obj,type){
		if(type=='ch'){
			optionarr[name]=obj.value;
		}else if(type=='cb'){
			if(obj.checked){
				optionarr[name][obj.value]=obj.value;
			}else{
				delete optionarr[name][obj.value];
			}
		}
		createOptstr();
	}
	function createOptstr(){
		optionstr='?';
		for (var key in optionarr) {
		    var val = optionarr [key];
		    if(val instanceof Array){
		    	for (var key2 in val) {
		    		var val2 = val [key2];
		    		optionstr+=key+"["+key2+"]="+val2+"&";
		    	}
		    }else{
		    	if(jQuery.trim(val)!='' && jQuery.trim(val)!='all'){
			    	optionstr+=key+"="+val+"&";
			    }
		    }
		}
		optionstr=optionstr.substr(0,optionstr.length-1);
		//alert(optionstr);
		if(optionstr=="")optionstr="<?=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'))?>";
		$('.optbut').attr('path',optionstr);
		if(entered==1){
			$.ajax({
				type: "POST",
				url: optionstr,
				data: "ajax=act",
				success: function(msg){
					//alert(msg+', '+mouseY);
					$('.found').css('top',mouseY-270).show();
					$('#countgoods').text(msg);
					if(msg>0){
						$('.found').find('a').text('Показать');
						$('.found').find('a').attr('href',optionstr);
						$('.optbut').attr('disabled',false);
					}else{
						$('.found').find('a').text('');
						$('.optbut').attr('disabled','disabled');
					}
				}
			});
		}
		entered=1;
	}
	createOptstr();
	</script>
</form>