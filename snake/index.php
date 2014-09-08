<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Тест</title>
    <meta name="description" content="Тест" />
    <meta name="keywords" content="Тест" />
    <link href="/temps/main.css" rel="stylesheet" type="text/css">
    <script src="/temps/jquery-1.6.2.min.js" type="text/javascript"></script>
    <script src="/temps/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	<script type="text/javascript"> 
	var snake=6;
	var snakeGO=0;
	var posX=150;
	var posY=150;
	var timeoutId;
	var dirx=1;
	var diry=0;
	var mousex=0;
	var mousey=0;
	var speed=100;
	var step=5;	
	var foodX=150;
	var foodY=150;
	/*alert(snakeX[0]);
	alert(snakeX[1]);
	alert(snakeX[2]);*/
	$(document).ready(function(){
		$(".go").css('top',posX);
		$(".go").css('left',posY);
		setFood();
		$(".go").clone().removeClass('go').prependTo(".field");
		$(".go").clone().removeClass('go').prependTo(".field");
		$(".go").clone().removeClass('go').prependTo(".field");
		$(".go").clone().removeClass('go').prependTo(".field");
		$(".go").clone().removeClass('go').prependTo(".field");
		$(".go").clone().removeClass('go').prependTo(".field");
		$(".field").hover(
			function (e) {
				mousex=e.pageX;
				mousey=e.pageY;
			}
		);
		$(".field").mousemove(
			function (e) {
				if(e.pageX>mousex && e.pageY==mousey){
					if(dirx!=-1){
						dirx=1;
						diry=0;
					}
				}else if(e.pageX<mousex && e.pageY==mousey){
					if(dirx!==1){
						dirx=-1;
						diry=0;
					}
				}else if(e.pageX==mousex && e.pageY>mousey){
					if(diry!==-1){
						dirx=0;
						diry=1;
					}
				}else if(e.pageX==mousex && e.pageY<mousey){
					if(diry!==1){
						dirx=0;
						diry=-1;
					}
				}
				mousex=e.pageX;
				mousey=e.pageY;
				off();
				on();
			}
		);
		$(document).keypress(function(e) {
			//alert(e.keyCode);
			if(e.keyCode==39){
				if(dirx!=-1){
					dirx=1;
					diry=0;
				}
			}else if(e.keyCode==37){
				if(dirx!==1){
					dirx=-1;
					diry=0;
				}
			}else if(e.keyCode==40){
				if(diry!==-1){
					dirx=0;
					diry=1;
				}
			}else if(e.keyCode==38){
				if(diry!==1){
					dirx=0;
					diry=-1;
				}
			}else if(e.keyCode==27){
				theend();
			}
			off();
			on();
		});
			
	});
	function setFood(){
		foodX=Math.round(Math.random()*80)*5;
		foodY=Math.round(Math.random()*80)*5;
		$(".food").css('top',foodY);
		$(".food").css('left',foodX);
	}
	function goSnake(){
		//alert(($(".snake").position().top+5*dirx)+"px");
		posX=$(".go").position().left+step*dirx;
		posY=$(".go").position().top+step*diry;
		var text='posX='+posX+'   posY='+posY+'<br>'+'foodX='+foodX+' foodY='+foodY+'<br>';
		
		$(".go").clone().removeClass('go').prependTo(".field");
		
		var ii=1;
		$(".field div").each(function(i){
			if($(this).position().left==posX && $(this).position().top==posY && ii>3){
				theend();
			}
			text+='<br>x'+ii+'='+$(this).position().left+' y'+ii+'='+$(this).position().top;
			ii++;
		});
		$(".data").html(text);
		
		if(posX>395){posX=5;}
		if(posX<0){posX=395;}
		if(posY>395){posY=5;}
		if(posY<0){posY=395;}
		if(posX==foodX && posY==foodY){
			setFood();
		}else{
			$(".field div:last-child").detach();
		}
		$(".go").css('left',posX+"px");
		$(".go").css('top',posY+"px");
	}
	function on() {
		timeoutId = setInterval("goSnake()", speed);
	} 
	function off() {
		clearInterval(timeoutId);
	}
	function theend(){
		off();
		var l=$(".field div").length-6;
		alert('The end \n Счет: '+l);
		document.location.reload();
	}
	</script> 
</head>
<body>
	<div class="field"></div>
	<div class="food"></div>
	<div class="snake go"></div>
	<div class="data"></div>
	<div class="title">MBSnake (ver 0.1 beta)</div>
</body>
</html>