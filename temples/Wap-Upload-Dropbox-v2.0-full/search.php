<?php
/*****************
 * Author: Phạm Dũng
 * Version: 2.0
 * Vui lòng tôn trọng bản quyền tác giả khi sử dụng. !!!!
 * Mọi thắc mắc liên hệ Email: PhamDung.itcn@gmail.com
 *****************/
define('DROPBOX', '_PHAM_DUNG_');
require('config.php');
require_once('class/DropboxClient.php');
$tieude = 'Tìm Kiếm';
$head = 'search';
require('head.php');
echo '<div class="phdr">Tìm Kiếm Tệp Tin</div>';
if ($_GET['query'] != '') {
    $total = mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE `name` LIKE '%" . mysql_real_escape_string($_GET['query']) . "%' OR `about` LIKE '%" . mysql_real_escape_string($_GET['query']) . "%';"));
    if ($total == 0) {
        echo 'Không tìm thấy tệp tin.';
        require('end.php');
        exit;
    }

    echo '<div class="list2">Từ Khóa: <b>"' . htmlspecialchars($_GET['query']) . '"</b></div>';
    if (($_POST['page'] = (int)$_POST['page']) != '') $_GET['page'] = $_POST['page'];
    if (($_GET['page'] = (int)$_GET['page']) == '' || $_GET['page'] < 1 || $_GET['page'] > ceil($total / 10)) $_GET['page'] = 1;

    $s1 = ($_GET['page'] - 1) * 10;
    $s2 = $_GET['page'] * 10;
    if ($s2 > $total) $s2 = $total;
    try {
        $dropbox_api = new DropboxClient(array(
            'app_key' => $key_dropbox,
            'app_secret' => $secret_dropbox,
            'app_full_access' => true,
        ), 'en');
        $access_token = load_token($dir_tokens, 'access-' . $file_tokens);

        if (!empty($access_token)) {
            $dropbox_api->SetAccessToken($access_token);
        }

        for ($i = $s1; $i < $s2; $i++) {
            echo '<div class="list2">';
            $file = mysql_fetch_assoc(mysql_query("SELECT * FROM dropbox_file WHERE `name` LIKE '%" . mysql_real_escape_string($_GET['query']) . "%' OR `about` LIKE '%" . mysql_real_escape_string($_GET['query']) . "%' ORDER BY id DESC LIMIT $i,1;"));
            $extension = pathinfo($file['name']);
            $ext = strtolower($extension['extension']);
            if ($ext == 'png' or $ext == 'gif' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'svg') {
                echo '<img src="' . $home . '/images/img.png">';
            }
            if ($ext == 'zip' or $ext == 'rar' or $ext == '7z') {
                echo '<img src="' . $home . '/images/zip.png">';
            }
            if ($ext == 'jar' or $ext == 'jad' or $ext == 'sis') {
                echo '<img src="' . $home . '/images/java.png">';
            }
            if ($ext == 'exe' or $ext == 'bat' or $ext == 'pif' or $ext == 'msi' or $ext == 'pdf') {
                echo '<img src="' . $home . '/images/exe.png">';
            }
            if ($ext == 'mp3' or $ext == 'wav' or $ext == 'mid' or $ext == 'arm') {
                echo '<img src="' . $home . '/images/mp3.png">';
            }
            if ($ext == '3gp' or $ext == 'mpg' or $ext == 'mp4' or $ext == 'avi') {
                echo '<img src="' . $home . '/images/videos.png">';
            }
            if ($ext == 'txt' or $ext == 'odt' or $ext == 'doc') {
                echo '<img src="' . $home . '/images/txt.png">';
            }
            echo ' <a href="' . $home . '/' . $file['id'] . '">' . $file['name'] . '</a> ';
            $get_meta_files = $dropbox_api->GetMetadata('Public/' . $file["name"], false);
            $arrout = obj2Ar($get_meta_files);
            $fsize = $arrout['size'];
            echo '(' . $fsize . ')</div>';
        }
    } catch (DropboxException $e) {
        echo '<div class="phdr">Có Lỗi</div><div class="list2">' . htmlspecialchars($e->getMessage()) . '</div>';
    }

    $pages = ceil($total / 10);
    echo '<div class="list2">';
    if ($_GET['page'] > 1) echo '<a class="pagenav" href="?page=' . ($_GET['page'] - 1) . '&query=' . $_GET['query'] . '"><<</a> ';
    showlas($pages, '&query=' . $_GET['query']);
    if ($_GET['page'] < $pages) echo ' <a class="pagenav" href="?page=' . ($_GET['page'] + 1) . '&query=' . $_GET['query'] . '">>></a>';
    echo '</div>';
    require('end.php');
    exit;
}
echo '<div class="list2">';
echo 'Tổng số: ' . mysql_num_rows(mysql_query("SELECT * FROM dropbox_file;")) . ' Tệp</div><div class="list2">';
echo '<form action="search.php" method="get">';
echo '<input type="text" name="query" value="" /><br/><input type="submit" value="Tìm kiếm" /></form></div>';
require('end.php');
?>