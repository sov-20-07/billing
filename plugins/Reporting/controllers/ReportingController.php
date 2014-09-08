<?
class ReportingController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			$data['list']=Reporting::getList();
			View::plugin('list',$data);
		}elseif(Funcs::$uri[2]=='export'){
			Reporting::export();
		}
	}
}
?>