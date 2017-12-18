<?php
/*****************
 * Author: Phạm Dũng
 * Version: 2.0
 * Vui lòng tôn trọng bản quyền tác giả khi sử dụng. !!!!
 * Mọi thắc mắc liên hệ Email: PhamDung.itcn@gmail.com
 *****************/
define('DROPBOX', '_PHAM_DUNG_');
$head = 'install';
require('config.php');
if (strlen($_SESSION['dir_tokens']) != 15) {
    $_SESSION['dir_tokens'] = ran_string(15);
    if (!is_dir('tokens-' . $_SESSION["dir_tokens"])) {
        mkdir('tokens-' . $_SESSION["dir_tokens"]);
    }
}
if (strlen($_SESSION['file_tokens']) != 15) {
    $_SESSION['file_tokens'] = ran_string(15);
}
if ($_GET['ins'] == 'db') {
    $sb = 1;
}
if ($_GET['ins'] == 'ad') {
    $sb = 2;
}
if ($_GET['ins'] == 'key') {
    $sb = 3;
}
if (isset($_GET['ins'])) {
    $tieude = 'Bước ' . $sb . '/3 - Install';
} else {
    $tieude = 'Install';
}
require('head.php');
require_once('class/DropboxClient.php');
$ins = new ins;
echo '<div class="phdr">Install</div>';
if ($_POST['next'] == 'Next' && $_GET['selected'] == 'ok') {
    setcookie('ins', 'l', time() + 3600 * 2);
}
if (empty($_GET) && empty($_COOKIE['ins'])) {
    echo '<div class="list2"><center>Chào, bạn đang sử dụng code Cloud Upload - DropBox v2.0 Code được share miễn phí tại Daivietpda.vn .Không được mua bán code dưới mọi hình thức. Xem thêm hướng dẫn cài đặt tại <a href="http://daivietpda.vn/threads/199232"><b>Đây</b></a><br/><form action="install.php?selected=ok" method="post"><input type="submit" name="next" value="Next" /></form></center></div>';
    require('end.php');
    exit();
}
if ($_GET['selected'] == 'ok') {
    header('Location: ' . $home . '/install.php');
}
$ins->a = DROPBOX;
$ins->i = file_get_contents('Install_thanh_cong.txt');
if ($ins->ii() != false) {
    if (strlen(trim($ins->o)) == 310) {
        $msg = trim($ins->o);
        $_SESSION['msg'] = $msg;
    }
}

echo '<div class="' . (($_GET['ins'] == 'db' || $_GET['ins'] == 'ad' || $_GET['ins'] == 'key') ? 'list2' : 'list1') . '">1. <b' . (($_GET['ins'] == 'ad' || $_GET['ins'] == 'key') ? ' style="color: #009933;"' : '') . '>' . (isset($_GET['ins']) ? 'Tạo dữ liệu' : '<a href="install.php?ins=db">Tạo dữ liệu</a>') . '</b><br />';
if (isset($_GET['ins']) && $_GET['ins'] == 'db') {
    mysql_query("DROP TABLE IF EXISTS `dropbox_user`;") or exit(mysql_error());
    mysql_query("DROP TABLE IF EXISTS `dropbox_file`;") or exit(mysql_error());
    mysql_query("DROP TABLE IF EXISTS `dropbox_config`;") or exit(mysql_error());
    $tb1 = mysql_query("CREATE TABLE `dropbox_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pass` varchar(32) NOT NULL DEFAULT '',
  `email` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;") or exit(mysql_error());
    $tb2 = mysql_query("CREATE TABLE `dropbox_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_up` int(11) NOT NULL,
  `name` text NOT NULL,
  `about` text NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `last_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;") or exit(mysql_error());
    $tb3 = mysql_query("CREATE TABLE `dropbox_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(1) NOT NULL DEFAULT 'l',
  `app_key` text NOT NULL,
  `app_secret` text NOT NULL,
  `id_drb` int(11) NOT NULL,
  `set` int(1) NULL DEFAULT '0',
  `multi` int(1) NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;") or exit(mysql_error());
    if ($tb1 == FALSE || $tb2 == FALSE || $tb3 == FALSE) {
        echo '<div class="auth">Có lỗi, tạo dữ liệu thất bại !</div>';
    } elseif ($tb1 == TRUE && $tb2 == TRUE && $tb3 == TRUE) {
        echo '<div class="auth">Tạo dữ liệu thành công !<br /><a href="install.php?ins=ad">NEXT</a></div>';
    }
}
echo '</div>';


echo '<div class="' . (($_GET['ins'] == 'ad' || $_GET['ins'] == 'key') ? 'list2' : 'list1') . '">2. <b' . ($_GET['ins'] == 'key' ? ' style="color: #009933;"' : '') . '>Tạo tài khoản Admin</b>';
if (isset($_GET['ins']) && $_GET['ins'] == 'ad') {
    if (isset($_POST['ok']) && !empty($_POST['name']) && !empty($_POST['pass']) && !empty($_POST['mail'])) {
        $reg_ad = $_POST['name'];
        $reg_pad = md5(sha1(md5($_POST['pass'])));
        $reg_mail = $_POST['mail'];
        $tb3 = mysql_query("INSERT INTO `dropbox_user` SET `name`='" . $reg_ad . "' , `pass`='" . $reg_pad . "', `email`='" . $reg_mail . "'") or exit(mysql_error());
        mysql_query("INSERT INTO `dropbox_file` SET `id_up`=1 , `name`='Install_thanh_cong.txt' , `about`='" . $msg . "', `count`=0") or exit(mysql_error());
        if ($tb3 == FALSE) {
            echo '<div class="auth">Có lỗi, tạo tài khoản thất bại !</div>';
        } elseif ($tb3 == TRUE) {
            echo '<div class="auth"><b style="color: #009933;">Tạo tài khoản thành công !</b><br /><b>Tài khoản: ' . $_POST['name'] . '<br />Mật khẩu: ' . $_POST['pass'] . '</b><br /><a href="install.php?ins=key" align="center">NEXT</a></div>';
        }
    } elseif (!isset($_POST['ok']) || empty($_POST['name']) || empty($_POST['pass'])) {
        echo '<div class="auth"><form method="post">Tài khoản:<br /><input type="text" name="name" value="admin" maxlength="28" class="name" /><br />Mật khẩu (Ít nhất 4 kí tự):<br /><input type="text" name="pass" maxlength="25" class="pass" /><br />Email:<br /><input type="text" name="mail" maxlength="50" class="name" /><br/>
<input type="submit" name="ok" value="Tạo" />
</form>
</div>';
    }
}
echo '</div>';


echo '<div class="' . ($_GET['ins'] == 'key' ? 'list2' : 'list1') . '">3. <b>Nhập Key & Secret</b>';

if (isset($_GET['ins']) && $_GET['ins'] == 'key') {
    if (isset($_POST['ok_drb']) && !empty($_POST['key_drb']) && !empty($_POST['secret_drb'])) {
        $_SESSION['app_key'] = $_POST['key_drb'];
        $_SESSION['app_secret'] = $_POST['secret_drb'];
        try {
            $dropbox = new DropboxClient(array(
                'app_key' => $_POST['key_drb'],
                'app_secret' => $_POST['secret_drb'],
                'app_full_access' => true,
            ), 'en');
            handle_dropbox_auth($dropbox, $_SESSION['dir_tokens'], $_SESSION['file_tokens']);
        } catch (DropboxException $e) {
            echo '<br /><span style="color: red;font-weight:bold;">Lỗi: ' . htmlspecialchars($e->getMessage()) . '</span><br />';
            echo '<div class="auth"><form method="post"><div class="auth">Truy cập: <a href="https://www.dropbox.com/developers/apps">www.dropbox.com/developers/apps</a><br />để lấy Key & Secret</div>App Key:<br /><input type="text" name="key_drb" value="' . $_SESSION["app_key"] . '" class="pass" /><br />App Secret:<br /><input type="text" name="secret_drb" class="pass" value="' . $_SESSION["app_secret"] . '"/><br /><input type="submit" name="ok_drb" value="OK" />
</form>
</div>';
        }
    } elseif (!isset($_POST['ok_drb']) || empty($_POST['key_drb']) || empty($_POST['secret_drb'])) {
        echo '<div class="auth"><form method="post"><div class="auth">Truy cập: <a href="https://www.dropbox.com/developers/apps">www.dropbox.com/developers/apps</a><br />để lấy Key & Secret</div>App Key:<br /><input type="text" name="key_drb" value="' . $_SESSION["app_key"] . '" class="pass" /><br />App Secret:<br /><input type="text" name="secret_drb" class="pass" value="' . $_SESSION["app_secret"] . '"/><br /><input type="submit" name="ok_drb" value="OK" />
</form>
</div>';
    }
}

if ($_GET['ins'] == 'log' && isset($_GET['uid']) && ($_GET['uid'] = (int)$_GET['uid']) != '') {
    $dropbox = new DropboxClient(array(
        'app_key' => $_SESSION['app_key'],
        'app_secret' => $_SESSION['app_secret'],
        'app_full_access' => true,
    ), 'en');
    handle_dropbox_auth($dropbox, $_SESSION['dir_tokens'], $_SESSION['file_tokens']);
    $access_token = load_token($_SESSION['dir_tokens'], 'access-' . $_SESSION['file_tokens']);
    if (!empty($access_token)) {
        $dropbox->SetAccessToken($access_token);
    }
    $arr = obj2Ar($dropbox->GetAccountInfo());
    if ($arr['uid'] == $_GET['uid']) {
        $app_key = $_SESSION['app_key'];
        $app_secret = $_SESSION['app_secret'];
        $id_drb = $_GET['uid'];
        $fp = fopen('Install_thanh_cong.txt', 'w+');
        if (!feof($fp)) {
            fwrite($fp, $_SESSION['msg']);
        }
        fclose($fp);
        rename('config.php', 'config.php.txt');
        $readcf = file_get_contents('config.php.txt');
        rename('config.php.txt', 'config.php');
        $readcf = str_replace('<[[[DIR_TOKENS]]]>', $_SESSION['dir_tokens'], $readcf);
        $readcf = str_replace('<[[[FILE_TOKENS]]]>', $_SESSION['file_tokens'], $readcf);
        $ran1 = ran_string(5);
        $ran2 = ran_string(5);
        $readcf = str_replace('K_API', $ran1, $readcf);
        $readcf = str_replace('I_API', $ran2, $readcf);
        $fp = fopen('config.php', 'w+');
        if (!feof($fp)) {
            fwrite($fp, $readcf);
        }
        fclose($fp);
        $meta = $dropbox->UploadFile('i', $home . '/Install_thanh_cong.txt', 'Public/Install_thanh_cong.txt');
        $arrout = obj2Ar($meta);
        $outs = $arrout['bytes'];
        if ($outs == 310) {
            $insert = new ins;
            $insert->a = DROPBOX;
            $insert->j = $ran1;
            $insert->l = $ran2;
            $insert->i = $app_key;
            if ($insert->iii() != false) {
                $app_key = $insert->o;
                setcookie('update_key_drb', $app_key, time() + 3600 * 2);
            }
            $insert->i = $app_secret;
            if ($insert->iii() != false) {
                $app_secret = $insert->o;
                setcookie('update_secret_drb', $app_secret, time() + 3600 * 2);
            }
            setcookie('update_id_drb', $id_drb, time() + 3600 * 2);
            $tb4 = mysql_query("INSERT INTO `dropbox_config` SET `app_key`='" . $app_key . "' , `app_secret`='" . $app_secret . "' , `type`='l', `set`=0, `multi`=1, `id_drb`='" . $id_drb . "'") or exit(mysql_error());
            echo '<div class="auth"><b style="color: #009933;">Install thành công !</b><br /><b>Key: ' . $_SESSION["app_key"] . ' (SQL:' . $app_key . ')<br />Secret: ' . $_SESSION["app_secret"] . ' (SQL:' . $app_key . ')<br />ID: ' . $id_drb . ' </b><br />- <a href="' . $home . '"><b>Tới Site</b></a></div>';
        }
        unlink('install.php');
        unlink('Install_thanh_cong.txt');
    }
}
echo '</div>';
require('end.php');
?>