 
Trang lietke.php
<?php if($totalRows>0)
{
$i=0;
while ($row = mysql_fetch_array ($result))
{
$i+=1;
?>
<tr valign="top">
<td><input type=checkbox name=chkid value="<?=$row["SubCateID"]?>"> </td>
<td><?=$row["CateID"]?> </td>
<td><?=$row["SubCateID"]?> </td>
<td ><a href='capnhat.php?id=<?=$row['SubCateID"]?>">
<?=$row["SubCateName"]?></a></td>
</tr>
<?php
}
?>
<tr valign="top">
<td colspan="4" align="middle">
<hr noshade size="1">
</td>
</tr>
<tr valign="top">
<td colspan=3><input type=submit value="Delete">
<input type=hidden name=from_ value="subcategories">
<input type=hidden name=type value="0">
<input type=hidden name=chon value="">
<input type=button value="New"
onclick="window.open('them.php',target='_main')"></td>
<td >Tong so mau tin <?=$i?></td>
</tr>
<?php
}else{
?>
<tr valign="top">
<td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>
<td > <b><font face="Arial" color="#FF0000"> Oop! Ship not found!</font></b></td>
</tr>
<?php
}
?>
 

Trong đó, hai khai báo sau: 

<input type=hidden name=from_ value="subcategories">
<input type=hidden name=type value="0">
<input type=hidden name=chon value="">


Cho biết bạn submit từ trang nào và loại xoá nhiều mẩu tin hay một mẩu tin đối với bảng tương ứng. Mục đích của vấn đề này là trang delete sử dụng chung cho nhiều bảng khác nhau và từ trang liệt kê (xoá nhiều) hoặc từ trang edit (1 mẩu tin cụ thể). 

Ngoài ra, chúng ta khai báo <input type=hidden name=chon value=""> để nhận giá trị chọn trên cách checkbox bằng cách khai báo đoạn javascript như sau: 

<script>
function calculatechon()
{
var strchon="";
var alen=document.frmList.elements.length;
var buttons=1;

alen=(alen>buttons)?document.frmList.chkid.length:0;
if (alen>0)
{
for(var i=0;i<alen;i++)
if(document.frmList.chkid[i].checked==true)
strchon+=document.frmList.chkid[i].value+",";
}else
{
if(document.frmList.chkid.checked==true)
strchon=document.frmList.chkid.value;
}
}
</script>
document.frmList.chon.value=strchon;
return isok()


Tuy nhiên, do nhiều loại sản phẩm thuộc các nhóm sản phẩm khác nhau, chính vì vậy bạn khai báo danh sách nhóm sản phẩm trên thẻ select cho phép người sử dụng liệt kê sách theo nhóm sản phẩm như hình 2. 

  
Liệt kê danh sách loại sách.

Để liệt kê danh sách nhóm trong bảng tblCategories, bằng cách khai báo phương thức nhận chuỗi SQL dạng Select và giá trị mặc định trả về nhiều phần tử thẻ option trong tập tin database.php như ví dụ 2


Trang database.php
function optionselected($stSQL,$item,$links)
{
$results = mysql_query($stSQL, $links);
$totalRows=mysql_num_rows($results);
$strOption="<option value=\"\"  selected>";
$strOption .="--Select--</option>";
if($totalRows>0)
{
while ($row = mysql_fetch_array ($results))
{
$strOption .="<option value=\"" ;
$strOption .=$row["ID"]."\"";
if($row["ID"]==$item)
$strOption .=" selected  ";
$strOption .= ">".$row["Name"];
$strOption .="</option>";
}
}
return $strOption;
}
 

Sau đó, gọi phương thức này trong trang lietketheonhom.php như ví dụ 3. 


Trang lietketheonhom.php
<?php require("dbcon.php");
require("database.php");
$id="";
if (isset($cateid))
$id=$cateid;
$stSQL ="select CateID As ID, CateName as Name from tblCategories ";
$result = mysql_query($stSQL, $link);
$totalRows=mysql_num_rows($result);
$strOption=optionselected($stSQL,$id,$link);
?>
<form name=frmMain method=post>
<tr>
<td align=left colspan=4>
Category: <select name=cateid onchange="document.frmMain.submit();">

<?=$strOption?>
</select></td>
<td align=right>&nbsp;</td>
</tr>
</form>
 

Lần đầu tiên bạn có thể chọn mặc định một nhóm hoặc liệt kê tất cả, khi người sử dụng chọn nhóm sản phẩm nào đó thì trang lietketheonhom.php sẽ liệt kê danh sách loại sách của nhóm sách đó.

Để làm điều này, bạn khai báo thẻ form với thẻ select như ví dụ 4. 


<form name=frmMain method=post>
<tr>
<td align=left colspan=4>
Category: <select name=cateid onchange="document.frmMain.submit();">

<?=$strOption?>
</select></td>
<td align=right>&nbsp;</td>
</tr>
</form>


Khi người sử dụng chọn các mẩu tin như hình 2 và nhấn nút Delete, dựa vào giá trị của nút có tên action (trong trường hợp này là Delete), bạn có thể khai báo biến để lấy giá trị chọn bằng cách khai báo như ví dụ 5. 


$strid=$chon;
$strid=str_replace(",","','",$strid);


Dựa vào thẻ hidden khai báo trong các trang trình bày danh sách (chẳng hạn lietketheonhom.php) mẩu tin như sau:
<input  name="from" type=hidden value="subcategories">

Bạn có thể biết từ trang nào gọi đến trang dodelete.php để quay trở về khi thực hiện xong tác vụ xử lý.

Ngoài ra, dựa vào giá trị của nút action để thực hiện phát biểu SQL. Chẳng hạn, trong trường hợp này nếu người sử dụng nhấn hút Delete thì bạn khai báo như ví dụ 6 sau:


switch($strfrom)

{

case "subcategories":

$stSQL ="delete from tblsubcategories where SubCateID in('".$strid."')";

$strlocation="Location:lietketheonhom.php";

break;

case "categories":

$stSQL ="delete from tblcategories where CateID in('".$strid."')";

$strlocation="Location:nhom.php";

break;

}


Sau đó, bạn có thể thực thi phát biểu SQL vừa khai báo ở trên như ví dụ 7.


if($stSQL!="")
{
$result = mysql_query($stSQL, $link);
}


Lưu ý rằng, bạn cũng nên khai báo try catch trong khi làm việc với cơ sở dữ liệu. Ngoài ra, bạn cũng phải xác nhận trước khi thực thi hành động xoá mẩu tin chọn bằng cách khai báo đoạn Javascript như sau:


<script>
function isok()
{
return confirm('Are you sure to delete?');
}
</script>

    

Sau đó gọi trong biến cố onsubmit của form như sau:
<form action=dosql.php method=post onsubmit="return calculatechon();">


Cập nhật nhiều mẩu tin

Tương tự như trường hợp Delete, khi bạn duyệt (approval) một số mẩu tin theo một cột dữ liệu nào đó, chẳng hạn, trong trường hợp này chúng ta cho phép sử dụng những sản phẩm đã qua sự đồng ý của nhà quản lý thì cột dữ liệu Activate của bảng tbltems có giá trị là 1. 

Để làm điều này, trước tiên bạn liệt kê danh sách sản phẩm như hình 3.



  
Liệt kê danh sách sản phẩm duyệt hay chưa

Tương tự như trong trường hợp delete, bạn khai báo trang doUpdate như sau:
<HTML>
<HEAD>
<TITLE>::Welcome to PHP and mySQL</TITLE>
</HEAD>
<BODY>
<h3>Cap nhat mau tin</h3>
<?php require("dbcon.php");
$strid=$chon;
$strid=str_replace(",","','",$strid);
$strfrom="";
if(isset($from_))
{
$strfrom=$HTTP_POST_VARS{"from_"};
}
$strtype="";
if(isset($type))
{
$strtype=$HTTP_POST_VARS{"type"};
}

$stSQL="";
if($strfrom<>"")
{
switch($strfrom)
{
case "items":
$stSQL ="update tblItems set Activate=1 where ItemID
in('".$strid."')";
break;
}
if($stSQL!="")
{
$result = mysql_query($stSQL, $link);
if($result)
$affectrow=mysql_affected_rows();
mysql_close($link);
}
}
?>
So mau tin cap nhat <?= $affectrow?>
</BODY>
</HTML>



Kết luận

Trong bài này, chúng ta tìm hiểu chức năng xoá, cập nhật nhiều mẩu tin bằng cách sử dụng thẻ input loại checkbox cùng tên và khác giá trị, bài kế tiếp chúng ta tiếp tục tìm hiểu về chức năng đăng nhập trong PHP.
 



 

 Tweet 



  0  

 



 
    




Tải về 



Tái sử dụng 
 




 
Phạm Hữu Khang  Phạm Hữu Khang 
0 Giáo trình    |  11 Tài liệu   
 


Đánh giá:








 0 dựa trên 0 đánh giá  

Nội dung cùng tác giả



Phép toán và phát biểu có điều kiện trong PHP


Giới thiệu cơ sở dữ liệu MYSQL


Xóa và cập nhật dữ liệu dạng mảng trong PHP


Một số đối tượng truyền giá trị trong PHP


Khai báo hàm và chèn tập tin trong PHP


Khái quát về PHP


Biến Form trong PHP


PHP và Database


Các phát biểu về SQL


Xử lý chuỗi, mảng và các hàm ngày tháng trong PHP



Trước Tiếp 
  

Nội dung tương tự



PHP và Database


Biến Form trong PHP


Xử lý chuỗi, mảng và các hàm ngày tháng trong PHP


Danh sách mảng


Phép toán và phát biểu có điều kiện trong PHP


Đối tượng Form trong JavaScript


Giới thiệu cơ sở dữ liệu MYSQL


Sử dụng biểu mẫu và khung trong HTML


Khai báo biến và kiểu dữ liệu trong PHP


Đặc tả cấu trúc với XML-Schema



Trước Tiếp 
  





 


 


Thư viện Học liệu Mở Việt Nam (VOER) được tài trợ bởi Vietnam Foundation và vận hành trên nền tảng Hanoi Spring. Các tài liệu đều tuân thủ giấy phép Creative Commons Attribution 3.0 trừ khi ghi chú rõ ngoại lệ.

 
VOER on Facebook
  







   



 