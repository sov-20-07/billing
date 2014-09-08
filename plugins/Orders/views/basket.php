<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<script src="/<?=Funcs::$cdir?>/js/jquery-1.7.1.min.js"></script>
	</head>
	<body>
		<script>
		$(function(){
			$("#q").keyup(function(){
				var q=$(this).val();
				$.ajax({
					type: "POST",
					url: "/<?=Funcs::$cdir?>/orders/basket/",
					data: "id=<?=$_GET['id']?>&q="+q,
					success: function(msg){
						$(".search").html(msg);
					}
				});
				
			});	
		});
		</script>
		<h3>Поиск товара</h3>
		<input type="text" id="q" >
		<div class="search"></div>
	</body>
</html>
