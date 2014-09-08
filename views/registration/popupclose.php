<script>
	<?if(isset($_GET['oid'])):?>
		opener.parent.location.href="<?=$path?>";
	<?else:?>
		opener.parent.location.reload();
	<?endif?>
	self.close();
</script>