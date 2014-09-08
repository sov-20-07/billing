<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Система управления сайтом: </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="STYLESHEET" type="text/css" href="/onedvrssa/css/main.css">
	<link rel="STYLESHEET" type="text/css" href="/onedvrssa/css/add.css">
	<script src="/onedvrssa/dor/ckeditor.js" type="text/javascript"></script>

	<script src="/onedvrssa/js/jquery-1.7.1.min.js"></script>
	<script src="/onedvrssa/js/jquery-ui-1.8.17.custom.min.js"></script>
	<link href="/onedvrssa/js/jquery-ui-1.8.17.custom.css" rel="stylesheet" media="all" />
	<script src="/onedvrssa/js/jquery.cookie.js"></script>
	<script src="/onedvrssa/js/jquery.tablednd_0_5.js"></script>
	<script src="/onedvrssa/js/application.js" type="text/javascript"></script>
	<script src="/onedvrssa/js/tablesorter.js" type="text/javascript"></script>
	<script src="/onedvrssa/js/tablesorter_filter.js" type="text/javascript"></script>
	<script src="/onedvrssa/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
	<link href="/onedvrssa/js/jquery-ui-timepicker-addon.css" rel="stylesheet" media="all" />
	<script src="/onedvrssa/js/highslide-full.js" type="text/javascript"></script>
	<link href="/onedvrssa/js/highslide.css" rel="stylesheet" media="all" />
	<script src="/onedvrssa/dor/ckfinder/ckfinder.js" type="text/javascript"></script>
	<script src="/onedvrssa/js/jquery.dragsort.js" type="text/javascript"></script>
	<script src="/onedvrssa/js/multiselect/jquery.multiselect.min.js" type="text/javascript"></script>
	<link href="/onedvrssa/js/multiselect/jquery.multiselect.css" rel="stylesheet" media="all" />
	

	<link href="/onedvrssa/js/upload.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/onedvrssa/js/swfupload.js"></script>
	<script type="text/javascript" src="/onedvrssa/js/swfupload.queue.js"></script>	
	<script type="text/javascript" src="/onedvrssa/js/fileprogress.js"></script>
	<script type="text/javascript" src="/onedvrssa/js/handlers.js"></script>
	
	<script type="text/javascript">
		var onessapath="/<?=Funcs::$cdir?>/";
		hs.graphicsDir = "/onedvrssa/js/graphics/";
		hs.outlineType = "rounded-white";
		hs.wrapperClassName = "draggable-header";
		hs.dimmingOpacity = 0.80;
		hs.align = "center";
	</script>
	
</head><body>
<h3 style="margin-left: 10px;"><?=$title?></h3>
<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
	<div class="error"></div>
	<div id="frm">
		<div id="slider0" class="slider">
			<table id="workingset">
				<tbody>
					<?foreach(OneSSA::$iuserStandart as $path=>$item):?>
						<tr>
							<td class="form_param"><?=$item['name']?></td>
							<td class="form_field">
								<?if($item['type']=='string'):?>
									<input type="text" name="<?=$path?>" class="text <?if($item['required']==1):?>required<?endif?>" value="<?=$iuser[$path]?>" <?if($item['unique']==1):?>onchange="checkUnique('<?=$path?>')"<?endif?> style="width:200px" />
									<?if($item['unique']==1):?><span id="<?=$path?>" class="error" style="color:#FF0000;display:none;">Значение не уникальное</span><?endif?>
								<?elseif($item['type']=='text'):?>
									<textarea name="<?=$path?>" class="text" style="width:200px"><?=$iuser[$path]?></textarea>
								<?elseif($item['type']=='password'):?>
									<input type="text" name="<?=$path?>" class="text" id="<?=$path?>" value="<?/*=$iuser[$path]*/?>" style="width:200px" />
									<span class="pseudo" onclick="generatePass('<?=$path?>')">Сгенерировать</span>
								<?endif?>
							</td>
						</tr>
					<?endforeach?>
					<?foreach(OneSSA::$iuserStandartAdds as $title=>$items):?>
						<tr><td class="form_param" colspan="2"><b><?=$title?></b></td></tr>
						<?foreach($items as $path=>$item):?>
							<tr>
								<td class="form_param"><?=$item['name']?></td>
								<td class="form_field">
									<?if($item['type']=='string'):?>
										<input type="text" name="<?=$path?>" class="text <?if($item['required']==1):?>required<?endif?>" value="<?=$iuser[$path]?>" <?if($item['unique']==1):?>onchange="checkUnique('<?=$path?>')"<?endif?> style="width:200px" />
										<?if($item['unique']==1):?><span id="<?=$path?>" class="error" style="color:#FF0000;display:none;">Значение не уникальное</span><?endif?>
									<?elseif($item['type']=='select'):?>
										<select name="<?=$path?>" id="<?=$path?>">
											<option value=""></option>
											<?foreach(Funcs::$$item['data'] as $select):?>
												<option value="<?=$select['name']?>" <?if($iuser[$path]==$select['name']):?>selected<?endif?>><?=$select['name']?></option>
											<?endforeach?>
										</select>
									<?elseif($item['type']=='text'):?>
										<textarea name="<?=$path?>" class="text" style="width:200px"><?=$iuser[$path]?></textarea>
									<?elseif($item['type']=='password'):?>
										<input type="text" name="<?=$path?>" class="text" id="<?=$path?>" value="<?/*=$iuser[$path]*/?>" style="width:200px" />
										<span class="pseudo" onclick="generatePass('<?=$path?>')">Сгенерировать</span>
									<?endif?>
								</td>
							</tr>
						<?endforeach?>
					<?endforeach?>
					<tr>
						<td class="form_param" style="vertical-align: top">Группы</td>
						<td class="form_field">
							<select name="igroup">
								<option></option>
								<?foreach($groups as $item):?>
									<option value="<?=$item['id']?>" <?if($item['id']==$iuser['igroup']):?>selected<?endif?>><?=$item['name']?></option>
								<?endforeach?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<br />
	<input type="hidden" name="id" value="<?=$iuser['id']?>" />
	<input type="hidden" name="act" value="popup" />
	<input type="hidden" name="ordrerid" value="<?=$_GET['orderid']?>" />
	<center><input type="button" onclick="checkForm()" class="button save" value="Сохранить"></center>
	<br />
</form>
<script>
	function generatePass(name){
		var obj=$('#'+name);
		$.ajax({
			type: "GET",
			url: "/<?=Funcs::$cdir?>/iuser/generatepass/",
			data: "id=0",
			success: function(msg){
				obj.val(msg);
			}
		});
	}
	function checkUnique(name){
		var obj=$('#'+name);
		var value=$('[name='+name+']').val();
		var id=$('[name=id]').val();
		$.ajax({
			type: "POST",
			url: "/<?=Funcs::$cdir?>/iuser/checkfield/",
			data: "name="+name+"&value="+value+"&id="+id,
			success: function(msg){
				if(msg){
					obj.show();
				}else{
					obj.hide();
				}
			}
		});
	}
	function checkForm(){
		var f=0;
		$('#frm .required').each(function(){
			if (jQuery.trim($(this).val())==''){
				$(this).css('border','solid 1px red');
				f=1;
			}else{
				$(this).css('border','');
			}
		});
		$('#frm .error').each(function(){
			if (jQuery.trim($(this).val())!=''){
				f=1;
			}
		});
		if(f==1){
			 return false;
		}else{
			$('#frm').submit();
		}
	}
	var idFileInc=0;
	function addFile(){
		$('#uploadfiles').append('<span id="ifi'+idFileInc+'" ><input type="file" name="upload[]" /> <input type="text" name="filename[]" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onclick="delFileInput('+idFileInc+')" class="pseudo">[X]</span><br /></span>');
		idFileInc++;
	}	
	function delFileInput(id){
		$('#ifi'+id).detach();
	}
	function delFile(id){
		$('#'+id).detach();
	}
</script>
</body>
</html>