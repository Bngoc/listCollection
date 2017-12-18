<?php
//$_POST["page"] =1;
// KIỂM TRA TỒN TẠI PAGE HAY KHÔNG
if(isset($_POST["page"]))
{
	// ĐƯA 2 FILE VÀO TRANG & KHỞI TẠO CLASS
	include "db.php";
	require_once "paging_ajax.php";
	$paging = new paging_ajax();
	
	
	// ĐẶT CLASS CHO THÀNH PHẦN PHÂN TRANG THEO Ý MUỐN
	$paging->class_pagination = "pagination";
	$paging->class_active = "active";
	$paging->class_inactive = "inactive";
	$paging->class_go_button = "go_button";
	$paging->class_text_total = "total";
	$paging->class_txt_goto = "txt_go_button";

	// KHỞI TẠO SỐ PHẦN TỬ TRÊN TRANG
    $paging->per_page = 5; 	
    
    // LẤY GIÁ TRỊ PAGE THÔNG QUA PHƯƠNG THỨC POST
    $paging->page = $_POST["page"];
    
    // VIẾT CÂU TRUY VẤN & LẤY KẾT QUẢ TRẢ VỀ
    $paging->text_sql = "SELECT * FROM member";
    $result_pag_data = $paging->GetResult();

	
	//echo $paging->page . " <br>";
	//echo $paging->text_sql . " <br>";
	//echo "array: ".  $paging->GetResult() . " <br>";
	//echo $result_pag_data; //exit();
     //BIẾN CHỨA KẾT QUẢ TRẢ VỀ
	$message = "";
	
	// DUYỆT MẢNG LẤY KẾT QUẢ
	while ($row = mysqli_fetch_array($result_pag_data,MYSQLI_ASSOC)) {
		$message .= "<li><strong>" . $row['id'] . "</strong> " . $row['phone'] . "</li>";
	}

	// ĐƯA KẾT QUẢ VÀO PHƯƠNG THỨC LOAD() TRONG LỚP PAGING_AJAX
	$paging->data = "<div class='data'><ul>" . $message . "</ul></div>"; // Content for Data    
	echo $paging->Load();  // KẾT QUẢ TRẢ VỀ
		
} 

