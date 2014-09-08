<div class="evidence">
	<ul>
	<?foreach($files['image'] as $item):?>
		<li>
			<a href="<?=$item['path']?>" style="cursor: url(/js/graphics/zoomin.cur), pointer;" title="<?=$item['name']?>" onclick="return hs.expand(this,galleryOptions<?=$path?>)"><img src="/of/3<?=$item['path']?>" alt="<?=$item['name']?>"></a>
		</li>
	<?endforeach?>
	</ul>
</div>
<script type="text/javascript"> 
	var galleryOptions<?=$path?> = {
			slideshowGroup: <?=$slideshowGroup?>,
			wrapperClassName: "dark",
			outlineType: 'rounded-white',
			dimmingOpacity: 0.8,
			align: 'center',
			transitions: ['expand', 'crossfade'],
			fadeInOut: true,
			wrapperClassName: 'borderless floating-caption',
			marginLeft: 100,
			marginBottom: 0,
			numberPosition: 'caption',
			captionEval: 'this.thumb.alt'
		};
		hs.addSlideshow({
			slideshowGroup: <?=$slideshowGroup?>,
			interval: 5000,
			repeat: true,
			useControls: true,
			overlayOptions: {
				thumbnailId: 'art1gallary',
				className: 'text-controls',
				position: 'bottom center',
				relativeTo: 'viewport',
				offsetY: -60
			},
			thumbstrip: {
				thumbnailId: 'art1gallary',
				position: 'bottom center',
				mode: 'horizontal',
				relativeTo: 'viewport'
			}
		});
</script>
<br />