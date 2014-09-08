var snake=6;
var snakeGO=0;
var posX=256;
var posY=256;
var timeoutId;
var dirx=1;
var diry=0;
var mousex=0;
var mousey=0;
var speed=300;
var step=64;	
var foodX=64;
var foodY=64;
var stopme=0;
/*alert(snakeX[0]);
alert(snakeX[1]);
alert(snakeX[2]);*/
var NAVIGATION = [37, 38, 39, 40];
$(document).ready(function(){
	document.body.addEventListener("keydown", function(event) {
		if (-1 != NAVIGATION.indexOf(event.keyCode))event.preventDefault();
	})
	$(".go").css('top',posX);
	$(".go").css('left',posY);
	setFood();
	$(".go").clone().removeClass('go').prependTo(".field");
	$(".go").clone().removeClass('go').prependTo(".field");
	$(".go").clone().removeClass('go').prependTo(".field");
	$(".field").hover(
		function (e) {
			mousex=e.pageX;
			mousey=e.pageY;
		}
	);
	$(document).keydown(function(e) {
		var e = e || window.event;
		//alert(e.keyCode);
		if(stopme==0){
			if(e.keyCode==39){
				if(dirx!=-1){
					dirx=1;
					diry=0;
					$('.snhead').removeClass('left').removeClass('up').removeClass('down').addClass('right');
				}
			}else if(e.keyCode==37){
				if(dirx!==1){
					dirx=-1;
					diry=0;
					$('.snhead').removeClass('up').removeClass('down').removeClass('right').addClass('left');
				}
			}else if(e.keyCode==40){
				if(diry!==-1){
					dirx=0;
					diry=1;
					$('.snhead').removeClass('left').removeClass('up').removeClass('right').addClass('down');
				}
			}else if(e.keyCode==38){
				if(diry!==1){
					dirx=0;
					diry=-1;
					$('.snhead').removeClass('left').removeClass('down').removeClass('right').addClass('up');
				}
			}else if(e.keyCode==27){
				theend();
			}
			stopme=1;
		}
		//off();
		//on();
	});
	on();
});
function setFood(){
	foodX=Math.round(Math.random()*13)*64;
	foodY=Math.round(Math.random()*6)*64;
	var s=0;
	$(".field div").each(function(i){
		if(Math.round($(this).position().left)==foodX && Math.round($(this).position().top)==foodY){
			s=1;
		}
	});
	if(s==0){
		$(".food").css('top',foodY);
		$(".food").css('left',foodX);
	}else{
		setFood();
	}
}
function goSnake(){
	//alert(($(".snake").position().top+5*dirx)+"px");
	posX=Math.round($(".go").position().left+step*dirx);
	posY=Math.round($(".go").position().top+step*diry);
	//var text='posX='+posX+'   posY='+posY+'<br>'+'foodX='+foodX+' foodY='+foodY+'<br>';
	
	$(".go").clone().removeClass('go').prependTo(".field");
	
	var ii=1;
	$(".field div").each(function(i){
		if(Math.round($(this).position().left)==posX && Math.round($(this).position().top)==posY && ii>3){
			theend();
		}
		//text+='<br>x'+ii+'='+$(this).position().left+' y'+ii+'='+$(this).position().top;
		ii++;
	});
	//$(".data").html(text);
	
	if(posX>832){posX=0;}
	if(posX<0){posX=832;}
	if(posY>384){posY=0;}
	if(posY<0){posY=384;}
	if(posX==foodX && posY==foodY){
		setFood();
		$('.score').text($('.score').text()*1+10);
		$('.scorepop').text($('.score').text());
	}else{
		$(".field div:last-child").detach();
	}
	$(".go").css('left',posX+"px");
	$(".go").css('top',posY+"px");
	stopme=0;
}
function on() {
	timeoutId = setInterval("goSnake()", speed);
} 
function off() {
	clearInterval(timeoutId);
}
function theend(){
	off();
	$('.pop404').show();
}