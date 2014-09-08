<?
class PanelWidget{
	function run(){
		$data['viewed']=Catalog::getViewed();
		//$data['favorite']=Catalog::getFavorite();
		View::widget('panel',$data);
		if(count($data)>0 && $_SESSION['showpanel']==0)$_SESSION['showpanel']=1;
	}
	function vert(){
		$data['viewed']=Catalog::getViewed();
		//$data['favorite']=Catalog::getFavorite();
		View::widget('panel/vert',$data);
	}
	function hor(){
		$data['viewed']=Catalog::getViewed();
		//$data['favorite']=Catalog::getFavorite();
		View::widget('panel/hor',$data);
	}
}
?>