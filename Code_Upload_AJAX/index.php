<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mini Upload Tool</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style type="text/css">
        .progress {
            position: relative;
        }

        .progress-text {
            position: absolute;
            width: 100%;
            height: 100%;
            text-align: right;
            padding-right: 5px;
            color: #333;
        }
    </style>
</head>
<body>
<img src="images/progressbar.gif" style="display:none"/>
<div class="container">
    <h1>Mini Upload Tool</h1>
    <form role="form" action="#" method="post" enctype="multipart/form-data" onsubmit="return doUpload();">
        <div class="form-group">
            <label for="myfile">File Upload</label>
            <input type="file" class="form-control" name="myfile" id="myfile" multiple>
        </div>
        <input type="submit" class="btn btn-default" value="Upload"/>
        <input type="button" class="btn btn-default" value="Cancle" onclick="cancleUpload();"/>
    </form>
    <hr>
    <div id="progress-group">
        <div class="progress">
            <div class="progress-bar" style="width: 60%;">
                Tên file ở đây
            </div>
            <div class="progress-text">
                Tiến trình ở đây
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar" style="width: 40%;">
                Tên file ở đây
            </div>
            <div class="progress-text">
                Tiến trình ở đây
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="js/function.js"></script>
</body>
</html>