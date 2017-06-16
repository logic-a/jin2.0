jQuery(function($){
	
	$('.iframe').modaal({
		type: 'iframe',
		width: 700,
		height: 500
	});
	
	
	$('.otayori textarea').parent().parent().addClass("textarea");
	$('.otayori input, .otayori textarea').on("focus blur", function(){
		if ($(this).val().length === 0 ) {
			$(this).parent().parent().toggleClass("focus");
		}
	});
	
	
	$('header nav li a').on("click", function(){
		var t = $(this).attr("href");
		var off = $(t).offset().top;
		$('html, body').animate({
			scrollTop: off
		}, 0);
		$("#menu").prop("checked", false);
		return false;
	});
	$('.cv').on("click", function(){
		var t = $(this).attr("href");
		var off = $(t).offset().top;
		$('html, body').animate({
			scrollTop: off
		}, 200);
		$("#menu").prop("checked", false);
		return false;
	});

	
	$('.show_all').on("click", function(){
		$(this).parent().find("section").removeClass();
		$(this).hide();
	});
	
	$(window).scroll(function (){
		var scroll = $(window).scrollTop();
		var windowHeight = $(window).height();
		var otayoriHeight = $("#anc-otayori").offset().top;
		
		if (scroll > windowHeight && scroll < (otayoriHeight - windowHeight/2)){
			$('.cv.upper').removeClass("hide");
		}
		else {
			$('.cv.upper').addClass("hide");
		}
	});
	
	
/*
	$(".menu-trigger").click(function(){
		$(this).toggleClass("active");
		$(this).parent().find("nav").toggleClass("active");
	});
	
	$(".toggleBtn").on("click", function(){
		$(this).prev().addClass("on");
		$(this).hide();
	});
*/
	
	$(".opensub").click(function(){
		window.open(this.href,"WindowName","width=520,height=520,resizable=yes,scrollbars=yes");
		return false;
	});
	
});