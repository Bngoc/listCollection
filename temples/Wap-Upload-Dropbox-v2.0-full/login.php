<?php
/*****************
 * Author: Phạm Dũng
 * Version: 2.0
 * Vui lòng tôn trọng bản quyền tác giả khi sử dụng. !!!!
 * Mọi thắc mắc liên hệ Email: PhamDung.itcn@gmail.com
 *****************/
define('DROPBOX', '_PHAM_DUNG_');
require('config.php');
$tieude = 'Đăng nhập';
$head = 'login';
require('head.php');
echo '<div class="phdr"><b>Đăng Nhập</b></div>';
$error = '';
$user_login = isset($_REQUEST['n']) ? trim(strtolower($_REQUEST['n'])) : NULL;
$user_pass = isset($_REQUEST['p']) ? trim(strtolower($_REQUEST['p'])) : NULL;
if ($user_pass && !$user_login)
    $error .= '[+] Tên tài khoản không được trống<br />';
if (!$user_pass && $user_login)
    $error .= '[+] Mật khẩu không được trống<br />';
if (!$user_pass && !$user_login && isset($_POST['login']))
    $error .= '[+] Bạn chưa nhập gì<br />';
if ($user_login && (strlen($user_login) < 4 || strlen($user_login) > 20))
    $error .= '[+] Tên tài khoản quá dài hoặc quá ngắn<br />';
if ($user_pass && (strlen($user_pass) < 4 || strlen($user_pass) > 20))
    $error .= '[+] Mật khẩu quá dài hoặc quá ngắn<br />';
if ($error == '' && $user_pass && $user_login) {
    $req = mysql_query("SELECT * FROM `dropbox_user` WHERE `name`='$user_login' LIMIT 1");
    if (mysql_num_rows($req)) {
        $user = mysql_fetch_assoc($req);
        if (md5(sha1(md5($user_pass))) == $user['pass']) {
            if (isset($_POST['mem'])) {
                $u_drb = base64_encode($user['id']);
                $p_drb = md5(sha1(md5($user_pass)));
                setcookie('u_drb', $u_drb, time() + 3600 * 24 * 365);
                setcookie('p_drb', $p_drb, time() + 3600 * 24 * 365);
            }
            $_SESSION['u_drb'] = $user['id'];
            $_SESSION['p_drb'] = md5(sha1(md5($user_pass)));
            header('Location: ' . $home . '/index.php');
        } else {
            $error .= '[+] Tài khoản hoặc mật khẩu không chính xác<br />';
        }
    } else {
        $errorx = '<font color="red"><b>- Tài khoản hoặc mật khẩu không chính xác</b></font><br />';
    }
}
echo '<div class="list2">' . (isset($errorx) && !empty($errorx) ? $errorx : '') . ($error == '' ? '' : '<font color="red">' . $error . '</font>') . '<form action="login.php" method="post"><p>Tên tài khoản:<br/><input type="text" name="n" value="' . htmlentities($user_login, ENT_QUOTES, 'UTF-8') . '" maxlength="20"/><br/>Mật khẩu:<br/><input type="password" name="p" maxlength="20"/></p><p><input type="checkbox" name="mem" value="1" checked="checked"/>Nhớ</p><p><input type="submit" name="login" value="Đăng nhập"/></p></form></div>';
require('end.php');
?>