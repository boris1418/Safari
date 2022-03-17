$(function(){
	/*$('.popup__link').magnificPopup({
		disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
	});

	$('.gallery__slider').slick({
		prevArrow: '<button type="button" class="slick-btn slick-prev"><img src="img/arrow-left.svg" alt=""></button>',
		nextArrow: '<button type="button" class="slick-btn slick-next"><img src="img/arrow-right.svg" alt=""></button>',
	});

	$('.gallery__item-inner').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
	});*/
	
	/*$('.gallery__item-link').on('click', function(e) {
		e.preventDefault();
		//узнаём индекс слайда без учёта клонов
		var totalSlides = +$(this).parents('.slider').slick("getSlick").slideCount,
			dataIndex = +$(this).parents('.slide').data('slick-index'),
			trueIndex;
		switch(true){
			case (dataIndex<0):
				trueIndex = totalSlides+dataIndex; break;
			case (dataIndex>=totalSlides):
				trueIndex = dataIndex%totalSlides; break;
			default: 
				trueIndex = dataIndex;
		}  
		//вызывается элемент галереи, соответствующий индексу слайда
		$.fancybox.open(gallery,{}, trueIndex);
		return false;
	});*/
	
	Fancybox.bind(".gallery__slider .slick-slide:not(.slick-cloned) a.gallery__item-link", {
		groupAll : true
	});
	
	$('.gallery__slider').slick({
		prevArrow: '<button type="button" class="slick-btn slick-prev"><img src="img/arrow-left.svg" alt=""></button>',
		nextArrow: '<button type="button" class="slick-btn slick-next"><img src="img/arrow-right.svg" alt=""></button>',
	});

	$('.menu__btn').on('click', function(){
		$('.menu__list').toggleClass('menu__list--active')
	});
	
	/*$('.gallery__slider').on('click', '.gallery__item-link', function(e){
		$('#imagePop').attr('src',$(this).attr("href"));
		$('#imgModal').modal('show');
		e.preventDefault();
	});
	$('#imgModal .close').click(function(e) {
		$('#imgModal').modal('hide');
	});*/
	
	var videoLink = '';
	$('.popup__link').click(function(e) {
		$videoLink = $(this).data("src");
		$('#videoModal').modal('show');
		e.preventDefault();
	}); 
	$('#videoModal').on('shown.bs.modal', function (e) {
		$("#video").attr('src',$videoLink + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
	});
	$('#videoModal').on('hide.bs.modal', function (e) {
		$("#video").attr('src',$videoLink); 
	});
	$('#videoModal .close').click(function(e) {
		$('#videoModal').modal('hide');
	});
});