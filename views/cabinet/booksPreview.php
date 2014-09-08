<script type="text/javascript" src="/js/liquid.js"></script>
<script type="text/javascript" src="/js/swfobject.js"></script>
<script type="text/javascript" src="/js/flippingbook.js"></script>
<script type="text/javascript">
	flippingBook.pages = [
		<?foreach($files_gal as $i=>$item):?>
			"/of/8<?=$item['path']?>",
		<?endforeach?>
	];


	flippingBook.contents = [
		[ "Cover", 1 ],
		[ "Modern", <?=count($files_gal)?> ]
	];

	// define custom book settings here
		//flippingBook.settings.bookWidth = 130;
	//flippingBook.settings.bookHeight = 200;
	flippingBook.settings.wmode='transparent';
	flippingBook.settings.pageBackgroundColor = 0xffffff;
	flippingBook.settings.backgroundColor = 0xffffff;
	flippingBook.settings.zoomUIColor = 0x919d6c;
	flippingBook.settings.useCustomCursors = true;
	flippingBook.settings.dropShadowEnabled = false,
	flippingBook.settings.zoomImageWidth = 332;
	flippingBook.settings.zoomImageHeight = 332;
	//flippingBook.settings.downloadURL = "http://www.page-flip.com/new-demos/03-kitchen-gorenje-2008/kitchen_gorenje_2008.pdf";
	//flippingBook.settings.flipSound = "sounds/02.mp3";
	flippingBook.settings.flipCornerStyle = "first page only";
	flippingBook.settings.zoomHintEnabled = false;

	// default settings can be found in the flippingbook.js file
	flippingBook.create();
</script>
<div id="content" class="fixed_width">
	<div class="book_preview_wrap">
		<div class="head_book_prev">
			<div class="head1 nopadding"><?=$name?></div>
			<div class="author_social">
				<span class="author">Автор: <?=$author?></span>
			</div>
			<div class="rating_like">
				<div class="comments_stars"><span>Текущая оценка: </span><div class="rating"><div class="stars3_5"></div></div></div>
			</div>
		</div>
		<div class="book_buy">
			<?/* ?>
			<div class="book_preview format_book">
				<div id="mybook">
					<div class="b-load">
						<?foreach($files_gal as $i=>$item):?>
							<div class="book_page" style="background: url( '/of/8<?=$item['path']?>' ) no-repeat center;"><div class="shadow <?if($i%2==0):?>s_left<?else:?>s_right<?endif?>"></div></div>
						<?endforeach?>
					</div>
				</div>
			</div>
			<?*/?>
			<div id="fbContainer2" style="height:200px"></div>
			<!-- <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553z540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="332">
				<param name="movie" value="/swf/Magazine.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<param name="allowFullScreen" value="true" />
				<param name="allowScriptAccess" value="sameDomain" />
				<embed src="/swf/Magazine.swf" width="100%" height="332" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" allowFullScreen="true" allowScriptAccess="sameDomain"></embed>
			</object>-->
		</div>
		<div class="book_comments">
				<div class="prev_book">
					<a href="#">
						<span>Предыдущая книга</span>
						<img src="/i/tmp/img_75x95.jpg"/>
						<span class="name">Позолоти ручку</span>
					</a>
				</div>
				<div class="comments">
					<div class="designer_comment">
						<div class="head_designer"><span>Отзывы о книге </span>(<?=$report ?> отзыва)</div>

						<div class="one_comment">
							<div class="ava">
								<a href="#"><img src="/i/tmp/designer_userpic.jpg" /></a>
								<a href="#">Отец Флавий</a>
							</div>
							<div class="comment">
								<div class="comment_st"></div>
								Поучительная летопись. Автор молодец. Ибо сказано в писании “Афтар жжот”. Не раз эти смелые ребята доказывали, что у них все пабратски. И вот наконец-то  один выбился в люди! Не люблю рознь межнациональную. Люблю делать подъем-переворот.
							</div>
							<div class="date_comment"><span class="light_gray">05.02.2012 в 16:20</span></div>
						</div>
						<div class="one_comment">
							<div class="ava">
								<a href="#"><img src="/i/tmp/designer_userpic.jpg" /></a>
								<a href="#">Отец Флавий</a>
							</div>
							<div class="comment">
								<div class="comment_st"></div>
								Заблуждаешься, человек божий! Чтишь единственно верным учение своё.
								Однако ничего окромя ущерба тебе оно не приносит. Думаешь, что я грешник,
								коль разрываю могилы по ночам? Отнюдь, падре, я просто прикалываюсь.
								Мне по приколу разрывать. Все детство в песочнице провел! И знаете, что, Флавий, вы и...
								<div class="read_more"><a href="#">Читать полностью...</a></div>
							</div>
							<div class="date_comment"><span class="light_gray">05.02.2012 в 16:20</span></div>
						</div>
						<div class="read_all_comments"><a href="#">Показать еще</a></div>
					</div>

				</div>
			<div class="next_book">
				<a href="#">
					<span>Предыдущая книга</span>
					<img src="/i/tmp/img_75x95.jpg"/>
					<span class="name">Позолоти ручку</span>
				</a>
			</div>
		</div>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>