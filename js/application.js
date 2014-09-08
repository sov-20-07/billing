$(document).ready(function(){
	$('.ic_defer').click(function(){
		var obj=$(this);
		$.ajax({
			type: "POST",
			url: "/favorite/add/",
			data: "id="+$(this).attr('ids'),
			success: function(msg){
				obj.addClass('on');
				obj.find('span').text('Отложено');
				$('#span_favorite').text(msg);
			}
		});
	});
	$('.defer').click(function(){
		$.ajax({
			type: "POST",
			url: "/favorite/add/",
			data: "id="+$(this).attr('ids'),
			success: function(msg){
				$('.deferred2').show();
				$('#span_favorite').text(msg);
			}
		});
	});
	$('.setstars span').click(function(){
		var obj=$(this).parent().parent();
		$.ajax({
			type: "POST",
			url: "/catalog/setratingstars/",
			data: "id="+$(this).parent().attr('ids')+"&num="+$(this).attr('ids'),
			success: function(msg){
				obj.removeClass('s1');
				obj.removeClass('s2');
				obj.removeClass('s3');
				obj.removeClass('s4');
				obj.removeClass('s5');
				obj.addClass('s'+msg);
				$(".setstars span").off();
			}
		});
	});
	$(".ic_minus_goods").click(function(){
		var id=$(this).attr("ids");
		var minus=Number($("#gnum"+id).val())-1;
		if(minus>0){
			$("#gnum"+id).val(minus);
		}
		if(minus==1){
			$(this).attr("disabled","disabled");
		}
	});
	$(".ic_plus_goods").click(function(){
		var id=$(this).attr("ids");
		var plus=Number($("#gnum"+id).val())+1;
		$("#gnum"+id).val(plus);
		if(plus>1){
			$(this).prev().prev().attr("disabled",false);
		}
	});
	$(".popup_atb").click(function(){
		$(".popup_layer .popup_window.call_width").addClass("n_act");
		$(".popup_layer .popup_window.added_width").addClass("act");
		$(".popup_layer").fadeIn(150);
	});
	$('.add_to_favorite').click(function(){
		$.ajax({
			type: "POST",
			url: "/favorite/add/",
			data: "id="+$(this).attr('ids'),
			success: function(msg){
				$('#favorite').text(msg);
				AlertBox(300,150,'Отложенные','Добавлено в отложенные','продолжить','close','в отложенные','/favorite/' );
			}
		});
	});
	$('.del_from_favorite').click(function(){
		var id=$(this).attr('ids');
		$.ajax({
			type: "POST",
			url: "/favorite/del/",
			data: "id="+id,
			success: function(msg){
				$('#tr'+id).detach();
				if($('.default.basket_goods tr').length==1){
					$('.default.basket_goods').detach();
				}
				$('#favorite').text(msg);
				$('#h1favorite').text(msg);
			}
		});
	});
	$('.add_to_compare').click(function(){
		$.ajax({
			type: "POST",
			url: "/compare/add/",
			data: "id="+$(this).attr('ids'),
			success: function(msg){
				AlertBox(300,150,'Сравнение','Добавлено к сравнению','продолжить','close','сравнить','/compare/' );
			}
		});
	});
	$('.del_from_compare').click(function(){
		var id=$(this).attr('ids');
		$.ajax({
			type: "POST",
			url: "/compare/del/",
			data: "id="+id,
			success: function(msg){
				/*$('#tr'+id).detach();
				if($('.default.basket_goods tr').length==1){
					$('.default.basket_goods').detach();
				}
				$('#favorite').text(msg);
				$('#h1favorite').text(msg);*/
			}
		});
	});
	$('#mailbutton').click(function(){
		if(jQuery.trim($('#mailname').val())=='' || jQuery.trim($('#mailname').val())=='Ваше имя' || jQuery.trim($('#mailphone').val())=='' || jQuery.trim($('#mailphone').val())=='Номер телефона'){
			alert('Введите ваше имя и номер телефона');
		}else{
			$.ajax({
				type: "POST",
				url: "/popup/sendcallback/",
				data: "name="+$('#mailname').val()+"&phone="+$('#mailphone').val(),
				success: function(msg){
					$('.callback').hide();
					$('.callback').html('Спасибо! Наши операторы свяжуться с Вами в ближайшее время');
					$('.callback').show();
				}
			});
		}
	});
});
function isEmailCorrect(email) { 
	var x=0;
	if(email.indexOf('@')<1)x=1;
	if(email.indexOf('.')<2)x=1;
	if(x==0) 
	    return true; 
	else { 
	    return false; 
	} 
}
function checknumbrint(obj,def) {
	var anum=/(^\d+$)|(^\d+\.\d+$)/;
	if (anum.test(obj.value)) {
		return true;
	}
	//alert('Введите число!');
	if(!def)def=0;
	obj.value=def;
	return false;
}
function checknumbrintnull(obj,def) {
	if(jQuery.trim(obj.value)!=''){
		var anum=/(^\d+$)|(^\d+\.\d+$)/;
		if (anum.test(obj.value)) {
			return true;
		}
		//alert('Введите число!');
		if(!def)def='';
		obj.value=def;
	}
}
function sendcallback(){
	var f=0;
	$('#callbackform .required').each(function(){
		if (jQuery.trim($(this).val())=='Как к вам обратиться?' || jQuery.trim($(this).val())=='Ваш телефон?' || jQuery.trim($(this).val())==''){
			$(this).css('border','solid 1px red');
			f=1;
		}else{
			$(this).css('border','');
		}
	});
	if (f==1){
		 return false;
	}else {
		var quickly='Нет'; 
		if($('#quickly').prop('checked')) quickly='Да';
		$.ajax({
			type: "POST",
			url: "/popup/sendcallback/",
			data: "name="+$('#callname').val()+"&phone="+$('#callphone').val()+"&quickly="+quickly,
			success: function(msg){
				closeCall();
			}
		});
	}
}
function sendmailback(){
	var f=0;
	$('#mailbackform .required').each(function(){
		if (jQuery.trim($(this).val())=='Как к вам обратиться?' || jQuery.trim($(this).val())=='Ваш телефон?' || jQuery.trim($(this).val())==''){
			$(this).css('border','solid 1px red');
			f=1;
		}else{
			$(this).css('border','');
		}
	});
	if (f==1){
		 return false;
	}else {
		$.ajax({
			type: "POST",
			url: "/popup/sendmailback/",
			data: "name="+$('#mailname').val()+"&phone="+$('#mailphone').val()+"&email="+$('#mailemail').val()+"&message="+$('#mailmessage').val(),
			success: function(msg){
				closeCall();
			}
		});
	}
}
function sendNewsSubscribe(obje){
	if (isEmailCorrect($('#emailsubscribe').val())==false){
		 return false;
	}else {
		var obj=obje;
		$.ajax({
			type: "POST",
			url: "/popup/newssubscribe/",
			data: "email="+$('#emailsubscribe').val(),
			success: function(msg){
				obj.parents('.pop-up').fadeOut(300);
				AlertBox(300,150,'Подписка','Вы успешно подписаны на рассылку','продолжить','close','','');
			}
		});
	}
}
function showCallback(){
//$('.popup_layer iframe').attr("src", "/popup/callback/");
//$('.popup_layer iframe').attr("width", "320");
//$('.popup_layer iframe').attr("height", "230");
$(".popup_layer .popup_window.added_width").attr("style", "");
$(".popup_layer .popup_window.added_width #callback").show();
$(".popup_layer .popup_window.added_width #same_price").hide();
	$(".popup_layer .popup_window.added_width").addClass("act");
	$(".popup_layer").fadeIn(150);
}

function showSamePrice(id){
//$('.popup_layer iframe').attr("width", "590");
//$('.popup_layer iframe').attr("height", "380");
//$('.popup_layer iframe').attr("src", "/popup/sameprice/?id="+id);
$(".popup_layer .popup_window.added_width").attr("style", "width: 590px; height: 380px;");
$(".popup_layer .popup_window.added_width #callback").hide();
$(".popup_layer .popup_window.added_width #same_price").show();
	$(".popup_layer .popup_window.added_width").addClass("act");
	$(".popup_layer").fadeIn(150);
}