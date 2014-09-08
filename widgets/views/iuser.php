<script>
$(document).ready(function(){
	$('.enter-login-button').click(function(){
		$('.avtoriz').toggle();
	});
	$('.avtoriz .avtoriz-up .wrap .close').click(function(){
		$('.avtoriz').toggle();
	});
});
</script>
<div id="loginform">
	<?if($_SESSION['iuser']):?>
		<a href="/registration/logout/" class="menu-logout in-block font-12" title="Выйти"><img src="/i/logined.png" alt="Выйти" /></a>
		<a href="/cabinet/" class="menu-cabinet in-block font-12" title="Кабинет"><?=$_SESSION['iuser']['name']?></a>
	<?else:?>
		<span class="enter-login-button doted" onclick="return hs.htmlExpand(this, loginOptions );">Войти</span>
	<?endif?>
</div>