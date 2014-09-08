<?
class RequestsController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$data['list']=Requests::getList();
			View::plugin('list',$data);
		}elseif(Funcs::$uri[2]=='export'){
			Requests::export();
		}elseif(Funcs::$uri[2]=='history'){
			if(Funcs::$uri[3]==''){
				View::plugin('history',Requests::history());
			}elseif(Funcs::$uri[3]=='export'){
				Requests::historyExport(); 
			}
		}else{
			if($_POST){
				Requests::setPaid($_POST['id']);
				$this->redirect('/requests/');
			}else{
				View::plugin('one',Requests::getOne(Funcs::$uri[2]));
			}
		}
	}
}
?>