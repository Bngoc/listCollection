
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <script src="ckfinder/ckfinder.js"></script>
	

</head>
<body>
    <textarea class="ckfinder" id="ckfinder" />
	<?php //$output = '<html><body><script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.$url.'","'.$msg.'");</script></body></html>';
//echo $output;?>
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