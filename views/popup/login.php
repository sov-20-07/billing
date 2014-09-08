<div class="pop-up">
    <h3>Вход</h3>
    <form method="post" action="/registration/login/" id="simpleform" onsubmit="return checkForm();">
	    <input type="text" class="text required" value="" placeholder="Ваш e-mail" onblur="$(this).attr('placeholder','Ваш e-mail')" onfocus="$(this).attr('placeholder','')" name="email" style="width: 246px"/><br/>
	    <input type="password" class="text required" value="" placeholder="Ваш пароль" onblur="$(this).attr('placeholder','Ваш пароль')" onfocus="$(this).attr('placeholder','')" name="password" style="width: 246px"/><br/>
	    <span class="help"><a href="/popup/forgot/">Забыли пароль?</a><a href="/popup/registration/">Зарегистрируйтесь</a></span>
	    <input type="submit" class="send-sm-but" />
		<span class="doted" onclick="closeme()">Спасибо, не надо</span>
	</form>
	<div class="socila_input">
		<div class="label">Войдите через один из следующих сайтов:</div><br />
		<script src="//loginza.ru/js/widget.js" type="text/javascript"></script>
		<a href="https://loginza.ru/api/widget?token_url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/registration/login/')?>&provider=vkontakte" onclick="return openLoginza($(this))"><img src="/i/icons/vk.jpg" /></a>
		<a href="https://loginza.ru/api/widget?token_url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/registration/login/')?>&provider=facebook" onclick="return openLoginza($(this))"><img src="/i/icons/face.jpg" /></a>
		<a href="https://loginza.ru/api/widget?token_url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/registration/login/')?>&provider=twitter" onclick="return openLoginza($(this))"><img src="/i/icons/tw.jpg" /></a>
		<a href="https://loginza.ru/api/widget?token_url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/registration/login/')?>&provider=google" onclick="return openLoginza($(this))"><img src="/i/icons/google.jpg" /></a>
		<script>
			function openLoginza(obj){
				window.open(obj.attr('href'),'','width=500,height=500');
				return false;
			}
		</script>
	</div>
</div>
<script>
	function checkForm(){
		var f=0;
		$('#simpleform .required').each(function(){
			if (jQuery.trim($(this).val())==''){
				$(this).css('border','1px solid red');
				f=1;
			}else{
				$(this).css('border','');
			}
		});
		if (f==1){
			return false;
		}else{
			$('#simpleform').submit();
		}
	} 
</script>