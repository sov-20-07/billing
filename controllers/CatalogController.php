<?
class CatalogController extends Site{
	function __construct(){
		if($_POST){
			DB::escapePost();
			if(isset($_POST['report'])){
				$tree=Tree::getTreeByUrl();
				$href=Catalog::getPathToTree($tree['id']);
				Catalog::setReport($tree['id']);
				View::$layout='empty';
				View::render('site/redirect',array('href'=>$href,'text'=>'Отзыв успешно добавлен!'));die;
			}if(isset($_POST['subscribe'])){
				$tree=Tree::getTreeByUrl();
				$href=Tree::getPathToTree($tree['id']);
				Catalog::setSubscribe($tree['id']);
				die;
			}
		}else{
			DB::escapeGet();
			if(Funcs::$uri[1]=='' && isset($_GET['hits']) && Funcs::$uri[1]!='setratingstars' && Funcs::$uri[1]!='delreport'){
				$tree=Tree::getTreeByUrl();
				Funcs::setMeta($tree);
				$tree=Catalog::getHitCatalog($tree['id']);
				View::render('catalog/catalog',array('list'=>$tree,'name'=>'Все хиты'));
			}elseif(Funcs::$uri[1]=='' && Funcs::$uri[1]!='setratingstars' && Funcs::$uri[1]!='delreport'){
				$tree=Tree::getTreeByUrl();
				Funcs::setMeta($tree);
				$tree=Catalog::getPreviewCatalog($tree['id']);
				//View::render('catalog/catalog',array('list'=>$tree));
			}elseif(Funcs::$uri[1]!='setratingstars' && Funcs::$uri[1]!='delreport'){
				$tree=Tree::getTreeByUrl(Funcs::$uri[0]);
				if($tree['info']['type']=='struct'){
					$temp=Catalog::getInnerListPagi($tree['id']);
					$tree['list']=$temp['list'];
					$tree['vendors']=Catalog::getVendors($tree['id'],$tree['list']);
					//$tree['options']['available']=array();					
					//$tree['options']['catalog']=Catalog::getType($tree['id'],$tree['parent']);
					//$tree['options']['vendors']=Catalog::getVendors($tree['id']);
					if($_GET['ve']){
						$tree['name']=$tree['seo_description']=$tree['name'].' '.Funcs::$referenceId['vendor'][$_GET['ve']]['name'];
						Funcs::setMeta($tree);
					}
					$tree['options']['price']=Catalog::getValuesPrice($tree['id']);
					$tree['options']['price2']=Catalog::getLink('pricelink');
					//$tree['options']['rating']=array();
					Funcs::setMeta($tree);
					$tree['quantity']=$temp['quantity'];
					if($_GET['ajax']=='act'){
						print $tree['quantity'];die;
					}else{
						View::render('catalog/list',$tree);
					}
				}else{
					Funcs::setMeta($tree,'goods');
					$id=$tree['id'];
					$tree=Catalog::getOne($id);
					Catalog::setPopularity($id);
					$tree['reports']=Catalog::getReports($id);
					Catalog::setViewed($id);
					$tree['same_price']=Catalog::getAdditionalgood($id,'better_for_same_price');
					$tree['accessories']=Catalog::getAdditionalgood($id,'accessories');
					//$tree['similargoods']=Catalog::getAdditionalgood($id,'similargoods');
					$tree['similargoods']=Catalog::getMore($tree['id'],$tree['parent']);
					$tree['reportme']=Catalog::getReport($tree['id']);
					if(isset($_GET['print'])){
						View::$layout='empty';
						View::render('catalog/print',$tree);die;
					}else{
						View::render('catalog/one',$tree);
					}
				}
			}
		}
	}
	public function setfavorite(){
		Catalog::setFavorite($_POST['id']);
	}
	public function delreport(){
		if(count($_SESSION['user'])>0){
			Catalog::delReport();
			$href=Catalog::getPathToTree($_GET['tree']);
			View::$layout='empty';
			View::render('site/redirect',array('href'=>$href,'text'=>'Отзыв успешно удален!'));
			die;
		}else{
			$href=Catalog::getPathToTree($_GET['tree']);
			View::$layout='empty'; 
			View::render('site/redirect',array('href'=>$href,'text'=>'Вы не зарегистрированы!'));
			die;
		}
	}
}
?>