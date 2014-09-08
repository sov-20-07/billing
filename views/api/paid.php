<form id="submit" method="post" action="<?=Funcs::$conf['settings']['payresult']?>">
	<input type="hidden" name="token" value="<?=$_SESSION['iuser']['token']?>">
	<input type="hidden" name="request_id" value="<?=$_SESSION['iuser']['request_id']?>">
	<input type="hidden" name="user_id" value="<?=$_SESSION['iuser']['user_id']?>">
	<input type="hidden" name="amount" value="<?=$_SESSION['iuser']['amount']?>">
	<input type="hidden" name="currency" value="<?=$_SESSION['iuser']['currency']?>">
	<input type="hidden" name="pay_date" value="<?=date('YYYY-MM-DD hh:mm:ss')?>">
	<input type="hidden" name="result" value="<?=$result?>">
</form>
<script>
	document.getElementById('submit').submit();
</script>