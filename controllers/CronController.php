<?
class CronController extends Site{
	function __construct(){
		Cron::Report();
		Cron::Subscribe();
	}
}
?>