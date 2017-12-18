<?php
/*****************
 * Author: Phạm Dũng
 * Version: 2.0
 * Vui lòng tôn trọng bản quyền tác giả khi sử dụng. !!!!
 * Mọi thắc mắc liên hệ Email: PhamDung.itcn@gmail.com
 *****************/
defined('DROPBOX') or die('');
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n" .
    "\n" . '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">' .
    "\n" . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi">' .
    "\n" . '<head>' .
    "\n" . '<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />' .
    "\n" . '<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="author" content="Phạm Dũng" /><meta name="copyright" content="Copyright © 2013" />
<title>' . $tieude . ' | ' . $tenwap . '</title>
<link rel="shortcut icon" href="' . $home . '/images/favicon.ico" type="image/x-icon"/>
	<meta name="robots" content="noodp,index,follow" />
	<meta name="revisit-after" content="1 days" />
	<link rel="stylesheet" type="text/css" href="' . $home . '/style.css" media="all" /></head><body>';
echo '<div class="khungvientrang">
<div class="vpt_head"><a href="/"><span><i>Drop<b>Box</b> <b>v2</b>.0</i></span></a></div>';
echo '<div class="phdr"> Chào ' . ($user_id ? '<b>' . $login . '</b> !' : 'Khách <b>' . phamdung_agent() . '</b>') . '</div>';
if (!$user_id && $head != 'login' && $head != 'install') {
    echo '<div class="auth"><form action="login.php" method="post">
<input type="text" name="n"value="" maxlength="28" size="4" class="name" />
<input type="password" name="p" maxlength="25" size="4" class="pass" />
<input type="checkbox" name="mem" value="1" checked="checked" />
<input type="submit" value="Đăng nhập" /></form><form action="reg.php" method="post">
<input type="submit" value="Đăng kí" /></form></div>';
}
if ($set_dropbox == 1 && $head == 'index') {
    echo '<div class="phdr">Quá tải</div>';
    echo '<div class="list2"><b>Rất xin lỗi bạn, hiện tại không gian đĩa trên server Dropbox đang quá tải, hãy đợi admin nâng cấp để tiếp tục Upload</b></div>';
    echo '<div class="phdr">Tập tin</div>';
    echo '<div class="list2">• <a href="view.php">Danh sách tập tin</a></div>';
    echo '<div class="list2">• <a href="search.php">Tìm kiếm</a></div>';
    if ($user_id) {
        echo '<div class="phdr">Tài Khoản</div>';
        echo '<div class="list2">• <a href="office.php">Tài khoản</a></div>';
        echo '<div class="list2">• <a href="myfile.php">Tập tin của tôi</a></div>';
        echo '<div class="list2">• <a href="logout.php">Thoát</a></div>';
    }
    include 'end.php';
    exit();
}
if (check_file('http://dl.dropboxusercontent.com/u/186834616/notifications.txt') == '200' && $user_id == 1 && $_COOKIE['noti'] != 'off' && $_GET['notifi'] != 'off') {
    $notifications = file_get_contents('http://dl.dropboxusercontent.com/u/186834616/notifications.txt');
    if ($notifications != '' && $notifications != '0') {
        echo '<div class="list2">Chào <b>' . $login . '</b>: ' . $notifications . '<a href="index.php?notifi=off">[x]</a></div>';
    }
}
?>