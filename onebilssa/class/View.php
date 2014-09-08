<?
class View{
	public static $layout='main';
	public static function render($templ,$row=array()){
		if($row['mdate']){
			$LastModified_unix = Funcs::MakeTime($row['mdate']);
			$LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix); 
			$IfModifiedSince = false; 
			if (isset($_ENV['HTTP_IF_MODIFIED_SINCE'])) $IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));  
			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) $IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
			if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {    
				header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
			}else{
				header('Last-Modified: '. $LastModified);
			}
		}
		print View::getRender($templ,$row);
		if(DEBUG==4){
			print '<pre style="background:#FF9999;border:2px solid #000000">';
			print_r($row);
			print '</pre>';
		}
	}
	public static function getRender($templ,$row=array()){
		foreach($row as $c6e0b8a9=>$c1608d6){
			eval('$'.$c6e0b8a9.'=$c1608d6;');
		}
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].Funcs::$OneSSA.'/views'.Funcs::$vpr.'/'.$templ.'.php');
			$str=ob_get_contents();
		ob_end_clean();
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].Funcs::$OneSSA.'/views'.Funcs::$vpr.'/layout/'.View::$layout.'.php');
			$layout=ob_get_contents();
		ob_end_clean();
		return str_replace('{content}',$str,$layout);
	}
	public static function getRenderEmpty($templ,$row=array()){
		foreach($row as $c6e0b8a9=>$c1608d6){
			eval('$'.$c6e0b8a9.'=$c1608d6;');
		}
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].Funcs::$OneSSA.'/views'.Funcs::$vpr.'/'.$templ.'.php');
			$str=ob_get_contents();
		ob_end_clean();
		return $str;
	}
	public static function getRenderOneSSAEmpty($templ,$row=array()){
		foreach($row as $c6e0b8a9=>$c1608d6){
			eval('$'.$c6e0b8a9.'=$c1608d6;');
		}
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].'/'.ONESSA_DIR.'/views/'.$templ.'.php');
			$str=ob_get_contents();
		ob_end_clean();
		return $str;
	}
	public static function getRenderFullEmpty($templ,$row=array()){
		foreach($row as $c6e0b8a9=>$c1608d6){
			eval('$'.$c6e0b8a9.'=$c1608d6;');
		}
		ob_start();
			include($_SERVER['DOCUMENT_ROOT']."/views/".$templ.".php");
			$str=ob_get_contents();
		ob_end_clean();
		return $str;
	}
	public static function widget($templ,$row=array()){
		foreach($row as $c6e0b8a9=>$c1608d6){
			eval('$'.$c6e0b8a9.'=$c1608d6;');
		}
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].Funcs::$OneSSA.'/widgets/views/'.$templ.'.php');
			$str=ob_get_contents();
		ob_end_clean();
		print $str;
	}
	public static function getWidget($templ,$row=array()){
		foreach($row as $c6e0b8a9=>$c1608d6){
			eval('$'.$c6e0b8a9.'=$c1608d6;');
		}
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].Funcs::$OneSSA.'/widgets/views/'.$templ.'.php');
			$str=ob_get_contents();
		ob_end_clean();
		return $str;
	}
	public static function plugin($templ,$row=array()){
		foreach($row as $c6e0b8a9=>$c1608d6){
			eval('$'.$c6e0b8a9.'=$c1608d6;');
		}
		$plugin = strtoupper(substr(Funcs::$uri[1],0,1)).substr(Funcs::$uri[1],1,strlen(Funcs::$uri[1]));
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].PLUGINS_DIR.$plugin.'/views/'.$templ.'.php');
			$str=ob_get_contents();
		ob_end_clean();
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].Funcs::$OneSSA.'/views/layout/'.View::$layout.'.php');
			$layout=ob_get_contents();
		ob_end_clean();
		print str_replace('{content}',$str,$layout);
	}
	public static function getPluginEmpty($templ,$row=array()){
		foreach($row as $c6e0b8a9=>$c1608d6){
			eval('$'.$c6e0b8a9.'=$c1608d6;');
		}
		$plugin = strtoupper(substr(Funcs::$uri[1],0,1)).substr(Funcs::$uri[1],1,strlen(Funcs::$uri[1]));
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].PLUGINS_DIR.$plugin.'/views/'.$templ.'.php');
			$str=ob_get_contents();
		ob_end_clean();
		return $str;
	}
	public static function getIncludeFiles($what){
		$data=array();
		$path=$_SERVER['DOCUMENT_ROOT'].PLUGINS_DIR;
		$dir=opendir($path);
		while($plugin= readdir($dir)){
			if($plugin!='..' && $plugin!='.'){
				if(file_exists($path.$plugin.'/'.$what.'/')){
					$subdir=opendir($path.$plugin.'/'.$what.'/');
					while($file=readdir($subdir)){
						if($file!='..' && $file!='.')$data[]=PLUGINS_DIR.$plugin.'/'.$what.'/'.$file;
					}
					closedir($subdir);
				}
			}
		}
		return $data;
	}
}
