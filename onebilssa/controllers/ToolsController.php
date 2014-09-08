<?
class ToolsController extends Site{
	function __construct(){
		$this->checkRights();
		if(Funcs::$uri[2]==''){
			if(CACHE_DIR)$cache=Index::getCountCache();
			else $cache=0;
			$data=array(
				'version'=>Index::getVersion(),
				'countCache'=>$cache
			);
			View::render('tools/index',$data);
		}
	}
	public function redirects(){
		if($_POST){
			Tools::setRedirects();
			$this->redirect('/tools/redirects/');
		}else{
			View::render('tools/redirects',Tools::getRedirectsList());
		}
	}
	public function delredirects(){
		Tools::delRedirects();
		$this->redirect('/tools/redirects/');
	}
	public function properties(){
		if($_POST){
			Tools::saveProperties();
			Funcs::getProperties();
			$this->redirect('/tools/properties/');
		}else{
			$data['list']=Tools::getPropertiesList();
			View::render('tools/properties/list',$data);
		}
	}
	public function research(){
		if($_POST){
			Research::setSearch();
			$this->redirect('/tools/research/');
		}else{
			View::render('tools/research/search',Research::getSearch());
		}
	}
	public function sitemap(){
		if($_POST){
			Sitemap::save();
			$this->redirect('/tools/sitemap/');
		}else{
			View::render('tools/sitemap/list',array('list'=>Sitemap::getList()));
		}
	}
	public function exportdb(){
		Tools::exportDB();
	}
	public function importdb(){
		Tools::importDB();
		$this->redirect('/tools/');
	}
	public function sql(){
		if($_POST){
			$data=Tools::getSql();
			$data['list']=Tools::execSql($_POST['query']);
			View::render('tools/sql',$data);
		}else{
			$data=Tools::getSql();
			View::render('tools/sql',$data);
		}
	}
	public function phpinfo(){
		print View::getRenderEmpty('tools/phpinfo');
	}
}
?>