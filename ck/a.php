<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Edit Article</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <script type="text/javascript" src="ckeditor.js"></script>
  <link rel="stylesheet" type="text/css" href="http://www.martinezdelizarrondo.com/ckplugins/simpleuploads.demo4/skins/alive/editor.css?t=F9PL"><script type="text/javascript" src="http://www.martinezdelizarrondo.com/ckplugins/simpleuploads.demo4/lang/en.js?t=F9PL"></script><script type="text/javascript" src="http://www.martinezdelizarrondo.com/ckplugins/simpleuploads.demo4/styles.js?t=F9PL"></script><style type="text/css">.SimpleUploadsOverContainer {box-shadow: 0 0 10px 1px #99DD99 !important;} .SimpleUploadsOverDialog {box-shadow: 0 0 10px 4px #999999 inset !important;} .SimpleUploadsOverCover {box-shadow: 0 0 10px 4px #99DD99 !important;} .cke_throbber {margin: 0 auto; width: 100px;} .cke_throbber div {float: left; width: 8px; height: 9px; margin-left: 2px; margin-right: 2px; font-size: 1px;} .cke_throbber .cke_throbber_1 {background-color: #737357;} .cke_throbber .cke_throbber_2 {background-color: #8f8f73;} .cke_throbber .cke_throbber_3 {background-color: #abab8f;} .cke_throbber .cke_throbber_4 {background-color: #c7c7ab;} .cke_throbber .cke_throbber_5 {background-color: #e3e3c7;} .uploadRect {display: inline-block;height: 11px;vertical-align: middle;width: 50px;} .uploadRect span {background-color: #999;display: inline-block;height: 100%;vertical-align: top;} .uploadName {display: inline-block;max-width: 180px;overflow: hidden;text-overflow: ellipsis;vertical-align: top;white-space: pre;} .uploadText {font-size:80%;} .cke_throbberMain a {cursor: pointer; font-size: 14px; font-weight:bold; padding: 4px 5px;position: absolute;right:0; text-decoration:none; top: -2px;} .cke_throbberMain {background-color: #FFF; border:1px solid #e5e5e5; padding:4px 14px 4px 4px; min-width:250px; position:absolute;}</style>
</head>
<body>
  <h1>Edit Article</h1>
  <form action="form_handler.php" method="post">
    <div>
      <textarea cols="80" rows="10" id="ckeditor1" class="ckeditor" name="content"> 
        &lt;h1&gt;Article Title&lt;/h1&gt;
        &lt;p&gt;Here's some sample text&lt;/p&gt;
      </textarea>
      <script type="text/javascript">
        CKEDITOR.replace( 'ckeditor1' );
      </script>
      <input type="submit" value="Submit"/>
    </div>
  </form>
</body>
</html>