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
<div class="standart_menu_slim">
	<h3>Все авторизованные пользователи</h3>
	<fieldset>
		<legend>Фильтр</legend>
		Группа 
		<select id="groupselect" onchange="getUsersGroup()">
			<option value="all">Все</option>
			<?foreach($igroups as $item):?>
				<option value="<?=$item['id']?>" <?if($_GET['igroup']===$item['id']):?>selected<?endif?>><?=$item['name']?></option>
			<?endforeach?>
		</select>
		<br />
		Поиск &nbsp;<input type="text" id="q" value="<?=$_GET['q']?>" /> <input type="button" value="Найти" onclick="searchUsers()">
		<br /> 
		<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=Funcs::$uri[2]?>/">Сбросить все</a>
		<script>
			function getUsersGroup(){
				if($("#groupselect option:selected").val()=='all'){
					document.location.href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=Funcs::$uri[2]?>/";
				}else{
					document.location.href="?igroup="+$("#groupselect option:selected").val();
				}
			}
			function searchUsers(){
				if(jQuery.trim($("#q").val())!=''){
					document.location.href="?q="+$("#q").val();
				}
			}
		</script>
	</fieldset>
	<form id="ids_post" method="post" action="/<?=Funcs::$cdir?>/data/one?path=cmode&amp;parent=&amp;page=&amp;cat=">
		<table cellspacing="0" cellpadding="0" width="100%" tab="<?=Funcs::$uri[1]?>" class="spisok">
			<thead>
				<tr>
					<th class="header">Имя</th>
					<th class="header">Email</th>
					<th class="header">Телефон</th>
					<th class="header">Компания</th>
					<th class="header">Группа</th>
				</tr>
			</thead>
			<tbody>
			<?foreach($list as $item):?>
				<tr id="row<?=$item['id']?>">
					<td><a href="/<?=Funcs::$cdir?>/iuser/actselectuser/?ordrerid=<?=Funcs::$uri[3]?>&iuserid=<?=$item['id']?>"><?=$item['name']?></div></td>
					<td><?=$item['login']?></td>
					<td><a href="mailto:<?=$item['email']?>"><?=$item['email']?></a></td>
					<td><?=$item['phone']?></td>
					<td><?=$item['company']?></td>
					<td><?=$item['igroup']?></td>
				</tr>
			<?endforeach?>
			</tbody>
		</table>
	</form>
	<div class="gray_line_navigation">
		<table width="100%"><tbody><tr>
			<td width="20%">&nbsp;</td>
			<td width="60%">
				<?=PaginationWidget::run($pagination)?>
			</td>
			<td width="20%">
				<span class="light_gray">Выводить </span>
				<form method="post" action="/<?=Funcs::$cdir?>/tree/perpage/" style="display:inline">
					<select class="small_select" onchange="this.parentNode.submit()" name="new_kol">
                    	<option value="10" <?if($_SESSION['user']['perpage']==10):?>selected<?endif?>>10</option>
                    	<option value="20" <?if($_SESSION['user']['perpage']==20):?>selected<?endif?>>20</option>
                    	<option value="50" <?if($_SESSION['user']['perpage']==50):?>selected<?endif?>>50</option>
                    	<option value="5000000" <?if($_SESSION['user']['perpage']==5000000):?>selected<?endif?>>все</option>
                    	
					</select>
				</form>
				<img height="1" width="130" src="./i/pix.gif">
			</td>
		</tr></tbody></table>
	</div>
</div>
</body>
</html>