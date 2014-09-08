<?
$redirectArray=array(
);
$uriRed=$_SERVER['REQUEST_URI'];
if(array_key_exists($uriRed,$redirectArray)) {
header('HTTP/1.1 301 Moved Permanently');
header('Location: '.$redirectArray["$uriRed"]);
exit();
}
?>
