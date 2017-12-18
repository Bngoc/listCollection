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
if ($_GET['notifi'] == 'off') {
    setcookie('noti', 'off', time() + 3600 * 24 * 7);
    header('Location: ' . $home . '/index.php');
}
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

    if (isset($_GET['delete']) && !empty($_GET['delete']) && $_GET['delete'] != '' && !isset($_GET['id']) && !isset($_GET['down'])) {
        if (mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE id=" . $_GET['delete'])) == 0) {
            $tieude = 'Error';
            require('head.php');
            throw new DropboxException('File bạn yêu cầu không tìm thấy, cũng có thể nó đã bị Admin xóa.');
        }
        $id = $_GET['delete'];
        $data = mysql_fetch_assoc(mysql_query("SELECT * FROM `dropbox_file` WHERE `id`='$id' LIMIT 1"));
        $file_name = $data['name'];
        $idup = $data['id_up'];
        if ($idup == $user_id || $user_id == 1) {
            if ($_POST['ok'] == 'ok') {
                mysql_query("DELETE FROM `dropbox_file` WHERE `id` = '$id'");
                if (($_POST['sv'] == 'xfile' && $user_id == 1) || $user_id != 1) {
                    $dropbox_api->Delete('Public/' . $data["name"]);
                }
                $tieude = 'Xoá tập tin «' . $data['name'] . '»';
                require('head.php');
                echo '<div class="phdr">Đã xoá tập tin</div><div class="list2">Đã xoá tập tin <b>«' . $data["name"] . '»</b></div>';
            } else {
                $tieude = 'Xoá tập tin «' . $data['name'] . '»';
                require('head.php');
                echo '<div class="phdr">Xác nhận xoá</div><div class="list2">Bạn có thực sự muốn xoá tập tin <b>«' . $data["name"] . '»</b><br/><form method="post">';
                if (check_file('https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name) == '200' && $user_id == 1) {
                    echo '<input type="checkbox" name="sv" value="xfile"/>Xoá file trên Server !<br/>';
                }
                echo '<input type="submit" name="ok" value="ok"/></form></div>';
            }
        } else {
            $tieude = 'Error';
            require('head.php');
            throw new DropboxException('Bạn không có quyền thực hiện hành động này !');
        }
    } elseif (isset($_GET['down']) && !empty($_GET['down']) && $_GET['down'] != '' && !isset($_GET['id']) && !isset($_GET['delete'])) {
        if (mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE id=" . $_GET['down'])) == 0) {
            $tieude = 'Error';
            require('head.php');
            throw new DropboxException('File bạn yêu cầu không tìm thấy, cũng có thể nó đã bị Admin xóa.');
        }
        $id = $_GET['down'];
        $data = mysql_fetch_assoc(mysql_query("SELECT * FROM `dropbox_file` WHERE `id`='$id' LIMIT 1"));
        $file_name = $data['name'];
        mysql_query("UPDATE dropbox_file SET `last_time`='" . time() . "', `count`=`count`+1 WHERE id=" . $_GET['down'] . ";") or die(mysql_error());
        header('location:https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name);
    } elseif (isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] != '' && !isset($_GET['down']) && !isset($_GET['delete'])) {
        if (mysql_num_rows(mysql_query("SELECT * FROM dropbox_file WHERE id=" . $_GET['id'])) == 0) {
            $tieude = 'Error';
            require('head.php');
            throw new DropboxException('File bạn yêu cầu không tìm thấy, cũng có thể nó đã bị Admin xóa.');
        }

        $id = $_GET['id'];
        $data = mysql_fetch_assoc(mysql_query("SELECT * FROM `dropbox_file` WHERE `id`='$id' LIMIT 1"));
        $idup = $data['id_up'];
        $file_ext = get_ext($data['name']);
        $file_name = $data['name'];
        $ext = strtolower($file_ext);
        $tieude = 'Tập tin «' . $data["name"] . '»';
        if (check_file('https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name) == '404') {
            require('head.php');
            mysql_query("DELETE FROM `dropbox_file` WHERE `id` = '$id'");
            echo '<div class="list2">Rất tiếc, Tập tin «<b style="color:#ff0000;">' . $data["name"] . '</b>» không tồn tại trên server ! Có thể do tập tin bị cấm hoặc bị xoá do vi phạm !</div>';
            require('end.php');
            exit();
        } elseif (check_file('https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name) == '509') {
            require('head.php');
            echo '<div class="list2">Rất tiếc, Lượng Download đang quá tải ! Tạm thời không thể truy cập ! Server mở cửa Download vào ngày <b>01-' . (date("m") + 1) . date("-Y") . '</b></div>';
            require('end.php');
            exit();
        } elseif (check_file('https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name) == '200') {
            $get_meta_files = $dropbox_api->GetMetadata('Public/' . $data['name'], false);
            $arrout = obj2Ar($get_meta_files);
            $ftime = stime($arrout['modified']);
            $head = 'index_' . $id;
            require('head.php');
            $fsize = $arrout['size'];

            $iext = '<img src="' . $home . '/images/other.png">';
            if ($ext == 'png' || $ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'bmp') {
                $iext = '<img src="' . $home . '/images/img.png">';
            }
            if ($ext == 'zip' || $ext == 'rar' || $ext == '7z' || $ext == 'gz' || $ext == 'tar' || $ext == 'bz' || $ext == 'bz2' || $ext == 'tgz') {
                $iext = '<img src="' . $home . '/images/zip.png">';
            }
            if ($ext == 'jar' || $ext == 'jad' || $ext == 'sis' || $ext == 'sisx') {
                $iext = '<img src="' . $home . '/images/java.png">';
            }
            if ($ext == 'exe' || $ext == 'bat' || $ext == 'pif' || $ext == 'msi' || $ext == 'pdf') {
                $iext = '<img src="' . $home . '/images/exe.png">';
            }
            if ($ext == 'mp3' || $ext == 'wav' || $ext == 'mid' || $ext == 'arm') {
                $iext = '<img src="' . $home . '/images/mp3.png">';
            }
            if ($ext == '3gp' || $ext == 'mpg' || $ext == 'mp4' || $ext == 'avi' || $ext == 'flv' || $ext == 'mkv') {
                $iext = '<img src="' . $home . '/images/videos.png">';
            }
            if ($ext == 'txt' || $ext == 'odt' || $ext == 'doc') {
                $iext = '<img src="' . $home . '/images/txt.png">';
            }

            echo '<div class="phdr">' . $iext . ' Thông Tin Tệp</div><div class="list2">';
            echo '«<b>' . $data['name'] . '</b>» (' . $fsize . ')<b><br />';

            echo '[<a href="' . $home . '/index.php?down=' . $id . '"><img src="' . $home . '/images/down.png">Tải xuống</a>]' . (($idup == $user_id || $user_id == 1) ? '<br />[<a href="' . $home . '/index.php?delete=' . $id . '">Xoá</a>]' : '') . '</b>';
            if ($ext == 'zip' || $ext == 'rar' || $ext == 'gz' || $ext == 'tar' || $ext == 'bz' || $ext == 'bz2' || $ext == 'tgz' || $ext == 'jar' || $ext == 'apk') {
                echo '<br /><form action="' . base64_decode('aHR0cDovL3dhcGluZXQucnUvYXJjaGl2ZS9leHRyYWN0LnBocD91cmw9JTUwJTY4JTYxJTZkJTIwJTQ0JTc1JTZlJTY3') . '" method="post" enctype="multipart/form-data" target="_blank"><input type="hidden" name="arh" size="22" value="https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name . '"><input type="submit" value="Giải nén"></form>';
            }
            if ($ext == 'exe' || $ext == 'bat' || $ext == 'pif' || $ext == 'msi') {
                echo '<br /><font color="red">Chú ý: Đây là file dùng trên PC, tải về file này PC của bạn có thể bị nhiễm virus, trojan, keylogger, hãy cẩn thận ! </font>';
            }

            if ($ext == 'png' || $ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg') {
                $si = getimagesize('https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name);
                if ($si[0] >= 240) {
                    $zoom = '200';
                } elseif ($si[0] < 240) {
                    $zoom = $si[0];
                }
                echo '<br /><img src="https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name . '" alt="' . $file_name . '" border="0" width="' . $zoom . '" />';
            }
            $dataup = mysql_fetch_assoc(mysql_query("SELECT * FROM `dropbox_user` WHERE `id`='$idup' LIMIT 1"));
            if (!isset($dataup['name']) || empty($dataup['name']) || $dataup['name'] == '') {
                $dataup['name'] = '<font color="blue">Khách</font>';
            }
            echo '</div>';
            echo '<div class="list2"><img src="' . $home . '/images/rnext.gif">Lượt tải: ' . $data["count"] . '</div>';
            if (isset($data['about']) && !empty($data['about'])) {
                echo '<div class="list2"><img src="' . $home . '/images/rnext.gif">Mô tả: ' . htmlspecialchars(stripslashes($data["about"])) . '</div>';
            }
            echo '<div class="list2"><img src="' . $home . '/images/rnext.gif">Ngày tải lên: ' . $ftime . '</div>';
            if ($data['last_time'] != 0 && !empty($data['last_time'])) {
                echo '<div class="list2"><img src="' . $home . '/images/rnext.gif">Tải cuối: ' . view_date($data["last_time"]) . '</div>';
            }
            echo '<div class="list2"><img src="' . $home . '/images/rnext.gif">Tải lên bởi: <b>' . ($idup == 1 ? '<font color="red">' . $dataup['name'] . '</font>' : $dataup['name']) . '</b></div>';
        }
        b_code($home, $id, $id_dropbox, $file_name, $fsize);
    } elseif (!$_GET) {
        $tieude = 'Trang Chủ';
        $head = 'index';
        require('head.php');
        if (!$user_id && !$_POST) {
            echo '<div class="phdr">Giới Thiệu</div><div class="list2">- DropBox là dịch vụ chia sẻ, lưu trữ file trực tuyến tuyệt vời cho bạn, với thuật toán đám mây (Cloud Storage)<br />- Đây là một dịch vụ có nhiệm vụ lưu trữ dữ liệu của bạn một cách nhanh chóng và bảo mật thông qua mạng Internet, tất cả các dữ liệu của bạn sẽ được lưu trữ trên Server của nhà cung cấp dịch vụ<br />- Và điều quan trọng là tập tin sẽ được lưu trữ <b>vĩnh viễn</b> (Trừ trường hợp bị admin xoá) nên bạn không phải lo về việc mất mát dữ liệu.</div>';
        }

        if ($_POST) {
            if ($user_id) {
                $max_size = $user_max * 1024 * 1024;
            } elseif (!$user_id) {
                $max_size = $guest_max * 1024 * 1024;
            }


            if ($_POST['type'] == 'f') {

                for ($si = 0; $si < $multi_dropbox; $si++) {
                    $fsize += $_FILES['file']['size'][$si];
                }


                if ($fsize <= $max_size && $fsize > $min_size) {
                    $total = 0;
                    for ($ei = 0; $ei < $multi_dropbox; $ei++) {
                        if ($_FILES['file']['name'][$ei] != '' && $_POST['type'] == 'f') {
                            $total = $total + 1;
                        }
                    }
                    $multi_dropbox = $total;
                    if ($multi_dropbox < 1) {
                        throw new DropboxException('Tập tin tải lên không thành công !');
                    }

                    for ($ri = 0; $ri < $multi_dropbox; $ri++) {
                        $cname = htmlspecialchars(stripslashes($_FILES['file']['name'][$ri]));
                        $file_ext = get_ext($_FILES['file']['name'][$ri]);
                        $file_name = basename($cname, $file_ext);
                        $special = array('=', '+', "'", '"', '`', '/', '!', '&', '*', ' ', '-', '
', '#', '@', '?', ';', '.', '<', '>', '__', '___', '____');
                        $new_file_name = str_replace($special, '_', $file_name);
                        $get_new_file = str_replace("/\0", '', $new_file_name) . '_' . ran_string(5) . '.' . (strstr($_FILES['file']['name'][$ri], '.') == TRUE ? $file_ext : 'unknow');
                        $tmpFile = htmlspecialchars(stripslashes(str_replace('__', '_', $get_new_file)));
                        $meta = $dropbox_api->UploadFile('u', $_FILES['file']['tmp_name'][$ri], 'Public/' . $tmpFile);
                        $arrout = obj2Ar($meta);
                        $outs = $arrout['size'];
                        if (isset($_POST['fdesc']) && !empty($_POST['fdesc']) && $user_id) {
                            if (strlen($_POST['fdesc']) > 500) {
                                $about = substr($_POST['fdesc'], 0, 499) . '[...]';
                            } else {
                                $about = $_POST['fdesc'];
                            }
                        }
                        mysql_query("INSERT INTO `dropbox_file` SET `id_up`='" . ($user_id ? $user_id : 0) . "' , `name`='" . $tmpFile . "' , `about`='" . $about . "', `count`=0") or exit(mysql_error());
                        $rid = mysql_insert_id();
                        echo '<div class="phdr">Upload Thành Công</div><div class="list2"><b>Tập tin: "' . $tmpFile . '" (' . $outs . ') tải lên thành công !<br /><br />» <a href="' . $home . '/' . $rid . '/' . $tmpFile . '">Xem tập tin</a><br />» <a href="http://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $tmpFile . '"><img src="' . $home . '/images/down.png">Tải xuống</a></b><br />';

                        if ($ext == 'png' || $ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg') {
                            $si = getimagesize('http://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name);
                            if ($si[0] >= 240) {
                                $zoom = '160';
                            } elseif ($si[0] < 240) {
                                $zoom = $si[0];
                            }
                            echo '<img src="http://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name . '" alt="' . $file_name . '" border="0" width="' . $zoom . '" /><br />';
                        }
                        echo '<br /></div>';
                        b_code($home, $rid, $id_dropbox, $tmpFile, $outs);
                    }
                } elseif ($fsize > $max_size) {
                    echo '<div class="phdr">Lỗi</div><div class="list2">Lỗi tải tập tin, Tập tin tải lên vượt quá giới hạn cho phép. Bạn chỉ có thể tải lên tối đa <b>' . ($user_id ? $user_max : $guest_max) . 'MB</b></div>';
                } elseif ($fsize <= $min_size) {
                    echo '<div class="phdr">Lỗi</div><div class="list2">Lỗi tải tập tin. Dung lượng tập tin tải lên quá thấp !</div>';
                }
            } elseif ($_POST['type'] == 'u' && !empty($_POST['import'])) {
                $f = @fopen($_POST['import'], 'r');
                if (!$f) {
                    throw new DropboxException('Liên kết Tập tin  ' . htmlspecialchars(stripslashes($_POST['import'])) . ' không có sẵn. Nó có thể đã bị xóa hoặc bạn nhập một đường dẫn không đúng. !');
                } else {
                    while ($c = fread($f, 1024)) {
                        $data_import .= $c;
                    }
                    $fsize = strlen($data_import);
                }

                if ($fsize <= $max_size && $fsize > $min_size) {
                    $cname = @htmlspecialchars(stripslashes(end(explode('/', $_POST['import']))));
                    $file_ext = get_ext($_POST['import']);
                    $file_name = basename($cname, $file_ext);
                    $special = array('=', '+', "'", '"', '`', '/', '!', '&', '*', ' ', '-', '
', '#', '@', '?', ';', '.', '<', '>', '__', '___', '____');
                    $new_file_name = str_replace($special, '_', $file_name);
                    $get_new_file = str_replace("/\0", '', $new_file_name) . '_' . ran_string(5) . '.' . (strstr($cname, '.') == TRUE ? $file_ext : 'unknow');
                    $tmpFile = htmlspecialchars(stripslashes(str_replace('__', '_', $get_new_file)));
                    $meta = $dropbox_api->UploadFile('i', $_POST['import'], 'Public/' . $tmpFile);
                    $arrout = obj2Ar($meta);
                    $outs = $arrout['size'];
                    if (isset($_POST['fdesc']) && !empty($_POST['fdesc']) && $user_id) {
                        if (strlen($_POST['fdesc']) > 500) {
                            $about = substr($_POST['fdesc'], 0, 499) . '[...]';
                        } else {
                            $about = $_POST['fdesc'];
                        }
                    }
                    mysql_query("INSERT INTO `dropbox_file` SET `id_up`='" . ($user_id ? $user_id : 0) . "' , `name`='" . $tmpFile . "' , `about`='" . $about . "', `count`=0") or exit(mysql_error());
                    $rid = mysql_insert_id();
                    echo '<div class="phdr">Upload Thành Công</div><div class="list2"><b>Tập tin: "' . $tmpFile . '" (' . $outs . ') tải lên thành công !<br /><br />» <a href="' . $home . '/' . $rid . '/' . $tmpFile . '">Xem tập tin</a><br />» <a href="http://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $tmpFile . '"><img src="' . $home . '/images/down.png">Tải xuống</a></b><br />';

                    if ($ext == 'png' || $ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg') {
                        $si = getimagesize('http://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name);
                        if ($si[0] >= 240) {
                            $zoom = '160';
                        } elseif ($si[0] < 240) {
                            $zoom = $si[0];
                        }
                        echo '<img src="http://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . $file_name . '" alt="' . $file_name . '" border="0" width="' . $zoom . '" /><br />';
                    }
                    echo '<br /></div>';
                    b_code($home, $rid, $id_dropbox, $tmpFile, $outs);
                } elseif ($fsize > $max_size) {
                    echo '<div class="phdr">Lỗi</div><div class="list2">Lỗi tải tập tin, Tập tin tải lên vượt quá giới hạn cho phép. Bạn chỉ có thể tải lên tối đa <b>' . ($user_id ? $user_max : $guest_max) . 'MB</b></div>';
                } elseif ($fsize <= $min_size) {
                    echo '<div class="phdr">Lỗi</div><div class="list2">Lỗi tải tập tin. Dung lượng tập tin tải lên quá thấp !</div>';
                }
            }
        } elseif (!$_POST) {
            echo '<div class="phdr">Dropbox Uploader</div><div class="list2"><form action="index.php" method="POST" enctype="multipart/form-data">';
            if ($user_id) {
                echo '<input type="radio" name="type" value="f" checked=""/> ';
            } elseif (!$user_id) {
                echo '<input style="display:none" type="radio" name="type" value="f" checked=""/> ';
            }
            echo 'Chọn tập tin (Max <b style="color:#ff0000;">' . ($user_id ? $user_max : $guest_max) . 'MB</b>)<br />';

            if ($user_id) {
                for ($i = 0; $i < $multi_dropbox; $i++) {
                    echo '<input type="file" name="file[]" style="width: 100%;" />' . ($i == ($multi_dropbox - 1) ? '' : '<br />');
                }
            } else {
                echo '<input type="file" name="file" style="width: 100%;" />';
            }

            if ($user_id) {
                echo '<br /><input type="radio" name="type" value="u" /> Nhập Url (Max <b style="color:#ff0000;">' . ($user_id ? $user_max : $guest_max) . 'MB</b>)<br /><input type="text" name="import" value="http://" size="15" /><br />Mô tả: (Max 500)<br /><textarea type="text" name="fdesc" value="" size="15" /></textarea><br />';
            }
            echo '<input type="submit" value="Tải lên" /><input style="display:none" type="text" name="dest" value="Public" /></div>';
        }
        echo '<div class="phdr">Tập tin</div>';
        echo '<div class="list2">• <a href="view.php">Danh sách tập tin</a></div>';
        echo '<div class="list2">• <a href="search.php">Tìm kiếm</a></div>';
        if ($user_id) {
            echo '<div class="phdr">Tài Khoản</div>';
            echo '<div class="list2">• <a href="office.php">Tài khoản</a></div>';
            if ($user_id == 1) {
                echo '<div class="list2">• <a href="manager.php">Quản lý File</a></div>';
            }
            echo '<div class="list2">• <a href="myfile.php">Tập tin của tôi</a></div>';
            echo '<div class="list2">• <a href="logout.php">Thoát</a></div>';
        }
        echo '<div class="phdr">Thông tin khác</div>';
        echo '<div class="list2">• Upload Max <b>' . ($user_id ? $user_max : $guest_max) . 'MB</b></div>';
        echo '<div class="list2">• Tập tin: <b>' . mysql_result(mysql_query("SELECT COUNT(*) FROM `dropbox_file`"), 0) . '</b> File</div>';
        $disk = obj2Ar($dropbox_api->GetAccountInfo());
        $quota = $disk['quota_info']['quota'];
        $normal = $disk['quota_info']['normal'];
        $ptus = round((($normal / $quota) * 100), 2);
        if ($type_dropbox == 'f' || $user_id == 1) {
            echo '<div class="list2">• Không gian đĩa: <b>' . round($quota / (1024 * 1024 * 1024), 2) . ' GB</b></div>';
            echo '<div class="list2">• Đã sử dụng: <b>';
            if ($normal < 1024) {
                echo $normal . ' B';
            } elseif ($normal >= 1024 && $normal < (1024 * 1024)) {
                echo round($normal / 1024, 2) . ' KB';
            } elseif ($normal >= (1024 * 1024) && $normal < (1024 * 1024 * 1024)) {
                echo round($normal / (1024 * 1024), 2) . ' MB';
            } elseif ($normal >= (1024 * 1024 * 1024)) {
                echo round($normal / (1024 * 1024 * 1024), 2) . ' GB';
            }
            echo ' (' . $ptus . '%)</b></div>';
        }
        if ($ptus >= $max_disk_space) {
            mysql_query("UPDATE dropbox_config SET `set`=1 WHERE id=1;") or die(mysql_error());
        }

        echo '<div class="list2">• Thành viên: <b>' . mysql_result(mysql_query("SELECT COUNT(*) FROM `dropbox_user`"), 0) . '</b></div>';
        echo '<div class="list2">• IP của bạn: ' . get_ip() . '</div>';
        echo '<div class="list2">• Không Upload xxx</div>';

    }
} catch (DropboxException $e) {
    echo '<div class="phdr">Có Lỗi</div><div class="list2">' . htmlspecialchars($e->getMessage()) . '</div>';
}
require('end.php');
?>