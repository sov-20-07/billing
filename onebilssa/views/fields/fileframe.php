<!DOCTYPE html>
<!--[if IE 7]><html lang="ru" class="ie7"><![endif]-->
<html lang="ru">
	<head>
	    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
		<link href="/<?=ONESSA_DIR?>/css/reset.css" rel="stylesheet" type="text/css">
		<link href="/<?=ONESSA_DIR?>/css/style.css" rel="stylesheet" type="text/css">
		<script src="/<?=ONESSA_DIR?>/js/jquery-1.9.1.min.js"></script>
	</head>
	<body>
		<form enctype="multipart/form-data" method="post" action="/<?=ONESSA_DIR?>/fields/multiupload/" id="UploadForm">
			<input type="file" multiple style="display:none" name="upload[]" id="upload" onchange="$('.buttonwhite').hide();$('.imgwait').show();$('#UploadForm').submit();">
			<div class="button-white-upload"><span class="button-white buttonwhite" onclick="$('#upload').click();">Загрузить с компьютера</span></div>
			<img class="imgwait" src="/<?=Funcs::$cdir?>/i/wait18.gif" style="display:none;">
			<input type="hidden" name="id" value="<?=$_GET['id']?>">
			<input type="hidden" name="path" value="<?=$_GET['path']?>">
			<input type="hidden" name="parent" value="<?=$_GET['parent']?>">
		</form>
		<script>
			var onessapath="/<?=ONESSA_DIR?>/";
			<?foreach($ids as $id):?>
				$.ajax({
					type: "POST",
					url: onessapath+"fields/getfile/",
					data: "id=<?=$id?>&parent=<?=$_GET['parent']?>",
					success: function(msg){
						$(parent.document).find("#<?=$_GET['path']?>").append(msg);
						window.parent.resizeContent();
					}
				});
			<?endforeach?>
		</script>
	</body>
</html>