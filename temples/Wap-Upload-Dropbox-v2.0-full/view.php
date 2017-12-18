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
$tieude = 'Danh sách tập tin';
$head = 'list';
require('head.php');
echo '<div class="phdr"><b>Danh sách tập tin</b></div><div class="list2"><form action="view.php" method="get">
Loại:<br />
<select name="t">
<option value="0">Tất cả</option>
<option value="1">Nhạc</option>
<option value="2">Hình ảnh</option>
<option value="3">Video</option>
<option value="4">Ứng dụng</option>
<option value="5">Văn bản</option>
<option value="6">Zip,Rar</option>
</select><br />
<input type="submit" value="Chọn" /></form>';
$onpage = 10;
if (($_POST['page'] = (int)$_POST['page']) != '') $_GET['page'] = $_POST['page'];
$_GET['page'] = (int)$_GET['page'];
$_GET['t'] = (int)$_GET['t'];
$_GET['s'] = (int)$_GET['s'];
if ($_GET['page'] < 1 || $_GET['page'] == '') $_GET['page'] = 1;
switch ($_GET['t']) {
    case 0:
        $total = mysql_num_rows(mysql_query("SELECT * FROM dropbox_file;"));
        break;
    case 1:
        $total = mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.mp3' OR name LIKE '%.wav' OR name LIKE '%.amr' OR name LIKE '%.mid%';"));
        break;
    case 2:
        $total = mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.jpg' OR name LIKE '%.gif' OR name LIKE '%.png' OR name LIKE '%.gif' OR name LIKE '%.svg' OR name LIKE '%.jpeg';"));
        break;
    case 3:
        $total = mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.3gp' OR name LIKE '%.avi' OR name LIKE '%.mp4' OR name LIKE '%.mpg';"));
        break;
    case 4:
        $total = mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.jad' OR name LIKE '%.jar' OR name LIKE '%.sis' OR name LIKE '%.exe';"));
        break;
    case 5:
        $total = mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.doc' OR name LIKE '%.txt' OR name LIKE '%.odt';"));
        break;
    case 6:
        $total = mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.zip' OR name LIKE '%.rar' OR name LIKE '%.7z' OR name LIKE '%.tar%';"));
        break;
    default:
        break;
}
if ($total == 0) {
    echo 'Không tìm thấy tệp tin.';
    require('end.php');
    exit;
}
//echo $total;
if (($_GET['page'] - 1) * $onpage > $total) $_GET['page'] = 1;
$first = ($_GET['page'] - 1) * $onpage;
$last = $_GET['page'] * $onpage;
if ($last > $total) $last = $total;
echo '</div>';
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
    for ($i = $first; $i < $last; $i++) {
        echo '<div class="list2">';
        switch ($_GET['t']) {
            case 0:
                $file = mysql_fetch_assoc(mysql_query("SELECT * FROM dropbox_file ORDER BY id DESC LIMIT $i,1;"));
                break;
            case 1:
                $file = mysql_fetch_assoc(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.mp3' OR name LIKE '%.wav' OR name LIKE '%.amr' OR name LIKE '%.mid%' ORDER BY id DESC LIMIT $i,1;"));
                break;
            case 2:
                $file = mysql_fetch_assoc(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.jpg' OR name LIKE '%.gif' OR name LIKE '%.png' OR name LIKE '%.gif' OR name LIKE '%.svg' OR name LIKE '%.jpeg' ORDER BY id DESC LIMIT $i,1;"));
                break;
            case 3:
                $file = mysql_fetch_assoc(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.3gp' OR name LIKE '%.avi' OR name LIKE '%.mp4' OR name LIKE '%.mpg' ORDER BY id DESC LIMIT $i,1"));
                break;
            case 4:
                $file = mysql_fetch_assoc(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.jad' OR name LIKE '%.jar' OR name LIKE '%.sis' OR name LIKE '%.exe' ORDER BY id DESC LIMIT $i,1"));
                break;
            case 5:
                $file = mysql_fetch_assoc(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.doc' OR name LIKE '%.txt' OR name LIKE '%.odt' ORDER BY id DESC LIMIT $i,1"));
                break;
            case 6:
                $file = mysql_fetch_assoc(mysql_query("SELECT * FROM dropbox_file WHERE name LIKE '%.zip' OR name LIKE '%.rar' OR name LIKE '%.7z' OR name LIKE '%.tar%' ORDER BY id DESC LIMIT $i,1"));
                break;
            default:
                break;
        }
        echo '» <a href="' . $home . '/' . $file['id'] . '/' . $file["name"] . '">' . htmlspecialchars(stripslashes($file['name'])) . '</a> ';

        $get_meta_files = $dropbox_api->GetMetadata('Public/' . $file["name"], false);
        $arrout = obj2Ar($get_meta_files);
        $fsize = $arrout['size'];

        echo '(' . $fsize . ')</div>';
    }
} catch (DropboxException $e) {
    echo '<div class="phdr">Có Lỗi</div><div class="list2">' . htmlspecialchars($e->getMessage()) . '</div>';
}
echo '<div class="list2">';
$pages = ceil($total / $onpage);
if ($_GET['page'] > 1) echo '<a href="view.php?page=' . ($_GET['page'] - 1) . '&ft=' . $_GET['t'] . '">&lt;Trước.</a>';
if ($_GET['page'] > 1 && $_GET['page'] < $pages) echo '|';
if ($_GET['page'] < $pages) echo '<a href="view.php?page=' . ($_GET['page'] + 1) . '&ft=' . $_GET['t'] . '">Tiếp.&gt;</a>';
echo '<br/>';
showlas($pages, '&ft=' . $_GET['t']);
echo '<br/>';
echo '<form action="view.php?ft=' . $_GET['t'] . '" method="post">Trang.<input type="text" name="page" value="" size="3" /><input type="submit" value="' . htmlspecialchars('>>') . '" /></form></div>';
require('end.php');
?>