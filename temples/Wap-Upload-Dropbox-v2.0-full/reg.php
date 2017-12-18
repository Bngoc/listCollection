<?php
/*****************
 * Author: Phạm Dũng
 * Version: 2.0
 * Vui lòng tôn trọng bản quyền tác giả khi sử dụng. !!!!
 * Mọi thắc mắc liên hệ Email: PhamDung.itcn@gmail.com
 *****************/
define('DROPBOX', '_PHAM_DUNG_');
require('config.php');
$tieude = 'Đăng kí';
$head = 'reg';
require('head.php');
if ($user_id) {
    header('Location: index.php');
    exit();
}
echo '<div class="phdr"><b>Đăng kí</b></div>';
if (!isset($_COOKIE['phamdung'])) {
    setcookie('phamdung', 1, time() + 3600 * 24 * 365);
} elseif (isset($_COOKIE['phamdung']) && $_COOKIE['phamdung'] >= 2) {
    echo '<div class="list2"><b>Rất tiếc, bạn không được phép đăng kí sử dụng nhiều tài khoản trên cùng một thiết bị</b></div>';
    require('end.php');
    exit();
}
$captcha = isset($_POST['captcha']) ? trim($_POST['captcha']) : NULL;
$reg_nick = isset($_POST['nick']) ? trim(strtolower($_POST['nick'])) : '';
$reg_pass = isset($_POST['password']) ? trim(strtolower($_POST['password'])) : '';
$reg_pass2 = isset($_POST['password2']) ? trim(strtolower($_POST['password2'])) : '';
$reg_mail = isset($_POST['mail']) ? trim(strtolower($_POST['mail'])) : '';
if (isset($_POST['submit'])) {
    $error = array();
    if (empty($reg_nick)) {
        $error['login'][] = 'Tên tài khoản không được để trống !';
    } elseif (mb_strlen($reg_nick) < 4 || mb_strlen($reg_nick) > 20) {
        $error['login'][] = 'Tên tài khoản dài từ 4 đến 20 kí tự !';
    }
    if (preg_match('/[^\dA-Za-z]+/', $reg_nick)) {
        $error['login'][] = 'Tên nick gồm chữ và số không được chứa kí tự đặc biệt!';
    }

    if (empty($reg_pass)) {
        $error['password'][] = 'Mật khẩu không được để trống !';
    } elseif (mb_strlen($reg_pass) < 4 || mb_strlen($reg_pass) > 20) {
        $error['password'][] = 'Mật khẩu quá dài hoặc quá ngắn!';
    }

    if (preg_match('/[^\dA-Za-z]+/', $reg_pass)) {
        $error['password'][] = 'Mật khẩu có chứa kí tự không hợp lệ!';
    }
    if (empty($reg_pass2)) {
        $error['password2'][] = 'Mật khẩu không được để trống !';
    } elseif (!empty($reg_pass) && $reg_pass2 != $reg_pass) {
        $error['password2'][] = 'Mật khẩu không trùng nhau !';
    }
    if (empty($reg_mail)) {
        $error['mail'][] = 'Bạn chưa nhập địa chỉ Email';
    }
    $reqmail = mysql_query("SELECT * FROM `dropbox_user` WHERE `email`='" . mysql_real_escape_string($reg_mail) . "'");
    if (mysql_num_rows($reqmail) != 0) {
        $error['mail'][] = 'Email này đã được sử dụng';
    }
    if (!$captcha || !isset($_SESSION['code']) || strtolower($captcha) != $_SESSION['code']) {
        $error['captcha'] = 'Mã bảo vệ không đúng !';
    }
    unset($_SESSION['code']);
    if (empty($error)) {
        $req = mysql_query("SELECT * FROM `dropbox_user` WHERE `name`='" . mysql_real_escape_string($reg_nick) . "'");
        if (mysql_num_rows($req) != 0) {
            $error['login'][] = 'Tài khoản này đã được đăng kí';
        }
    }
    if (empty($error) && isset($_COOKIE['phamdung']) && $_COOKIE['phamdung'] < 2) {
        mysql_query("INSERT INTO `dropbox_user` SET `name`='" . mysql_real_escape_string($reg_nick) . "' , `pass`='" . mysql_real_escape_string(md5(sha1(md5($reg_pass)))) . "', `email`='" . $reg_mail . "'") or exit(mysql_error());
        $usid = mysql_insert_id();
        if (isset($_COOKIE['phamdung'])) {
            setcookie('phamdung', $_COOKIE['phamdung'] + 1, time() + 3600 * 24 * 365);
        }
        echo '<div class="list2"><img src="' . $home . '/images/muiten.gif"/> Đăng kí thành công</div>';
        echo '<div class="list1"><img src="' . $home . '/images/muiten.gif"/> ID: ' . $usid . '<br /><img src="' . $home . '/images/muiten.gif"/> Tài khoản: ' . $reg_nick . '<br /><img src="' . $home . '/images/muiten.gif"/> Mật khẩu: ' . $reg_pass . '</div>';
        echo '<div class="list1"><img src="' . $home . '/images/muiten.gif"/> <a href="' . $home . '/login.php?n=' . $reg_nick . '&p=' . $reg_pass . '"><b>Đăng nhập</b></a></div>';
        require('end.php');
        exit();
    }
}
echo '<form action="reg.php" method="post"><div class="list1">' .
    '<h3>Tên đăng nhập :</h3>' .
    (isset($error['login']) ? '<font color="red"><small>' . implode('<br />', $error['login']) . '</small></font>' : '') .
    '<input type="text" name="nick" maxlength="15" value="' . htmlspecialchars($reg_nick) . '"' . (isset($error['login']) ? ' style="background-color: #FFCCCC"' : '') . '/><br />' .
    '<small>Tối thiểu là 4,tối đa là 20 ký tự.<br />Chỉ cho phép chữ cái và số</small>' .
    '</div><div class="list1"><h3>Mật khẩu</h3>' .
    (isset($error['password']) ? '<font color="red"><small>' . implode('<br />', $error['password']) . '</small></font><br />' : '') .
    '<input type="password" name="password" maxlength="20" value="' . htmlspecialchars($reg_pass) . '"' . (isset($error['password']) ? ' style="background-color: #FFCCCC"' : '') . '/><br/>' .
    '<small>Ít nhất 4 ký tự,nhiều nhất là 20 ký tự.<br />Chỉ cho phép chữ cái và số</small>' .
    '</div><div class="list1"><h3>Nhập lại mật khẩu</h3>' .
    (isset($error['password2']) ? '<font color="red"><small>' . implode('<br />', $error['password2']) . '</small></font><br />' : '') .
    '<input type="password" name="password2" maxlength="20" value="' . htmlspecialchars($reg_pass2) . '"' . (isset($error['password2']) ? ' style="background-color: #FFCCCC"' : '') . '/></div><div class="list1"><h3>Email</h3>' .
    (isset($error['mail']) ? '<span class="red"><small>' . implode('<br />', $error['mail']) . '</small></span><br />' : '') .
    '<input type="text" name="mail" maxlength="100" value="' . htmlspecialchars($reg_mail) . '"' . (isset($error['mail']) ? ' style="background-color: #FFCCCC"' : '') . '/></div><div class="list1">' .
    '<h3>Mã bảo vệ:</h3>' .
    '<img src="captcha_img.php" alt="Captcha" border="1"/><br />' .
    (isset($error['captcha']) ? '<font color="red"><small>' . $error['captcha'] . '</small></font><br />' : '') .
    '<input type="text" size="5" maxlength="5"  name="captcha" ' . (isset($error['captcha']) ? ' style="background-color: #FFCCCC"' : '') . '/><br /><small>Không phân biệt chữ hoa, thường.</small><p><input type="submit" name="submit" value="Đăng kí"/></p></div></form>';
require('end.php');
?>