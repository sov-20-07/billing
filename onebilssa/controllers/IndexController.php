<?
class IndexController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[1]==''){
			$data=array(
				'countTree'=>Index::getTree(),
				'version'=>Index::getVersion(),
			);
			View::render('site/index',$data);
		}elseif(Funcs::$uri[1]=='cache' && Funcs::$uri[2]=='clear'){
			Cache::clearCache();
			$this->redirect('/tools/');
		}elseif(Funcs::$uri[1]=='cache' && $_POST){
			Cache::clearOneCache();
		}else{
			$this->redirect('/work/'.Funcs::$uri[1].'/');
			/*
			$row=Index::getBindModule();
			if($row['id']){
				$this->redirect('/work/'.Funcs::$uri[1].'/');
			}else{
				View::render('site/bind',array('modules'=>Index::getModuleList()));
			}*/
		}
	}
}
?>