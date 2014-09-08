<div id="content">
	<?CrumbsWidget::run()?>
	<div class="contacts">
		<h1><?=$name?></h1>
		<div class="addresses">
			<div class="address active cont1" onclick="$('#show2').hide();$('#show1').show();">
				<span class="name">Наш адрес</span><br/>
				<?=$fields['Наш адрес']?>
				<div class="bot"></div>
			</div>
			<div class="address cont2" onclick="$('#show1').hide();$('#show2').show();">
				<span class="name">Пункт самовывоза</span><br/>
				<?=$fields['Пункт самовывоза']?>
				<div class="bot"></div>
			</div>
			<div class="details cont3">
				<span class="name">Наши реквизиты</span><br/>
				<div class="details-height">
					<?=$fields['fulltext']?>
					<a href="javascript:;" onclick="window.print();" class="print-but" style="margin-top: 10px;"></a>
				</div>
				<div class="close-but" ></div>
				<div class="bot"></div>
			</div>
		</div>
		<div class="clear"></div>
		<div id="show1"><div class="map" id="YMapsID1" style="width:938px; height:411px"></div></div>
		<div id="show2"><div class="map" id="YMapsID2" style="width:938px; height:411px;"></div></div>
	</div>
	<div class="clear"></div>
</div>
<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"> </script>
<script>
	function init(){
		var myGeocoder = ymaps.geocode("<?=$fields['Адрес 1']?>", {results: 1});
		myGeocoder.then(function (res) {
			if (res.geoObjects.getLength()) {
				var point = res.geoObjects.get(0);
				//myMap.geoObjects.add(point);
				//myMap.panTo(point.geometry.getCoordinates());
				var coord=point.geometry.getCoordinates();
				var map = new ymaps.Map("YMapsID1", {
					center: coord,
					zoom: 15
				});
				mark = new ymaps.Placemark(map.getCenter(), {
						balloonContent: "<h4>Наш адрес</h4><?=$fields['Адрес 1']?>",
					}
				);
				map.geoObjects.add(mark);
				map.controls.add("zoomControl").add("typeSelector").add("mapTools");
			}
		});
		var myGeocoder = ymaps.geocode("<?=$fields['Адрес 2']?>", {results: 1});
		myGeocoder.then(function (res) {
			if (res.geoObjects.getLength()) {
				var point = res.geoObjects.get(0);
				//myMap.geoObjects.add(point);
				//myMap.panTo(point.geometry.getCoordinates());
				var coord=point.geometry.getCoordinates();
				var map = new ymaps.Map("YMapsID2", {
					center: coord,
					zoom: 15
				});
				mark = new ymaps.Placemark(map.getCenter(), {
						balloonContent: "<h4>Пункт самовывоза</h4><?=$fields['Адрес 2']?>",
					}
				);
				map.geoObjects.add(mark);
				map.controls.add("zoomControl").add("typeSelector").add("mapTools");
				$('#show2').hide();
			}
		});
	}
	ymaps.ready(init);	
</script>