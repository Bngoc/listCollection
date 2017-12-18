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