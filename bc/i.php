
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <script src="ckeditor/ckeditor.js"></script>
	
<script src="ckeditor/plugins/ckfinder/ckfinder.js"></script>
 		<!--   
	<script type="text/javascript">

	   function BrowseServer() {
            var finder = new CKFinder();
            //finder.basePath = '../';
            finder.selectActionFunction = SetFileField;
            finder.popup();
        }
        function SetFileField(fileUrl) {
            document.getElementById('Image').value = fileUrl;
        }
		CKEDITOR.replace( 'ckeditor1');
		
    </script>
	-->
</head>
<body>
    <textarea class="ckeditor" id="ckeditor1" />
	<?php //$output = '<html><body><script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.$url.'","'.$msg.'");</script></body></html>';
//echo $output;?>

<!--
    

    <input type="text" name="Image" id="Image" />
    <input type="button" value="Chọn Ảnh ..." onclick="BrowseServer();"/>
-->
	
</body>
</html>

<!--

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Example: Browsing Files</title>
    <script>
        // Helper function to get parameters from the query string.
        function getUrlParam( paramName ) {
            var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
            var match = window.location.search.match( reParam );

            return ( match && match.length > 1 ) ? match[1] : null;
        }
        // Simulate user action of selecting a file to be returned to CKEditor.
        function returnFileUrl() {

            var funcNum = getUrlParam( 'CKEditorFuncNum' );
            var fileUrl = '/path/to/file.txt';
            window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
            window.close();
        }
    </script>
</head>
<body>
    <button onclick="returnFileUrl()">Select File</button>
</body>
</html>-->