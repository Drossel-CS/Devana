$ = jQuery.noConflict(true);

$(document).ready( function () {

var breakpoint = 860;

if ($(document).width() <= breakpoint){
  $("#primary-menu").css("display","none");
}

  $('.menu-toggle').click(function(e) {
    e.preventDefault();
      if ($('#primary-menu').is(":visible") ) {
        $('.menu-toggle').toggleClass("is-active");
        $('#primary-menu').stop(true,true).slideUp(700);
        
      } else {
        $('.menu-toggle').toggleClass("is-active");
        $('#primary-menu').stop(true,true).slideDown(700);
        
      }
    });

  sizeOfScreen = $(window).width();

  $(window).resize(function () {
    
    if ($(document).width() > breakpoint){
      $("#primary-menu").css("display","block");
		}else{
      $("#primary-menu").css("display","none");
      $('.menu-toggle').removeClass("is-active");
    }

		sizeOfScreen = $(window).width();
  });

});
