<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="js/clockh.js"></script>   
 <!--script type="text/javascript" src="js/jquery.min.js"></script-->  
<script type='text/javascript'>$(function(){$(window).scroll(function(){if($(this).scrollTop()!=0){$('#bttop').fadeIn();}else{$('#bttop').fadeOut();}});$('#bttop').click(function(){$('body,html').animate({scrollTop:0},200);});});</script>


<style type="text/css">
div {
	font-family: Arial, Helvetica, sans-serif;
}
</style>
</head>
<body>
<style type="text/css">
{margin:0 auto;padding:0;}
.clearfloat{clear:both;line-height:0;height:0;font-size:1px;}

html {border: 0 none;margin: 0;padding: 0;}
body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, code, del, dfn, em, img, q, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, dialog, figure, footer, header, hgroup, nav, section {border: 0 none;font: inherit;margin: 0;padding: 0;vertical-align: baseline;}
h3 {font-size: 1em;line-height: 1;margin-bottom: 1em;text-decoration: none;}

article, aside, details, figcaption, figure, dialog, footer, header, hgroup, menu, nav, section {display: block;}
body {line-height: 1.5;color: #666666;font-family:inherit;font-size: 75%;}
a img {border: none;}
button{margin:0 auto; border:none;}
li, ol, ul{list-style-type:none;}
body {
	font-family:Arial, Helvetica, sans-serif
}
{
    margin: 0 auto;
    padding: 0;
}
.comment-reply {
     margin-left: 220px; 
     position: relative; 
}
.comment-inputs {
    float: left;
    width: 100%;
    position: relative;
}

.comment-inputs > div {
    margin: 10px 0px;
    float: left;
    width: 100%;
}
.comment-inputs label {
    float: left;
    font-size: 11px;
    font-weight: normal;
    text-align: right;
    width: 60px;
    margin-right: 5px;
}
.comment-inputs input {
    color: #666666;
    float: left;
    margin: 0;
    padding: 2px 15px 2px 10px;
    width: 75%;
}
.comment-inputs span {
    color: #9b0000 !important;
}
.comment-inputs textarea {
    float: left;
    height: 100px;
    margin: 0;
    padding: 2px 10px;
    width: 76%;
    color: #666;
}

.comment-reply small {
    color: #444;
    float: left;
    width: 100%;
    font-size: 11px;
}

.comment-inputs small {margin-left: 65px; width: 280px;}
a.btn_b {float: right;margin-right: 10px;margin-top: 9px;cursor: pointer;background: url("../forum/images/icon/button-right.gif") no-repeat scroll 0 0 #222629;color: #E9E9E9;float: left;height: 33px;line-height: 34px;padding: 0 15px;}
.comment-inputs a.btn_b{float: right;margin-right: 10px;margin-top: 9px;cursor: pointer;}
.comment-inputs a.btn_b:hover{background: url("../forum/images/icon/bbnt-red.png") no-repeat scroll 0 -2px #9b0000; color:white;}

#bttop {border: 1px solid #4adcff;background: #24bde2;text-align: center;padding: 5px;position: fixed;bottom: 35px;right: 30px;cursor: pointer;display: none;color: #fff;font-size: 11px;font-weight: 900;}
#bttop:hover{border:1px solid #ffa789;background:#ff6734;}

.comment-inputs small {margin-left: 65px; width: 280px;}
a.btn_b {float: right;margin-right: 10px;margin-top: 9px;cursor: pointer;background: url("./images/button-right.gif") no-repeat scroll 0 0 #222629;color: #E9E9E9;float: left;height: 33px;line-height: 34px;padding: 0 15px;}
.comment-inputs a.btn_b{float: right;margin-right: 10px;margin-top: 9px;cursor: pointer;}
.comment-inputs a.btn_b:hover{background: url("./images/bbnt-red.png") no-repeat scroll 0 -2px #9b0000; color:white;}

/*     ********************************** */
.headtab {
    background: url(../images/pattern-title.png) repeat;
}
.headtab ul.tabs > li {
    border-right: 1px solid #333;
}
.tabs li {
    list-style: none;
    display: inline;
}
.tabs a {
    display: inline-block;
    color: #333333;
    text-decoration: none;
    padding: 5px 10px;
    text-transform: uppercase;
    font-weight: bold;
}
.tabs a.active {
    color: #333333;
    border-bottom: #474b4d solid 3px;
    text-transform: uppercase;
    font-weight: bold;
}
.detail-content {
    margin: 20px 0 0 20px;
    float: left;
    width: 96.8%;
    position: relative;
	background-color: bisque;
}
.return_pd {
    float: left;
    width: 100%;
    margin-top: 20px;
}

/* ----------------------Admin Del -- Edil------------------------ */

/* **** TIEU DE *** */
.contai {
	width:85%;
	margin: 5px auto;
	vertical-align: baseline;
	display:block;
}
.contai .tieude {
    border-bottom: solid 1px #e5e5e5;
	padding: 5px 0;
    width: 100%;
    float: left;
}

.tieude h1 {
    color: RED;
    text-transform: uppercase;
    border-color: #0CE494;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
}

.tieude h2.head_h2_two {
    /*background: url("./images/bg_h2_2.png") no-repeat 0px 0px;
    margin: 10px 0 0 10px;*/
	float: left;
    width: 65%;
	color: #9b0000 !important;
	text-align: justify;
}

.tieude .giohethong {
    position: relative;
    float: right;
	color:maroon;
}

.tieude h2.head_h2_two span {
    
    /* font-weight: normal; */
    text-transform: none;
    font-weight: bolder;
    line-height: normal;
    font-size: 15px;
    text-transform: uppercase;
}

/* **** NOI DUNG *** */

.comment_filter {
    float: left;
    width: 100%;
    border-bottom: 1px dotted #666666;
}

/* **************************************************************** */
.footer{margin:0 auto;width:100%;clear:both;display:block;}
.fcontent {margin: 0 auto;width: 980px;background: url(./images/v3_linebanner.gif) no-repeat 0 top;padding-top: 8px;}
.fcontent p {text-align: center;margin: 0;font-size: 10px;}

</style>
<div class ="comment-reply">
	<div class="comment-inputs">
		<div class="comment-inputs-1">
			<label for="" class="screen-reader-text">TiĂªu Ä‘á»:*</label>
			<input type="text" class="infontitle" id="" name="" disabled="disabled">
			<span id="errorTitle" style="display: none;">*</span>
			 
		</div>
		<div class="comment-inputs-2">
			<label for="" class="screen-reader-text">ÄĂ¡nh giĂ¡:*</label>
			<textarea id="" cols="50" rows="10" name="" disabled="disabled"></textarea>
			<span id="errorDes" style="display: none;">*</span>
			
		</div>
		
		<small id="lblMessage2"></small>
		<small>(*)ThĂ´ng tin báº¯t buá»™c pháº£i nháº­p</small>
		
		<a style="text-decoration: none; display: block;" onClick="CheckSaveComment()" id="btnReview" class="btn_b">ÄĂ¡nh giĂ¡</a>
		<a style="text-decoration: none; display: block;" onClick="DeleteField()" id="btnDelete" class="btn_b">Nháº­p láº¡i</a>  
		<a id="btnLogin" style="text-decoration: block;" class="btn_b" href="dbsvs">ÄÄƒng nháº­p</a>
	</div>
</div>
<!-- --------------------------------------------------------------- -->
<div class="clearfloat"></div>
<div class="headtab">
	<ul class="tabs">
		<li><a href="javascript:void(0)" class="setupbn1 active" rel="">Thông tin sản phẩm</a></li>                                
		<li><a href="javascript:void(0)" class="setupbn2" rel=""> Quy định đổi trả hàng</a></li>
	</ul>
</div>
								
<script>
	$(".setupbn1").click(function() {
		$(".setupbn1").addClass("active");
		$("#tab1").css('display','block');
		$("#tab2").css('display','none');
		$(".setupbn2").removeClass("active");
	});
	$(".setupbn2").click(function() {
		$(".setupbn2").addClass("active");
		$("#tab1").css('display', 'none');
		$("#tab2").css('display', 'block');
		$(".setupbn1").removeClass("active");
	});
</script>
								
<div id="tab1" style="display: block;">
	<div class="detail-content">
		<p> ffffffffffffffffffffffffffffffff</p>
	</div>
</div>

<div id="tab2" style="display: block;">
	<div class="return_pd">
		<p> gggggggggggggggggggggggggggg</p>
	</div>
</div>

<div class="clearfloat"></div>
<!----------------------------------------------------------------- -->
<div class="wrap-color"><a id="default" style="cursor: pointer;" onClick="getColorImages()" class="activecolor"><img width="20px" height="20px" src="http://localhost/chon.vn/images/imgcontent/s1.3.jpg"></a></div>

<div style="" rel="default" class="divsize">
	<a onClick="getSizeActive('L','default',20);" class="size activesize" title="L-default" style="" rel="20">L</a>
	<a onClick="getSizeActive('M','default',20);" class="size" title="M-default" style="" rel="20">M</a>
	<a onClick="getSizeActive('S','default',20);" class="size" title="S-default" style="" rel="20">S</a>
	<a onClick="getSizeActive('XL','default',20);" class="size" title="XL-default" style="" rel="20">XL</a>
</div>
<div class="clearfloat"></div>

<!----------------------------------------------------------------- -->

<div class="Share">
	<p>Chia sẻ:</p>
	<p>
		<a rel="nofollow" class="facebook" onClick="window.open('http://www.facebook.com/share.php?u='+document.location,'_blank');" style="cursor: pointer;" title="Đăng lên Facebook"></a> 
		<a rel="nofollow" class="twitter" onClick="window.open('http://twitter.com/home?status='+document.location,'_blank');" style="cursor: pointer;" title="Đăng lên Twitter"> </a>
		<a rel="nofollow" class="googleplus" onClick="window.open('https://plus.google.com/share?url='+document.location,'_blank');" title="Đăng lên googleplus"></a>
	</p>
</div>
				
<div class="fb-like fb_iframe_widget" data-width="390" data-href="http://www.facebook.com/www.chon.vn/" style="float: right; overflow:inherit;" data-layout="standard" data-action="like" data-show-faces="true" data-share="flase"></div>



<!----------------------------------------------------------------- -->
<div class="clearfloat"></div>

	<div class="contai" style="">
		
		<div class="tieude">
			<h1>Muti_Del</h1>
			<div align="left" class="">
				<h2 align="justify" class="head_h2_two">
				<span href="#">Giấy chứng nhận ĐKKD số 0310257037 do Sở Kế hoạch và đầu tư Thành phố Hồ Chí Minh cấp lần đầu ngày 17/8/2010</span>
			</h2>
			</div>
			<div class="giohethong">
				<span id="date-time">Sunday, September 27 2015 | 20:36:57</span>
				<script type="text/javascript">window.onload = date_time('date-time');</script>
			</div>
		</div>
		
		<div class ="comment_filter">
			<span class="input text filter">
				<select enableviewstate="false" style="width:150px" onChange="ChangDropDown()" id="ddlsortExpression" name="">
					<option value="newest">Má»›i nháº¥t</option>										
					<option value="oldest">CÅ© nháº¥t</option>										
					<option value="bestuserratings">ÄĂ¡nh giĂ¡ chung tá»‘t nháº¥t</option>										
					<option value="worstuserratings">ÄĂ¡nh giĂ¡ chung tá»‡ nháº¥t</option>										
					<option value="mosthelpful">ÄĂ¡nh giĂ¡ há»¯u Ă­ch nháº¥t</option>										
					<option value="leasthelpful">ÄĂ¡nh giĂ¡ khĂ´ng há»¯u Ă­ch nháº¥t</option>										
				</select>
				
			</span>
			
			<div class ="">
				
			</div>
		</div>
	</div>

	<!----------------------------------------------------------------- -->										
	<div class="clearfloat"></div>
	<div id="bttop" style="display: block;">BACK TO TOP</div>											
	 <div class="footer">
		<div class="fcontent">
			<div itemtype="#" itemscope=""><p itemprop="name">Bản quyền &copy; 2012 <a href="#">Chọn.vn</a> - Bản quyền được bảo vệ</p></div>
			<div><p><span>Công ty CPTM Chọn, 339/19 Lê Văn Sỹ, P.13, Q.3</span> &ndash; ĐT:<span> (08) 3526 4733 </span> &ndash; Fax: <span>(08) 3526 4736</span></p></div>
			<p>
				Giấy phép số 49/GP - ICP - STTT cấp ngày 11/06/2012 do sở thông tin truyền thông TP.HCM cấp<br>
				Giấy chứng nhận ĐKKD số 0310257037 do Sở Kế hoạch và đầu tư Thành phố Hồ Chí Minh cấp lần đầu ngày 17/8/2010<br>
				và đăng ký thay đổi lần thứ 4 ngày 12/3/2013.<br><br>
			</p>
		</div>
	</div>
	

<!----------------------------------------------------------------- -->

</body>
</html>