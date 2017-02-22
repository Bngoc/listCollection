$(function () {
    $('ul.nav li.dropdown').hover(function(){
    	$(this).addClass('open');
    	$('.dropdown-menu', this).fadeIn();
    }, function(){
    	$(this).removeClass('open');
    	$('.dropdown-menu', this).fadeOut('fast');
    });
});