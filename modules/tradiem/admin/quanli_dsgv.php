<?php
/**
 * @Author GaNguCay (gangucay@gmail.com)
 * @createdate 05/09/2010
 */

if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );
$page_title = $lang_module ['quanli_dsgv'];
// Hien thi tieu de
$contents .= "<div>";
$contents .= "<form name=\"deltkb\" action=\"\" method=\"post\">";
$contents .= "<table summary=\"\" class=\"table\">\n";
$contents .= "<td>";
$contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['quanli_dsgv_td'] . "</font></b></center>";
$contents .= "</td>\n";
$contents .= "</table>";
$contents .= "</form>";
$contents .= "</div>";

$contents .= "<table class=\"table\">\n";
$contents .= "<thead>\n";
$contents .= "<tr>\n";
$contents .= "<td align='center'>" . $lang_module ['stt'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['gvid'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['tengv'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['user'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['cn'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['active'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['quanli'] . "</td>\n";
$contents .= "</tr>\n";
$contents .= "</thead>\n";

$page = $nv_Request->get_int ( 'page', 'get', 0 );
$per_page = 20;
$base_url = NV_BASE_ADMINURL.'index.php?'.NV_NAME_VARIABLE.'='.$module_name.'&amp;'. NV_OP_VARIABLE .'=quanli_dsgv';
$query = $db->query ( "SELECT gvid FROM " . NV_PREFIXLANG . "_" . $module_data . "_dsgv" );
$all_page = $query->rowCount();
$a = 0;
$sql = "SELECT *  FROM " . NV_PREFIXLANG . "_" . $module_data . "_dsgv ORDER BY gvid ASC LIMIT $page,$per_page";
$result = $db->query ( $sql );

while ( $row = $result->fetch() ) {
	// Kiem tra trang thai lua chon
    $ch_cn = ($row['chunhiem'] == 1?'checked':'');
    $ch_kh = ($row['active'] == 1?'checked':'');

	$class = ($a % 2) ? " class=\"second\"" : "";
	$contents .= "<tbody" . $class . ">\n";
	$contents .= "<tr>\n";
	$contents .= "<td align=\"center\">" . ++$a . "</td>\n";
	$contents .= "<td align=\"center\">" . $row ['gvid']."</td>\n";
	$contents .= "<td align=\"left\">" . $row ['tengv']."</td>\n";
	$contents .= "<td align=\"center\">" . $row ['user']."</td>\n";
	$contents .= "<td align=\"center\"><input type=\"checkbox\" name=\"chunhiem\" value=\"1\" ". $ch_cn ."  id=\"change_cn_" . $row['gvid'] . "\" onclick=\"nv_chang_cn(" . $row['gvid'] . ");\" /></td>\n";
	$contents .= "<td align=\"center\"><input type=\"checkbox\" name=\"active\" value=\"1\" ". $ch_kh ."  id=\"change_kh_" . $row['gvid'] . "\" onclick=\"nv_chang_kh(" . $row['gvid'] . ");\" /></td>\n";
	$contents .= "<td align=\"center\" width = \"20%\">";
	$contents .= "<span class=\"edit_icon\"><a class='edit' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addgv&amp;id=" . $row ['gvid'] . "\">" . $lang_global ['edit'] . "</a></span>\n";
	$contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a class='del' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=delgv&amp;id=" . $row ['gvid'] . "\">" . $lang_global ['delete'] . "</a></span></td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	//$a ++;
}
$contents .= "<tfoot><tr><td colspan='7'><span class=\"btn btn-primary\"><a class='add' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addgv\">" . $lang_global ['add'] . "</a></span>&nbsp;&nbsp;</td></tr></tfoot>";
$contents .= "</table>\n";
//$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";

$generate_page = nv_generate_page ( $base_url, $all_page, $per_page, $page );
if (! empty ( $generate_page ))
	$contents .= "<br><p align=\"center\">" . $generate_page . "</p>\n";
$contents .= "<div id='contentedit'></div><input id='hasfocus' style='width:0px;height:0px'/>";
$contents .= "
<script type='text/javascript'>
$(function(){
$('a[class=\"add\"]').click(function(event){
	event.preventDefault();
	var href= $(this).attr('href');
	$('#contentedit').load(href,function(){
		$('#hasfocus').focus();
	});

});
$('a[class=\"edit\"]').click(function(event){
	event.preventDefault();
	var href= $(this).attr('href');
	$('#contentedit').load(href,function(){
		$('#hasfocus').focus();
	});
});

$('a[class=\"del\"]').click(function(event){
	event.preventDefault();
	var href= $(this).attr('href');
	if (confirm('".$lang_module['delgv_del_confirm']."')){
		$.ajax({	
			type: 'POST',
			url: href,
			data: '',
			success: function(data){				
				alert(data);
				window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_dsgv';
			}
		});
	}
});
});
</script>
";
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents );
include (NV_ROOTDIR . "/includes/footer.php");
