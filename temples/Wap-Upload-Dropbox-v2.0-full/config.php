<?php
/*****************
 * Author: Phạm Dũng
 * Version: 2.0
 * Vui lòng tôn trọng bản quyền tác giả khi sử dụng. !!!!
 * Mọi thắc mắc liên hệ Email: PhamDung.itcn@gmail.com
 *****************/
defined('DROPBOX') or die('');
session_start();
error_reporting(E_ALL & ~E_NOTICE);


$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'dropbox';


$tenwap = 'Cloud upload 2013 - Chia sẻ dữ liệu miễn phí';
$copy = 'Phạm Dũng';
$st_file_upload = 'up-2box';
$home = 'http://';
$user_max = 20; //MB
$guest_max = 1; //MB
$min_size = 10; //Bytes
$max_disk_space = 90; //(90%)

date_default_timezone_set('Asia/Ho_Chi_Minh');
$con = mysql_connect($dbhost, $dbuser, $dbpass);
if ($con) {
    mysql_select_db($dbname, $con);
    mysql_query("SET NAMES 'utf8'", $con);
} else {
    die('');
}
if ((mysql_query("SELECT * FROM `dropbox_user` WHERE `id`=1 LIMIT 1") == FALSE || mysql_query("SELECT * FROM `dropbox_file` WHERE `id`=1 LIMIT 1") == FALSE || mysql_query("SELECT * FROM `dropbox_config` WHERE `id`=1 LIMIT 1") == FALSE) && $head != 'install' && file_exists('install.php')) {
    header('Location: install.php');
}

class ins
{
    public $a = '';
    public $i = '';
    public $j = 'NNrBg';
    public $l = 'oCnhY';
    public $o = '';

    public function iii()
    {
        if ($this->i != '') {
            $cip = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $qp = mcrypt_enc_get_iv_size($cip);
            if (mcrypt_generic_init($cip, $this->j . $this->a, $this->l . $this->a) != -1) {
                $cipt = mcrypt_generic($cip, $this->i);
                mcrypt_generic_deinit($cip);
                $this->o = bin2hex($cipt);
                return true;
            }
        } else {
            return false;
        }
    }

    public function ii()
    {
        if ($this->i != '') {
            $cip = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $qp = mcrypt_enc_get_iv_size($cip);
            if (mcrypt_generic_init($cip, $this->j . $this->a, $this->l . $this->a) != -1) {
                $cipt = mdecrypt_generic($cip, $this->hts($this->i));
                mcrypt_generic_deinit($cip);
                $this->o = $cipt;
                return true;
            } else {
                return false;
            }
        }
    }

    protected function hts($h)
    {
        if (!is_string($h)) {
            return null;
        }
        $char = '';
        for ($i = 0; $i < strlen($h); $i += 2) {
            $char .= chr(hexdec($h{$i} . $h{($i + 1)}));
        }
        return $char;
    }
}

if ($head != 'install' && $head != 'update') {
    $rmh = new ins;
    $rmh->a = DROPBOX;
    $config = mysql_fetch_assoc(mysql_query("SELECT * FROM `dropbox_config` WHERE `id`=1 LIMIT 1"));
    $type_dropbox = $config['type'];
    $rmh->i = $config['app_key'];
    if ($rmh->ii() != false) {
        $key_dropbox = trim($rmh->o);
    }
    $rmh->i = $config['app_secret'];
    if ($rmh->ii() != false) {
        $secret_dropbox = trim($rmh->o);
    }
    $id_dropbox = $config['id_drb'];
    $set_dropbox = $config['set'];
    $multi_dropbox = $config['multi'];
    $dir_tokens = 'JzClFWwXXaleeia';
    $file_tokens = 'TQtvbAgzMatSNIE';
}
if (file_exists('error_log')) {
    unlink('error_log');
}

function delete_token($dir, $name)
{
    @unlink('tokens-' . $dir . '/' . $name . '.token');
}

function store_token($token, $dir, $name)
{
    file_put_contents('tokens-' . $dir . '/' . $name . '.token', serialize($token));
}

function load_token($dir, $name)
{
    if (!file_exists('tokens-' . $dir . '/' . $name . '.token')) return null;
    return @unserialize(@file_get_contents('tokens-' . $dir . '/' . $name . '.token'));
}

function obj2Ar($d)
{
    if (is_object($d)) {
        $d = get_object_vars($d);
    }
    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}

function ran_string($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $size = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[rand(0, $size - 1)];
    }
    return $str;
}

function get_ext($name)
{
    $f1 = strrpos($name, '.');
    $f2 = substr($name, $f1 + 1, 999);
    $fname = strtolower($f2);
    return $fname;
}

function b_code($home, $id, $uid, $name, $size)
{
    $ext = strtolower(get_ext($name));
    $link = 'https://dl.dropboxusercontent.com/u/' . $uid . '/' . $name;
    echo '<div class="list2"><img src="' . $home . '/images/next.png">Link trực tiếp:<br /><textarea rows="1">' . $link . '</textarea></div><div class="list2"><img src="' . $home . '/images/next.png">Link page:<br /><textarea rows="1">' . $home . '/' . $id . '</textarea></div>';

    if ($ext == 'png' || $ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'bmp') {
        echo '<div class="list2"><img src="' . $home . '/images/next.png">BBcode nhúng Forum:<br /><textarea rows="1">[IMG]' . $link . '[/IMG]</textarea></div><div class="list2"><img src="' . $home . '/images/next.png">Code HTML:<br /><textarea rows="1"><img src="' . $link . '" alt="img"/></textarea></div>';
    } else {
        echo '<div class="list2"><img src="' . $home . '/images/next.png">BBcode nhúng Forum:<br /><textarea rows="1">Tải xuống [url=' . $link . ']' . $name . '[/url] (' . $size . ')</textarea></div><div class="list2"><img src="' . $home . '/images/next.png">Code HTML:<br /><textarea rows="1">Tải xuống <a href="' . $link . '">' . $name . '</a> (' . $size . ')</textarea></div>';
    }
}

function check_file($url)
{
    $arr = get_headers($url);
    if ($arr[0] == 'HTTP/1.1 200 OK' || strstr($arr[0], 'HTTP/1.1 200') == TRUE) {
        return '200';
    } elseif ($arr[0] == 'HTTP/1.1 404 NOT FOUND' || strstr($arr[0], 'HTTP/1.1 404') == TRUE) {
        return '404';
    } elseif ($arr[0] == 'HTTP/1.1 509 Bandwidth Error' || strstr($arr[0], 'HTTP/1.1 509') == TRUE) {
        return '509';
    }
}

function stime($time)
{
    $expl = explode('+', $time);
    $time = trim($expl[0]);
    $expm = explode(',', $time);
    $thuws = strtolower(trim($expm[0]));

    if ($thuws == 'mon') {
        $thuws = 'Thứ Hai';
    } elseif ($thuws == 'tue') {
        $thuws = 'Thứ Ba';
    } elseif ($thuws == 'wed') {
        $thuws = 'Thứ Tư';
    } elseif ($thuws == 'thu') {
        $thuws = 'Thứ Năm';
    } elseif ($thuws == 'fri') {
        $thuws = 'Thứ Sáu';
    } elseif ($thuws == 'sat') {
        $thuws = 'Thứ Bảy';
    } elseif ($thuws == 'sun') {
        $thuws = 'Chủ Nhật';
    }

    $date = date_create($expm[1]);
    date_add($date, date_interval_create_from_date_string("7 hours"));
    return $thuws . ', ' . trim(date_format($date, "H:i:s d-m-Y"));
}

function handle_dropbox_auth($dropbox, $dir, $name)
{
    $access_token = load_token($dir, 'access-' . $name);
    if (!empty($access_token)) {
        $dropbox->SetAccessToken($access_token);
    } elseif (!empty($_GET['auth_callback'])) {
        $request_token = load_token($dir, $_GET['oauth_token']);
        if (empty($request_token)) die('Request token not found!');

        $access_token = $dropbox->GetAccessToken($request_token);
        store_token($access_token, $dir, 'access-' . $name);
        delete_token($dir, $_GET['oauth_token']);
    }

    if (!$dropbox->IsAuthorized()) {
        $return_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?auth_callback=1&ins=log";
        $auth_url = $dropbox->BuildAuthorizeUrl($return_url);
        $request_token = $dropbox->GetRequestToken();
        store_token($request_token, $dir, $request_token['t']);
        echo '<div class="auth">Thành công. Nhấp vào <a href="' . $auth_url . '"><b>Đây</b></a> và click vào "<b>Allow</b>" để tiếp tục</div>';
    }
}

function view_date($var)
{
    $date = date("d.m.Y / H:i", $var);
    $day = time() - $var;
    $h = ceil($day / 3600);
    $p = ceil($day / 60);
    $s = $day;
    if (date('Y', $var) == date('Y', time())) {
        if (date('z', $var) == date('z', time())) {
            $date = ' ' . $h . ' giờ trước';
            if (date('H', $var) == date('H', time())) {
                $date = ' ' . $p . ' phút trước';
                if (date('i', $var) == date('i', time())) {
                    $date = ' ' . $s . ' giây trước';
                }
            }
        }
        if (date('z', $var) == date('z', time()) - 1) {
            $date = 'Hôm qua, ' . date("H:i", $var);
        }
    }
    return $date;
}

function showlas($pages, $u)
{
    if ($pages <= 7) {
        for ($i = 1; $i <= $pages; $i++) {
            if ($i == $_GET['page']) echo '<span class="currentpage"><b>' . $i . "</b></span>"; else
                echo '<a class="pagenav" href="?page=' . $i . $u . '">' . $i . '</a>';
            if ($i != $pages) echo ' ';
        }
    } else {
        if ($_GET['page'] <= 2 || $_GET['page'] >= $pages - 2) {
            if ($_GET['page'] == 1 || $_GET['page'] == $pages) {
                for ($i = 1; $i <= 2; $i++) {
                    if ($i == $_GET['page']) echo '<b>' . $i . '</b>'; else
                        echo '<a href="?page=' . $i . $u . '">' . $i . '</a>';
                }
                echo '..';
                for ($i = $pages - 1; $i <= $pages; $i++) {
                    if ($i == $_GET['page']) echo '<b>' . $i . '</b>'; else
                        echo '<a href="?page=' . $i . $u . '">' . $i . '</a>';
                }
            } else {
                if ($_GET['page'] <= 2) {
                    for ($i = 1; $i <= $_GET['page'] + 1; $i++) {
                        if ($i == $_GET['page']) echo '<b>' . $i . '</b>'; else
                            echo '<a href="?page=' . $i . $u . '">' . $i . '</a>';
                    }
                    echo '..';
                    for ($i = $pages - 1; $i <= $pages; $i++) {
                        if ($i == $_GET['page']) echo '<b>' . $i . '</b>'; else
                            echo '<a href="?page=' . $i . $u . '">' . $i . '</a>';
                    }
                } else {
                    for ($i = 1; $i <= 2; $i++) {
                        if ($i == $_GET['page']) echo '<b>' . $i . '</b>'; else
                            echo '<a href="?page=' . $i . $u . '">' . $i . '</a>';
                        if ($i != $_GET['page'] + 1) echo ',';
                    }
                    echo '..';
                    for ($i = $_GET['page'] - 1; $i <= $pages; $i++) {
                        if ($i == $_GET['page']) echo '<b>' . $i . '</b>'; else
                            echo '<a href="?page=' . $i . $u . '">' . $i . '</a>';
                    }
                }
            }
        } else {
            $i = 1;
            if ($_GET['page'] - 2 == 1) $p = ','; else $p = '..';
            echo '<a href="?page=' . $i . $u . '">' . $i . '</a>' . $p;

            //

            for ($i = $_GET['page'] - 1; $i <= $_GET['page'] + 1; $i++) {
                if ($i == $_GET['page']) echo '<b>' . $i . '</b>'; else
                    echo '<a href="?page=' . $i . $u . '">' . $i . '</a>';
                if ($i != $_GET['page'] + 1) echo ',';
            }
            echo '..';
            //

            $i = $pages;
            echo '<a href="?page=' . $i . $u . '">' . $i . '</a>';
        }
    }
}

ob_start();
if (isset($_SESSION['u_drb']) && isset($_SESSION['p_drb'])) {
    $user_id = abs(intval($_SESSION['u_drb']));
    $user_ps = $_SESSION['p_drb'];
} elseif (isset($_COOKIE['u_drb']) && isset($_COOKIE['p_drb'])) {
    $user_id = abs(intval(base64_decode(trim($_COOKIE['u_drb']))));
    $_SESSION['u_drb'] = $user_id;
    $user_ps = trim($_COOKIE['p_drb']);
    $_SESSION['p_drb'] = $user_ps;
}
if ($user_id && $head != 'install') {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM `dropbox_user` WHERE `id`='$user_id' LIMIT 1"));
    $login = $data['name'];
}
require_once('func.agent.php');
?>