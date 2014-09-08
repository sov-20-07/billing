<?
class PaginationWidget{
	public static $count=0;
	function run(){
		$items=PaginationWidget::getPage($_SESSION['user']['perpage'],PaginationWidget::$count);
		View::widget('pagination',array('pagination'=>$items));
	}
	protected function getPage($perpage,$count){
		if($count==0)return FALSE;
		if(ceil($count/$perpage)==1)return FALSE;
		$page=$_GET['p'];
		if($page=='')$page=1;
		elseif($perpage=='all')return array();
		$items=array();
		$items['pages'][]=1;
		if(ceil($count/$perpage)==7){
			for($i=2;$i<ceil($count/$perpage);$i++){
				$items['pages'][]=$i;
			}
		}else{
			if(($page<=5 && ceil($count/$perpage)<=5)){
				for($i=2;$i<ceil($count/$perpage);$i++){
					$items['pages'][]=$i;
				}
			}elseif($page<5 && ceil($count/$perpage)>5){
				for($i=2;$i<=5;$i++){
					$items['pages'][]=$i;
				}
			}
			if(ceil($count/$perpage)>5 && $page>4 && $page<ceil($count/$perpage)-3){
				$items['pages'][]='-';
				for($i=$page-2;$i<=$page+2;$i++){
					$items['pages'][]=$i;
				}
				$items['pages'][]='-';
			}elseif(ceil($count/$perpage)>5 && $page<5){
				$items['pages'][]='-';
			}
			if(ceil($count/$perpage)>5 && $page>ceil($count/$perpage)-4){
				$items['pages'][]='-';
				for($i=ceil($count/$perpage)-4;$i<=ceil($count/$perpage)-1;$i++){
					$items['pages'][]=$i;
				}
			}
		}
		$items['pages'][]=ceil($count/$perpage);
		return $items;
	}
}
?>