$(function(){
	$(".add_to_basket").click(function() {
		var id=$(this).attr("ids");
		var obj=$(this);
		$.ajax({
			type: "POST",
			url: "/basket/addtobasket/",
			data: "id="+id+"&num="+$(this).attr("num")+"&sale="+$(this).attr("sale"),
			success: function(msg){
				//$("#goods").text(msg.substr(msg.indexOf('_')+1,msg.length));
				//$("#sum").text(msg.substr(0,msg.indexOf('_')));
				$("#setbaskethere").html(msg);
				if(obj.attr('path')=='click'){
					document.location.href='/basket/';
				}else if(obj.attr('path')=='oneclick'){
					document.location.href='/basket/click/';
				}else if(obj.attr('path')=='popup'){
					$('#atbframe').attr('src','/popup/atb/?id='+obj.attr('ids'));
					$(".popup_layer .popup_window.added_width").addClass("act");
					$(".popup_layer").fadeIn(150);
				}else if(obj.attr('path')=='action'){
					addProductInToBasket();
				}
				//hs.htmlExpand( obj, {src:'/popup/atb/?id='+id, objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 440, height: 350,contentId: 'highslide-html', cacheAjax: false } );
			}
		});
	});
	$(".add_to_basket_click").click(function() {
		var id=$(this).attr("ids");
		var phone=$("#onclickphone").val();
		var num=$("#gnum"+id).val();
		var obj=$(this);
		if(jQuery.trim(phone)=='' || phone=='телефон'){
			AlertBox(200,150,'Ошибка','Введите номер телефона','продолжить','close','','');
		}else{
			$("#onclickphone").css('border','');
			$.ajax({
				type: "POST",
				url: "/basket/superclick/",
				data: "id="+id+"&num="+num+"&phone="+phone,
				success: function(msg){
					//obj.parent().parent().fadeOut(300);
	        		//$('.pop-link').css('z-index','1');
	        		AlertBox(300,150,'Корзина','Спсибо за покупку!<br />Наши операторы свяжутcя с Вами в ближайшее время','продолжить','close','','');
				}
			});
		}
	});
	$(".ic_minus_basket").click(function(){
		var id=$(this).attr("ids");
		var minus=Number($("#num"+id).val())-1;
		if(minus>0){
			$("#num"+id).val(minus);
			sendNum(id,minus);
		}
		if(minus==1){
			$(this).attr("disabled","disabled");
		}
	});
	$(".ic_plus_basket").click(function(){
		var id=$(this).attr("ids");
		var plus=Number($("#num"+id).val())+1;
		$("#num"+id).val(plus);
		if(plus>1){
			$(this).prev().prev().attr("disabled",false);
		}
		sendNum(id,plus);
	});
	$(".updowninput").change(function(){
		var id=$(this).attr("iname");
		sendNum(id,$("#num"+id).val())
	});	
	$(".delgoods").click(function(){
		var obj=$(this);
		if($(this).attr('favorite')!='yes'){
			if(!confirm('Вы уверены?'))return false;
		}
		var id=$(this).attr("ids");
		$.ajax({
			type: "POST",
			url: "/basket/delgoods/",
			data: "id="+id,
			success: function(msg){
				if(obj.attr('favorite')=='yes'){
					alert('Товар отложен');
				}
				if(msg=='empty') window.location.href='/basket/';
				var data=msg.split(';');
				$("#tdprice"+data[0]).text(data[2]);
				$("#sum").text(data[1]);
				$("#itogo").text(data[1]);
				$("#itogoall").text(data[1]);
				var tree=data[0].substr(0,data[0].indexOf('_'));
				$("#count"+tree).text(data[3]);
				$("#total"+tree).text(data[4]);
				$(".tr"+data[0]).detach();
				//удалить
				document.location.reload();
			}
		});
	});	
});
function sendNum(id,num){
	$.ajax({
		type: "POST",
		url: "/basket/sendnum/",
		data: "id="+id+"&num="+num,
		success: function(msg){
			var data=msg.split(';');
			$("#tdprice"+data[0]).text(data[5]);
			$("#tdsale"+data[0]).text(data[6]);
			$("#tdtotal"+data[0]).text(data[2]);
			$("#sale").text(data[7]);
			$("#sum").text(data[1]);
			$("#itogo").text(data[1]);
			$("#itogoall").text(data[1]);
			var tree=data[0].substr(0,data[0].indexOf('_'));
			$("#count"+tree).text(data[3]);
			$("#total"+tree).text(data[4]);
		}
	});
}
function basketIncRecalc(){
	$.ajax({
		type: "POST",
		url: "/basket/basketincrecalc/",
		data: "id="+id,
		success: function(msg){
			$("#setbaskethere").html(msg);
		}
	});
}