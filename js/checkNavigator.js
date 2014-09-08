(function(){ // определение типа браузера
var ua = navigator.userAgent, av = navigator.appVersion, v, i;
$is={};
$is.Opera = !!(window.opera && opera.buildNumber);
$is.WebKit = /WebKit/.test(ua);
$is.OldWebKit = $is.WebKit && !window.getSelection().getRangeAt;
$is.IE = !$is.WebKit && !$is.Opera && (/MSIE/gi).test(ua) && (/Explorer/gi).test(navigator.appName);
$is.IE6 = $is.IE && /MSIE [56]/.test(ua);
$is.IE5 = $is.IE && /MSIE [5]/.test(ua);
$is.Gecko = !$is.WebKit && /Gecko/.test(ua);
$is.Mac = ua.indexOf('Mac') != -1;
$is.iPad = ua.indexOf('iPad') != -1;
$is.iPhone = ua.indexOf('iPhone') != -1;
for (i in $is) if (!$is[i]) $is[i]=NaN;
if (!$is.IE5) v = (ua.toLowerCase().match(new RegExp(".+(?:rv|it|ra|ie)[\\/: ]([\\d.]+)"))||[])[1];
switch (true) {
    case ($is.WebKit): v=parseInt(v, 10);$is.WebKit=v=v>599?4:v>499?3:v>399?2:1;break;
    case ($is.Opera): $is.Opera =v=v||9;break;
    case ($is.Gecko): $is.Gecko =v=v.substr(0,3)||1.8;break;
    case ($is.IE): $is.IE =v= window.XMLHttpRequest ? 7 : (/MSIE [5]/.test(av)) ? (/MSIE 5.5/.test(av))?5.5:5 : 6;
    };
$is.verb = v;
$is.ok = !!($is.Opera>=9 || $is.IE>=6 || $is.Gecko || $is.WebKit>2);
$is.debug = /&debug$/.test(location.search);
})();