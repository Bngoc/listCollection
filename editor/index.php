<?php 

/**
 * @author	brengsekerz <brengsekerz@gmail.com>
 * 
 * This is demo for editing content using CKEditor and KCFinder
 */

?>


<title>Content Editor</title>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

	<p>
		<label>Title:</label><br/>
		<input type="text" name="title" />
	</p>
	<p>
		<label>Content:</label><br/>
		<textarea name="content" id="content"></textarea>
	</p>
	<p>
		<label>&nbsp;</label>
		<button name="post" value="post">Post !</button>
	</p>
</form>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR_BASEPATH = 'ckeditor';

	var editor = CKEDITOR.replace('content', {
    	filebrowserBrowseUrl: "kcfinder/browse.php?type=files"
	});
</script>


<?php 

if(!empty($_POST['post'])){
	/*
	 * Put the query for insert the post to the database
	 * 
	 * 	mysql_query("INSERT INTO article(title, content) VALUES ('$_POST[title]','$_POST[content]')")
	 * 
	 */
}

?>