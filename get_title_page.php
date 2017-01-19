<?php
include_once('includes/php/khoitao.php');
include_once('includes/php/fglobal.php');
include_once('ptemplates/home.php');
global $_POST;
global $_GET;
global $testkey;
$nn = docBien('lang');
if($nn=="en")
	include_once('includes/php/ngongu_en.inc');
	else include_once('includes/php/ngongu.inc');


						
function show($msg)
	{
$id = isset ( $_GET["id"] ) ? intval ( $_GET["id"] ) : 0;
$sql1="select maso_cat, code".$msg["nn"].", tieude, anh from projects where maso='".$id."'";
$result1=mysql_query($sql1);			
$row1=mysql_fetch_array($result1);
if(mysql_num_rows($result1))
{
$sql="SELECT id, thongtin".$msg["nn"].", anh FROM hinhdichvu WHERE maso_da='".$id."' order by id desc";
$rs = mysql_query($sql);
$s='<h3 class="title"><a href="{lang}trang-chu.html">{Trang chủ}</a> &raquo; <a href="{lang}phu-khoa.html">{Phụ khoa}</a> &raquo; '.cate_pro_name($id,$msg).'</h3>';
if(mysql_num_rows($rs))
{
$s.='
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.ad-gallery.css">
  <script type="text/javascript" src="js/jquery.ad-gallery.js"></script>
  <script type="text/javascript">
  $(function() {
    var galleries = $(".ad-gallery").adGallery();
    $("#switch-effect").change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $("#toggle-slideshow").click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
    $("#toggle-description").click(
      function() {
        if(!galleries[0].settings.description_wrapper) {
          galleries[0].settings.description_wrapper = $("#descriptions");
        } else {
          galleries[0].settings.description_wrapper = false;
        }
        return false;
      }
    );
  });
  </script>

  <div id="gallery" class="ad-gallery">
      <div class="ad-image-wrapper">
      </div>
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">';
$stt=0;
while($row=mysql_fetch_array($rs))
{
	if($stt==0)
	{
	$s.='<li style="display:none;">
              <a href="images/projects/'.$row['anh'].'">
                <img title="'.$row["thongtin".$msg["nn"].""].'" alt="'.$row["thongtin".$msg["nn"].""].'" src="images/projects/nth_'.$row['anh'].'" class="image'.$stt.'">
              </a>
            </li>';
			$stt++;
	}
	$s.='<li>
		  <a href="images/projects/'.$row['anh'].'">
			<img title="'.$row["thongtin".$msg["nn"].""].'" alt="'.$row["thongtin".$msg["nn"].""].'" src="images/projects/nth_'.$row['anh'].'" class="image'.$stt.'">
		  </a>
		</li>';
			$stt++;
}
        $s.='  </ul>
        </div>
      </div>
    </div>
  ';
}
else 


//thquangdung : thêm tiêu đề bài viết & bỏ ảnh đầu tiên
$s.='<div style = "text-transform: uppercase"><h2>'.$row1["tieude".$msg["nn"].""].'</h2></div>';
//$s.='<div align="center"><img title="'.$row1["tieude".$msg["nn"].""].'" alt="'.$row1["tieude".$msg["nn"].""].'" src="images/projects/'.$row1['anh'].'"/></div>';
//$s.='<h4>+ {Thông tin tóm lược}</h4>';
$s.='<div style="padding-left:15px;">'.$row1["code".$msg["nn"].""].'</div>';
$s.=othersda($row1["maso_cat"],$msg);	

}
else $s.='<h3>Không có thông tin.</h3>';
return pnprojectsct($s,$msg,"CTBanner");
	}

function othersda($maso_cat,$msg)
{
global $HTTP_POST_VARS;	
$id = isset ( $_GET["id"] ) ? intval ( $_GET["id"] ) : die("Không tồn tại trang này!");

$sql="SELECT  maso, tieude".$msg["nn"]." FROM  projects WHERE maso != ".$id." and maso_cat='".$maso_cat."' and  tinhtrang NOT LIKE 'Khoa' order by STT desc, maso desc limit 5";
$result=mysql_query($sql);

if(mysql_num_rows($result)!=0)
	{
	$s.= "
<h4>+ {Xem bài viết khác}:</h4>
<ul id=\"news\">";
while($row=mysql_fetch_array($result))
	{
$s.= "<li>";
$s.= "<div style=\"padding-left:15px;\"><a style=\"font-weight:normal;\" href=\"{lang}phu-khoa/".convert_unicode($row["tieude".$msg["nn"].""])."-ctct".$row["maso"].".html\">&raquo; ".$row["tieude".$msg["nn"].""]."</a>
</div>";	
$s.= "</li>";
	}
$s.= "</ul>
";
	}
return $s;
}
$ttp=$testkey;
createpage($msg,$db,$ttp);
?>
