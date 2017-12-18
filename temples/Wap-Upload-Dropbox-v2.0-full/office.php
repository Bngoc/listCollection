<?php
/*****************
 * Author: Phạm Dũng
 * Version: 2.0
 * Vui lòng tôn trọng bản quyền tác giả khi sử dụng. !!!!
 * Mọi thắc mắc liên hệ Email: PhamDung.itcn@gmail.com
 *****************/
define('DROPBOX', '_PHAM_DUNG_');
require('config.php');
$tieude = 'Tài khoản';
$head = 'office';
require('head.php');
if (!$user_id) {
    header('Location: login.php');
    exit();
}


if ($user_id == 1) {
    echo '<div class="phdr"><b>Thiết lập</b></div>';
    if (isset($_POST['save'])) {
        $save = mysql_query("UPDATE dropbox_config SET `multi`='" . $_POST['multi'] . "', `type`='" . $_POST['show_disk'] . "' WHERE `id`=1") or die(mysql_error());
        if ($save) {
            echo '<div class="list2">Đã lưu thiết lập !</div>';
        }
    }
    echo '<div class="list1"><form method="post">Số tập tin tải lên cùng lúc:<br/><select name="multi">';
    for ($w = 1; $w <= 10; $w++) {
        echo '<option value="' . $w . '" ' . ($w == $multi_dropbox ? 'selected="yes"' : '') . '/>' . $w . '</option>';
    }
    echo '</select><br/>Hiển thị không gian đĩa ngoài trang chủ: <br/><select name="show_disk"><option value="f"/>Bật</option><option value="l" selected="yes"/>Tắt</option></select><br/><input type="submit" name="save" value="Lưu"/></form></div>';

}
echo '<div class="phdr"><b>Mật Khẩu</b></div>';
$error = '';
if (isset($_POST['dmk'])) {
    $p0 = isset($_POST['p0']) ? trim(strtolower($_POST['p0'])) : NULL;
    $p1 = isset($_POST['p1']) ? trim(strtolower($_POST['p1'])) : NULL;
    $p2 = isset($_POST['p2']) ? trim(strtolower($_POST['p2'])) : NULL;
    if (!$p0 || !$p1 || !$p2)
        $error .= '[+] Các mật khẩu không được để trống<br />';
    if (strlen($p0) < 4 || strlen($p0) > 20 || strlen($p1) < 4 || strlen($p1) > 20 || strlen($p2) < 4 || strlen($p2) > 20)
        $error .= '[+] Mật khẩu quá dài hoặc quá ngắn<br />';
    if ($p1 != $p2) {
        $error .= '[+] Mật khẩu mới không giống nhau<br />';
    }
    if ($error == '' && $p0 && $p1 && $p2) {
        $req = mysql_query("SELECT * FROM `dropbox_user` WHERE `id`='$user_id' LIMIT 1");
        if (mysql_num_rows($req)) {
            $user = mysql_fetch_assoc($req);
            if (md5(sha1(md5($p0))) == $user['pass']) {
                mysql_query("UPDATE dropbox_user SET `pass`='" . mysql_real_escape_string(md5(sha1(md5($p1)))) . "' WHERE id=" . $user_id . ";") or die(mysql_error());
                echo '<div class="list2"><img src="' . $home . '/images/muiten.gif"/> Đổi mật khẩu thành công</div>';
                echo '<div class="list1"><img src="' . $home . '/images/muiten.gif"/> Tài khoản: ' . $user['name'] . '<br /><img src="' . $home . '/images/muiten.gif"/> Mật khẩu củ: ' . $p0 . '<br /><img src="' . $home . '/images/muiten.gif"/> Mật khẩu mới: ' . $p1 . '</div>';
                echo '<div class="list1"><img src="' . $home . '/images/muiten.gif"/> <a href="' . $home . '/login.php?n=' . $user['name'] . '&p=' . $p1 . '"><b>Đăng nhập</b></a></div>';
                require('end.php');
                exit();
            } else {
                $error .= '[+] Mật khẩu cũ không chính xác<br />';
            }
        }
    }
}
echo '<div class="list1">' . (isset($errorx) && !empty($errorx) ? $errorx : '') . ($error == '' ? '' : '<font color="red">' . $error . '</font>') . '<form action="office.php" method="post">Mật khẩu cũ:<br/><input type="password" name="p0" maxlength="20"/><br/>Mật khẩu mới:<br/><input type="password" name="p1" maxlength="20"/><br/>Nhập lại mật khẩu mới:<br/><input type="password" name="p2" maxlength="20"/><br/><input type="submit" name="dmk" value="Thay đổi"/></form></div>';
require('end.php');
?>