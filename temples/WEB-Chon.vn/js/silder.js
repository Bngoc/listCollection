// JavaScript Document
var mouse_is_inside = false;

$(document).ready(function()
{
    $('.box_login, .pao').hover(function(){ 
        mouse_is_inside=true; 
    }, function(){ 
        mouse_is_inside=false; 
    });
	
	
    $("body").mouseup(function(){ 
        if(! mouse_is_inside)
		{
			$('.box_login').hide();
	    	$("i.down").removeClass("downup");
	    	$("i.down").addClass("down");
		}
    });
});
//Dang nhap even click
$(document).ready(function () {
    $('.pao').click(function () {
        if ($('.box_login').is(":hidden"))
		{
            $('.box_login').slideDown('slow');
	    	$("i.down").toggleClass("downup");
		}
         else 
		 {
            $('.box_login').slideUp('slow');
	    	$("i.down").toggleClass("downup");
		 }
    });
});
//hover hop thong so luong
$(document).ready(function()
{
    $('.s_submenu').hover(function(e) {
        $(".bk_cart").addClass("dnrieng");
    });
});
/*Banner.....*/
$(document).ready(function() {
    $("#slide").cycle({
		fx: 'scrollHorz',
		speed  : 600,
		timeout: 4500,
		prev: '.prev',
		next: '.next'
	});
});

/*Quang cao SP*/
$(document).ready(function() {
	$('#banner1').cycle({
		fx: 'scrollLeft'
	});
	$('#banner2').cycle({
		fx: 'scrollLeft'
	});
	$('#banner3 p').cycle({
		fx: 'curtainX'
	});
}) 
/*Pre-next Menu*/
$(document).ready(function () {
	$('#col_2c2_inner ul').cycle({ 
		fx:     'fade', 
		speed:  'fast', 
		timeout: 0, 
		next:   '#nextn', 
		prev:   '#prevn' 
	});
});
/*
$(document).ready(function () {
       $(".ul-store").cycle({
		fx: 'scrollMaxX',
		prev: '#prev',
		next: '#next'
    });
});

/*
(function() {
	var links = document.getElementsByTagName('a');
	var query = '?';
	for(var i = 0; i < links.length; i++) {
	if(links[i].href.indexOf('#disqus_thread') >= 0) {
		query += 'url' + i + '=' + encodeURIComponent(links[i].href) + '&';
	}
	}
	document.write('<script charset="utf-8" type="text/javascript" src="http://disqus.com/forums/professorcloud/get_num_replies.js' + query + '"></' + 'script>');
})()
*/