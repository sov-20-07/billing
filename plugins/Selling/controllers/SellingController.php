<?
class SellingController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			//$model=new Iuser;
			//$list=$model->getUndefinedUsers();
			View::plugin('index',array('list'=>$list));
		}
	}
	function authors(){
		if(Funcs::$uri[3]==''){
			$data['list']=Selling::getList(1);
			View::plugin('authors',$data);
		}else{
			View::plugin('author',Selling::getOne(Funcs::$uri[3]));
		}
	}
	function users(){
		if(Funcs::$uri[3]==''){
			$data['list']=Selling::getList(0);
			View::plugin('iusers',$data);
		}else{
			View::plugin('iuser',Selling::getOne(Funcs::$uri[3]));
		}
	}
	function export(){
		if(Funcs::$uri[3]=='authors'){
			Selling::export(1);
		}else{
			Selling::export(0);
		}
	}
}
?>