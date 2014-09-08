<?
class UserController extends Site{
	function __construct(){
		$seo=array();
		$seo['seo_title']='Пользователи';
		Funcs::setMeta($seo);
		if(is_numeric(Funcs::$uri[1]) && !Funcs::$uri[2]){
			$data=User::getOne(Funcs::$uri[1]);
			$data['list']=Catalog::getUserBooksList(Funcs::$uri[1]);
			View::render('user/one',$data);
		}
	}
}
?>