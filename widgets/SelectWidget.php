<?
class SelectWidget{
	function run(){
		$list=Autopark::getSelect();
		View::widget('select',array('list'=>$list));
	}
}
?>