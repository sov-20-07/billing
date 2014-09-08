<?
class Sitemap{
	function getList(){
		$data=array();
		$xml=Sitemap::getSitemapXML();
		//$site=Control::getSite(Funcs::$siteDB);
		$sql='SELECT * FROM {{tree}} WHERE visible=1 ORDER BY mdate DESC, cdate DESC';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$info=Tree::getInfo($item['id']);
			if($info['id2']!=0 && $info['params']!=''){
				$path='http://'.$_SERVER['HTTP_HOST'].Tree::getPathToTree($item['id'],$info['params']);
			}else{
				$path='http://'.$_SERVER['HTTP_HOST'].Tree::getPathToTree($item['id']);
			}
			$data[]=array(
				'id'=>$item['id'],
				'name'=>$item['name'],
				'path'=>$path,
				'mdate'=>date('Y-m-d',strtotime($item['mdate'])),
				'changefreq'=>$xml[str_replace('/','_',$path)]['changefreq'],
				'priority'=>$xml[str_replace('/','_',$path)]['priority'],
				'checked'=>is_array($xml[str_replace('/','_',$path)])?'checked':'',
			);
		}
		return $data;
	}
	function save(){
		$text='<?xml version="1.0" encoding="UTF-8"?>
			<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		';
		foreach($_POST['ids'] as $id){
			$text.='
				<url>
					<loc>'.$_POST['loc'][$id].'</loc>
					<lastmod>'.$_POST['lastmod'][$id].'</lastmod>
					<changefreq>'.$_POST['changefreq'][$id].'</changefreq>
					<priority>'.$_POST['priority'][$id].'</priority>
				</url>
		   ';
		}
		$text.='
		</urlset>';
		file_put_contents($_SERVER['DOCUMENT_ROOT'].'/u/sitemap.xml',$text);
	}
	function getSitemapXML(){
		$data=array();
		$file=simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/u/sitemap.xml');
		foreach($file->url as $item){
			$data[str_replace('/','_',$item->loc)]=array(
				'loc'=>$item->loc,
				'lastmod'=>$item->lastmod,
				'changefreq'=>$item->changefreq,
				'priority'=>$item->priority,
			);
		}
		return $data;
	}
}
?>