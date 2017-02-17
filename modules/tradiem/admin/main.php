<?php

/**
 * @Author GaNguCay (gangucay@gmail.com)
 * @createdate 05/09/2010
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$page_title = $lang_module['quanli_ds'];
	$lopid = $nv_Request->get_int ( 'lopid', 'post,get' );
	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post,get' );
	if (!empty($lopid) and !empty($manamhoc)){
	// Hien thi hop lua chon
	$contents .= "<div>";
    $contents .= "<form name=\"deltkb\" action=\"\" method=\"post\">";
    $contents .= "<table summary=\"\" class=\"table\">\n";
    $contents .= "<td>";
    $contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['quanli_td'] . "</font></b></center>";
    $contents .= "</td>\n";
    $contents .= "</table>";
	$contents .= "</form>";
    $contents .= "</div>";
		// Chon lop
		$contents .= "<form name=\"chon_ds\" method=\"post\">";
		$contents .= "<table summary=\"\" class=\"table\">\n";
		$contents .= "<td align = \"center\">";
		$contents .= '<select class="form-control" name ="lopid">';
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn lớp</option>";
		$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_lop";
		$result = $db->query( $sql);
		while ($dslop = $result->fetch())
		{
			if ($lopid == $dslop['lopid']){
				$tenlop = $dslop['tenlop'];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= '<option value=" ' . $dslop['lopid'] . '" " ' . $sel . ' ">&nbsp; ' . $dslop['tenlop'] . '</option>';
		}
		$contents .= "</select>&nbsp;&nbsp;";
		// Chon nam hoc
		$contents .= '<select class="form-control" name ="manamhoc">';
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn năm học</option>";
		$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_namhoc";
		$result = $db->query( $sql);
		while ($namhoc = $result->fetch())
		{
			if ($manamhoc == $namhoc['manamhoc']){
				$tennamhoc = $namhoc['tennamhoc'];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= '<option value="' . $namhoc['manamhoc'] . '" "' . $sel . '">&nbsp;' . $namhoc['tennamhoc'] . '</option>';
		}
		$contents .= "</select>";
		
		$contents .= "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value = \"" . $lang_module['thuchien'] . "\" /></center>";
		$contents .= "</td>\n";
		$contents .= "</table>";
		$contents .= "</form>";
		// Het hop lua chon
		$contents .= "<div>";
	    $contents .= "<form>";
	    $contents .= "<table summary=\"\" class=\"table\">\n";
	    $contents .= "<td>";
	    $contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['dshs_td'] . "".$tenlop."<br />" . $lang_module['namhoc_td'] ."".$tennamhoc."</font></b></center>";
	    $contents .= "</td>\n";
	    $contents .= "</table>";
		$contents .= "</form>";
	    $contents .= "</div>";

		$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_dshs WHERE lopid=".$lopid." AND manamhoc=".$manamhoc." ORDER BY mahs ASC";
		$result = $db->query( $sql);
		$contents .= "<table class=\"table\">\n";
		$contents .= "<thead>\n";
		$contents .= "<tr>\n";
		$contents .= "<td align='center'>" . $lang_module ['stt'] . "</td>\n";
		$contents .= "<td align='center'>" . $lang_module ['mahs'] . "</td>\n";
		$contents .= "<td align='center'>" . $lang_module ['hoten'] . "</td>\n";
		$contents .= "<td align='center'>" . $lang_module ['gtinh'] . "</td>\n";
		$contents .= "<td align='center'>" . $lang_module ['ngsinh'] . "</td>\n";
		$contents .= "<td align='center'>" . $lang_module ['noisinh'] . "</td>\n";
		
		$contents .= "<td align='center'>" . $lang_module ['quanli'] . "</td>\n";
		$contents .= "</tr>\n";
		$contents .= "</thead>\n";
		$gtinh = array(0 => 'Nữ', 1 => 'Nam');
		$a = 0;
		while ($dshs = $result->fetch())
		{
			$class = ($a % 2) ? " class=\"second\"" : "";
			$contents .= "<tbody" . $class . ">\n";
			$contents .= "<tr>\n";
			$contents .= "<td align=\"center\">" . ++$a . "</td>\n";
			$contents .= "<td align=\"center\">" . $dshs ['mahs']."</td>\n";
			$contents .= "<td align=\"left\">" . $dshs ['hoten']."</td>\n";
			$contents .= "<td align=\"center\">" . $gtinh[$dshs ['phai']]."</td>\n";
			$contents .= "<td align=\"center\">" . date('d/m/Y',$dshs ['ngaysinh'])."</td>\n";
			$contents .= "<td align=\"left\">" . $dshs ['noisinh']."</td>\n";
			$contents .= "<td align=\"center\">";
			$contents .= "<span class=\"edit_icon\"><a class='edit' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addhs&amp;id=" . $dshs ['id'] . "\">" . $lang_global ['edit'] . "</a></span>\n";
			$contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a class='del' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=delhs&amp;id=" . $dshs ['id'] . "\">" . $lang_global ['delete'] . "</a></span></td>\n";
			$contents .= "</tr>\n";
			$contents .= "</tbody>\n";
		}
	$contents .= "<tfoot><tr><td colspan='7'><span class=\"btn btn-primary\"><a class='add' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addhs&amp;lopid=" . $lopid . "&amp;manamhoc=" . $manamhoc . "\">" . $lang_global ['add'] . "</a></span></td></tr></tfoot>";
	$contents .= "</table>\n";
	
	$my_head .= '<script type="text/javascript" src="' . NV_BASE_SITEURL . 'themes/admin_default/modules/' . $module_file . '/popcalendar/popcalendar.js"></script>';
	// Het hien thi danh sach
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
		if (confirm('".$lang_module['delhs_del_confirm']."')){
			$.ajax({	
				type: 'POST',
				url: href,
				data: '',
				success: function(data){				
					alert(data);
					window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_mon';
				}
			});
		}
	});
	});
	var module_file = '" . $module_file . "';
	</script>
	";

	}else {
	$contents .= "<div>";
    $contents .= "<form name=\"deltkb\" action=\"\" method=\"post\">";
    $contents .= "<table summary=\"\" class=\"table\">\n";
    $contents .= "<td>";
    $contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['quanli_td'] . "</font></b></center>";
    $contents .= "</td>\n";
    $contents .= "</table>";
	$contents .= "</form>";
    $contents .= "</div>";
		// Chon lop
		$contents .= "<form name=\"chon_ds\" method=\"post\">";
		$contents .= "<table summary=\"\" class=\"table\">\n";
		$contents .= "<td align = \"center\">";
		$contents .= '<select class="form-control" name ="lopid">';
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn lớp</option>";
		$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_lop";
		$result = $db->query( $sql);
		while ($dslop = $result->fetch())
		{
			if ($lopid == $dslop['lopid']){
				$tenlop = $dslop['tenlop'];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= '<option value=" ' . $dslop['lopid'] . '" " ' . $sel . ' ">&nbsp; ' . $dslop['tenlop'] . '</option>';
		}
		$contents .= "</select>&nbsp;&nbsp;";
		// Chon nam hoc
		$contents .= '<select class="form-control" name ="manamhoc">';
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn năm học</option>";
		$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_namhoc";
		$result = $db->query( $sql);
		while ($namhoc = $result->fetch())
		{
			if ($manamhoc == $namhoc['manamhoc']){
				$tennamhoc = $namhoc['tennamhoc'];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= '<option value="' . $namhoc['manamhoc'] . '" "' . $sel . '">&nbsp;' . $namhoc['tennamhoc'] . '</option>';
		}
		$contents .= "</select>";
		
		$contents .= "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value = \"" . $lang_module['thuchien'] . "\" /></center>";
		$contents .= "</td>\n";
		$contents .= "</table>";
		$contents .= "</form>";
    }
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents);
include (NV_ROOTDIR . "/includes/footer.php");
