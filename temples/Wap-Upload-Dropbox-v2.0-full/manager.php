<?php
/*****************
 * Author: Phạm Dũng
 * Version: 2.0
 * Vui lòng tôn trọng bản quyền tác giả khi sử dụng. !!!!
 * Mọi thắc mắc liên hệ Email: PhamDung.itcn@gmail.com
 *****************/
define('DROPBOX', '_PHAM_DUNG_');
require('config.php');
$tieude = 'Quản lý File';
require('head.php');
if ($user_id != 1) {
    header('Location: index.php');
    exit();
}
echo '<div class="phdr"><b>Quản lý File</b></div>';
require_once('class/DropboxClient.php');
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

    echo '<div class="list2">';
    if ($_GET && $_GET['dir'] != '') {
        echo '<a href="' . $home . '/manager.php?dir=' . str_replace('/' . basename($_GET['dir']), '', $_GET['dir']) . '"><img src="' . $home . '/images/back.png" alt="back"></a>';
    } else {
        echo '<img src="' . $home . '/images/back.png">';
    }
    if (isset($_GET['dir']) && $_GET['dir'] != '') {
        $files = $dropbox_api->GetFiles(str_rot13($_GET['dir']), false);
        echo ' <a href="' . $home . '/manager.php"><span style="font-weight: bold;">Root</span></a> <span style="color: #808080; font-weight: normal;">»</span> <span style="font-weight: bold;">' . (basename(str_rot13($_GET['dir'])) != str_rot13($_GET['dir']) ? str_replace('/', ' <span style="color: #808080; font-weight: normal;">»</span> ', str_rot13($_GET['dir'])) : str_rot13($_GET['dir'])) . '</span> [<a href="' . $home . '/manager.php?dir=' . $_GET["dir"] . '&act=delete">Xoá</a>|<a href="' . $home . '/manager.php?dir=' . $_GET["dir"] . '&act=rename">Đổi tên</a>]</div>';
    } else {
        $files = $dropbox_api->GetFiles('', false);
        echo ' <span style="font-weight: bold;">Root</span> <span style="color: #808080; font-weight: normal;">»</span> </div>';
    }
    $dir = array_keys($files);

///////////////////
    if ($_POST['select'] == 'Copy' && $_POST['files'] != '') {
        $_SESSION['clipboard'] = $_POST['files'];
        echo '<div class="list1"><img src="' . $home . '/images/ok.gif" alt=""> Copy thành công vào clipboard !</div>';
    }
///////////////////
    if ($_GET['clipboard'] == 'delete') {
        unset($_SESSION['clipboard']);
        echo '<div class="list1"><img src="' . $home . '/images/ok.gif" alt=""> Đã xoá clipboard !</div>';
    }
///////////////////
    if ($_POST['paste'] == 'Move') {
        for ($x = 0; $x < count($_SESSION['clipboard']); $x++) {
            if ($dropbox_api->Move($_SESSION['clipboard'][$x], '/' . str_rot13($_GET['dir']) . '/' . basename($_SESSION['clipboard'][$x]))) {
                $ss = $ss + 1;
            }
        }
        if ($ss == count($_SESSION['clipboard'])) {
            header('Location: manager.php?dir=' . $_GET["dir"] . '&move_done=' . $ss);
        }
    }
///////////////////
    if (isset($_GET['move_done']) && $_GET['move_done'] != '') {
        unset($_SESSION['clipboard']);
        echo '<div class="list1"><img src="' . $home . '/images/ok.gif" alt=""> Di chuyển thành công <b>' . $_GET["move_done"] . '</b> Tập tin !</div>';
    }
///////////////////
    if ($_POST['paste'] == 'Paste') {
        for ($x = 0; $x < count($_SESSION['clipboard']); $x++) {
            if ($dropbox_api->Copy($_SESSION['clipboard'][$x], '/' . str_rot13($_GET['dir']) . '/' . basename($_SESSION['clipboard'][$x]))) {
                $ss = $ss + 1;
            }
        }
        if ($ss == count($_SESSION['clipboard'])) {
            header('Location: manager.php?dir=' . $_GET["dir"] . '&copy_done=' . $ss);
        }
    }
///////////////////
    if (isset($_GET['copy_done']) && $_GET['copy_done'] != '') {
        unset($_SESSION['clipboard']);
        echo '<div class="list1"><img src="' . $home . '/images/ok.gif" alt=""> Copy thành công <b>' . $_GET["copy_done"] . '</b> Tập tin !</div>';
    }
///////////////////
    if ($_POST['delete'] == 'Xóa') {
        if ($_POST['delete_done'] == 'Có' && $_POST['delete_done'] != 'Không') {
            foreach ($_POST['files'] as $file) {
                if ($dropbox_api->Delete($file)) {
                    $ss = $ss + 1;
                }
            }

            if ($ss == count($_POST['files'])) {
                header('Location: manager.php?dir=' . $_GET["dir"] . '&delete_done=' . $ss);
            }

        } elseif ($_POST['delete_done'] != 'Không') {
            echo '<div class="list1">Bạn có chắc chắn muốn xóa các file ?</div>';
            echo '<form action="manager.php?dir=' . $_GET["dir"] . '" method="post"><input type="hidden" name="delete" value="Xóa" />';
            foreach ($_POST['files'] as $file) {
                echo '<div class="list2"><input type="hidden" name="files[]" value="' . $file . '" />• ' . basename($file) . '</div>';
            }
            echo '<div class="list1"><input type="submit" name="delete_done" value="Có" />
<input type="submit" name="delete_done" value="Không" /></div></form>';
            require('end.php');
            exit();
        }
    }

///////////////////
    if (isset($_GET['delete_done']) && $_GET['delete_done'] != '') {
        echo '<div class="list1"><img src="' . $home . '/images/ok.gif" alt=""> Xóa thành công <b>' . $_GET["delete_done"] . '</b> Tập tin !</div>';
    }
///////////////////
    if ($_POST['create'] == 'Tạo Folder') {
        if ($_POST['create_done'] == 'Tạo') {
            if ($dropbox_api->CreateFolder('/' .
                (str_rot13($_GET['dir']) != '' ? str_rot13($_GET['dir']) . '/' : '') . $_POST['name_dir'])
            ) {
                header('Location: manager.php?dir=' . $_GET["dir"] . '&create_done=' . $_POST["name_dir"]);
            }
        } else {
            echo '<form action="manager.php?dir=' . $_GET["dir"] . '" method="post"><input type="hidden" name="create" value="Tạo Folder" /><div class="list1">Nhập tên thư mục cần tạo:</div><div class="list2"><input type="text" name="name_dir" value="New Folder" size="15" /></div><div class="list1"><input type="submit" name="create_done" value="Tạo" /></div></form>';
            require('end.php');
            exit();
        }
    }
///////////////////
    if (isset($_GET['create_done']) && $_GET['create_done'] != '') {
        echo '<div class="list1"><img src="' . $home . '/images/ok.gif" alt=""> Tạo thành công thư mục <b>' . $_GET["create_done"] . '</b> !</div>';
    }
////xxx///////////////

    if ($_GET['act'] == 'delete' && $_GET['dir'] != '') {
        if ($_POST['delete_dir_done'] != '' && $_POST['delete_done'] == 'Có' && $_POST['delete_done'] != 'Không') {
            if ($dropbox_api->Delete(str_rot13($_POST['delete_dir_done']))) {
                header('Location: manager.php?dir=' . (basename(str_rot13($_GET['dir'])) == str_rot13($_GET['dir']) ? '&delete_dir_done=' . $_POST["delete_dir_done"] : str_replace('/' . basename($_GET['dir']), '', $_GET['dir']) . '&delete_dir_done=' . $_POST["delete_dir_done"]));
            }
        } elseif ($_POST['delete_done'] != 'Không') {
            echo '<div class="list1">Bạn có thực sự muốn xoá thư mục <b>' . basename(str_rot13($_GET["dir"])) . '</b> và các thư mục, tập tin con trong nó ?</div>';

            echo '<form method="post"><input type="hidden" name="delete_dir_done" value="' . $_GET["dir"] . '" /><div class="list1"><input type="submit" name="delete_done" value="Có" />
<input type="submit" name="delete_done" value="Không" /></div></form>';

            for ($i = 0; $i < count($dir); $i++) {
                $info = obj2Ar($files[$dir[$i]]);
                if ($info['is_dir'] == 1) {
                    echo '<div class="list2"><img src="' . $home . '/images/dir' . ($info["icon"] == 'folder_public' ? '_public' : '') . '.png">  <a href="' . $home . '/manager.php?dir=' . str_rot13($dir[$i]) . '">' . basename($dir[$i]) . '</a></div>';
                }
            }


            for ($i = 0; $i < count($dir); $i++) {
                $info = obj2Ar($files[$dir[$i]]);
                if ($info['is_dir'] != 1) {
                    echo '<div class="list2"><img src="' . $home . '/images/icon_';
                    if ($info['icon'] == 'page_white_sound') {
                        echo 'sound';
                    } elseif ($info['icon'] == 'page_white_acrobat') {
                        echo 'acrobat';
                    } elseif ($info['icon'] == 'page_white_word') {
                        echo 'word';
                    } elseif ($info['icon'] == 'page_white_code') {
                        echo 'code';
                    } elseif ($info['icon'] == 'page_white_gear') {
                        echo 'gear';
                    } elseif ($info['icon'] == 'page_white_picture') {
                        echo 'img';
                    } elseif ($info['icon'] == 'page_white_compressed') {
                        echo 'zip';
                    } elseif ($info['icon'] == 'page_white_text') {
                        echo 'txt';
                    } else {
                        echo 'file';
                    }

                    echo '.png"> <input type="checkbox" name="files[]" value="' . $dir[$i] . '"/> <a href="' . $home . '/manager.php?file=' . str_rot13($dir[$i]) . '">' . basename($dir[$i]) . '</a> (' . $info["size"] . ')</div>';
                }
            }

            require('end.php');
            exit();
        } else {
            header('Location: manager.php?dir=' . $_GET["dir"]);
        }
    }
    if (isset($_GET['delete_dir_done']) && $_GET['delete_dir_done'] != '') {
        echo '<div class="list1"><img src="' . $home . '/images/ok.gif" alt=""> Xóa thành công thư mục <b>' . basename(str_rot13($_GET["delete_dir_done"])) . '</b> và các Thư mục, Tập tin con !</div>';
    }
////xxx///////////////
    if ($_GET['act'] == 'rename' && ($_GET['dir'] != '' || $_GET['file'] != '')) {
        if ($_POST['rename_dir_done'] != '' && $_POST['rename_done'] == 'Ok') {
            if ($dropbox_api->Move(str_rot13($_GET['dir'] . $_GET['file']), str_replace(basename(str_rot13($_GET['dir'] . $_GET['file'])), $_POST['rename_dir_done'], str_rot13($_GET['dir'] . $_GET['file'])))) {
                if ($_GET['dir'] != '') {
                    header('Location: manager.php?dir=' . str_rot13(str_replace(basename(str_rot13($_GET['dir'])), $_POST['rename_dir_done'], str_rot13($_GET['dir']))) . '&rename_dir_done=ok');
                } elseif ($_GET['file'] != '') {
                    header('Location: manager.php?file=' . str_rot13(str_replace(basename(str_rot13($_GET['file'])), $_POST['rename_dir_done'], str_rot13($_GET['file']))) . '&rename_file_done=ok');
                }
            }
        } else {
            echo '<div class="list1">Nhập tên mới:</div>';

            echo '<form method="post"><div class="list2"><input type="text" name="rename_dir_done" value="' . basename(str_rot13($_GET["dir"] . $_GET["file"])) . '" /></div><div class="list1"><input type="submit" name="rename_done" value="Ok" /></div></form>';
            require('end.php');
            exit();
        }
    }
    if (isset($_GET['rename_dir_done']) && $_GET['rename_dir_done'] == 'ok') {
        echo '<div class="list1"><img src="' . $home . '/images/ok.gif" alt=""> Đổi tên thư mục thành công !</div>';
    } elseif (isset($_GET['rename_file_done']) && $_GET['rename_file_done'] == 'ok') {
        echo '<div class="list1"><img src="' . $home . '/images/ok.gif" alt=""> Đổi tên file thành công !</div>';
    }
////xxx///////////////
    if (isset($_GET['file']) && $_GET['file'] != '' && (!isset($_GET['dir']) || $_GET['dir'] == '' || empty($_GET['dir']))) {
        $get_meta_files = $dropbox_api->GetMetadata(str_rot13($_GET['file']), false);
        $arrout = obj2Ar($get_meta_files);
        $ftime = stime($arrout['modified']);
        $fsize = $arrout['size'];

        $file_ext = get_ext(basename(str_rot13($_GET['file'])));
        $ext = strtolower($file_ext);


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

        echo '<div class="phdr">' . $iext . ' Thông Tin Tệp</div>';
        echo '<div class="list2">«<b>' . basename(str_rot13($_GET['file'])) . '</b>» (' . $fsize . ')</div>';
        echo '<div class="list2"><img src="' . $home . '/images/rnext.gif"> <b><a href="' . (check_file('https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . basename(str_rot13($_GET['file']))) == '200' ? 'https://dl.dropboxusercontent.com/u/' . $id_dropbox . '/' . basename(str_rot13($_GET['file'])) : $dropbox_api->GetLink(str_rot13($_GET['file']), false)) . '"><img src="' . $home . '/images/down.png">Tải xuống</a></b></div>';
        echo '<div class="list2"><img src="' . $home . '/images/rnext.gif"> <b><a href="' . $home . '/manager.php?file=' . $_GET["file"] . '&act=rename">Đổi tên</a></b></div>';
        echo '<div class="list2"><img src="' . $home . '/images/rnext.gif"> Ngày tải lên: ' . $ftime . '</div>';
        require('end.php');
        exit();
    }
////form///////////////
    echo '<form action="manager.php?dir=' . $_GET["dir"] . '" method="post">';
    for ($i = 0; $i < count($dir); $i++) {
        $info = obj2Ar($files[$dir[$i]]);
        if ($info['is_dir'] == 1) {
            echo '<div class="list2"><img src="' . $home . '/images/dir' . ($info["icon"] == 'folder_public' ? '_public' : '') . '.png">  <a href="' . $home . '/manager.php?dir=' . str_rot13($dir[$i]) . '">' . basename($dir[$i]) . '</a></div>';
        }
    }


    for ($i = 0; $i < count($dir); $i++) {
        $info = obj2Ar($files[$dir[$i]]);
        if ($info['is_dir'] != 1) {
            echo '<div class="list2"><img src="' . $home . '/images/icon_';
            if ($info['icon'] == 'page_white_sound') {
                echo 'sound';
            } elseif ($info['icon'] == 'page_white_acrobat') {
                echo 'acrobat';
            } elseif ($info['icon'] == 'page_white_word') {
                echo 'word';
            } elseif ($info['icon'] == 'page_white_code') {
                echo 'code';
            } elseif ($info['icon'] == 'page_white_gear') {
                echo 'gear';
            } elseif ($info['icon'] == 'page_white_picture') {
                echo 'img';
            } elseif ($info['icon'] == 'page_white_compressed') {
                echo 'zip';
            } elseif ($info['icon'] == 'page_white_text') {
                echo 'txt';
            } else {
                echo 'file';
            }
            echo '.png"> <input type="checkbox" name="files[]" value="' . $dir[$i] . '"/> <a href="' . $home . '/manager.php?file=' . str_rot13($dir[$i]) . '">' . basename($dir[$i]) . '</a> (' . $info["size"] . ')</div>';
        }
    }
    echo '<div class="list1"><script language="javascript" src="select-all-files.js"></script><input type="checkbox" onclick="toggle(this)" /> Chọn tất cả</div><div class="list1"><input type="submit" name="delete" value="Xóa" />
<input type="submit" name="create" value="Tạo Folder" />
<input type="submit" name="select" value="Copy" />
' .
        ($_SESSION['clipboard'] != '' ? '<input type="submit" name="paste" value="Paste" />
<input type="submit" name="paste" value="Move" />' : '') .
        '</div></form>';

    if ($_SESSION['clipboard'] != '') {
        echo '<div class="phdr"><b>Clipboard [' . count($_SESSION["clipboard"]) . ']</b> » <a href="' . $home . '/manager.php?clipboard=delete">[Xoá]</a></div>';
        for ($i = 0; $i < count($_SESSION['clipboard']); $i++) {
            echo '<div class="list1">• ' . basename($_SESSION['clipboard'][$i]) . '</div>';
        }
    }

} catch (DropboxException $e) {
    echo '<div class="phdr">Có Lỗi</div><div class="list2">' . htmlspecialchars($e->getMessage()) . '</div>';
}
require('end.php');
?>