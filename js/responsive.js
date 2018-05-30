$(window).resize(function() {

    if ($(window).width() <= 980) {
        $("img").each(function() {
            $(this).attr("src", $(this).attr("src").replace("img/landscape/", "img/portrait/"));
			$(this).attr("alt", $(window).width());
        });
    } else {
		$("img").each(function() {
            $(this).attr("src", $(this).attr("src").replace("img/portrait/", "img/landscape/"));
			$(this).attr("alt", $(window).width());
        });
	}

});
$(window).on("orientationchange",function(){
  if ($(window).width() <= 380) {
        $("img").each(function() {
            $(this).attr("src", $(this).attr("src").replace("img/landscape/", "img/portrait/"));
			$(this).attr("alt", $(screen).width());
        });
    } else {
		$("img").each(function() {
            $(this).attr("src", $(this).attr("src").replace("img/portrait/", "img/landscape/"));
			$(this).attr("alt", $(screen).width());
        });
	}
});
$(function() {
    
	if ($(window).width() <= 980) {
        $("img").each(function() {
            $(this).attr("src", $(this).attr("src").replace("img/landscape/", "img/portrait/"));
			$(this).attr("alt", $(window).width());
        });
    } else {
		$("img").each(function() {
            $(this).attr("src", $(this).attr("src").replace("img/portrait/", "img/landscape/"));
			$(this).attr("alt", $(window).width());
        });
	}
	
  });