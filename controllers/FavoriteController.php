<?
class FavoriteController extends Site{
	function __construct(){
		if(Funcs::$uri[1]==''){
			$tree=Tree::getTreeByUrl(Funcs::$uri[0]);
			Funcs::setMeta($tree);
			$tree['list']=Catalog::getFavorite();
			//$tree['recommended']=Catalog::getRecommended();
			View::render('favorite/list',$tree);
		}
	}
	function add(){
		$count=Catalog::setFavorite($_POST['id']);
		print $count;
		die;
	}
	function del(){
		$count=Catalog::delFavorite($_POST['id']);
		print $count;
		die;
	}
}
?>