<?php
/*****************
 * Author: Phạm Dũng
 * Version: 2.0
 * Vui lòng tôn trọng bản quyền tác giả khi sử dụng. !!!!
 * Mọi thắc mắc liên hệ Email: PhamDung.itcn@gmail.com
 *****************/
define('DROPBOX', '_PHAM_DUNG_');
require('config.php');
$tieude = 'Đăng xuất';
require('head.php');
if (!$user_id) {
    header('Location: login.php');
    exit();
}
echo '<div class="phdr"><b>Đăng Xuất</b></div><div class="list2">';
$referer = isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : $home;
if (isset($_POST['submit'])) {
    setcookie('u_drb', '');
    setcookie('p_drb', '');
    session_destroy();
    header('Location: index.php');
} else {
    echo '<p>Xác nhận thoát tài khoản ?</p>' .
        '<form action="logout.php" method="post"><p><input type="submit" name="submit" value="Thoát" /></p></form>' .
        '<p><a href="' . $referer . '">Hủy</a></p>';
}
echo '</div>';
require('end.php');
?>