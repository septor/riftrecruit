<?php
if (!defined('e107_INIT')) { exit; }
define("RIFTREC", e_PLUGIN."riftrecruit_menu/");
include_lan(RIFTREC."languages/".e_LANGUAGE.".php");

if(isset($pref['plug_installed']['avalanche'])){
	$useAvalanche = true;
}else{
	$useAvalanche = false;
}

$applyurl = ($useAvalanche == true ? e_PLUGIN."avalanche/apply.php" : (($pref['riftrecruit_url']) ? $pref['riftrecruit_url'] : "#"));

function recruitBlock($calling, $role, $needed){
	return "
	<tr>
		<td><img src='".RIFTREC."images/".strtolower($calling).".png' style='width:18px; height:18px; border='0'></td>
		<td style='text-align:right;'>".$needed."</td>
		<td><span class='".strtolower(str_replace(" ", "", $role))."'>".$role." ".$calling.($needed > 1 ? "s" : "")."</span></td>
	</tr>";
}

$text = "
<table border='0' style='width=100%' cellspacing='1' cellpadding='1'>
<tr>
	<td colspan='3' style='text-align: center;'>
		".RIFTREC_MENU01."<br />&nbsp;
	</td>
</tr>";

if($sql->db_Count("riftrecruit_needed", "(*)") > 0){
	$sql->db_Select("riftrecruit_needed", "*", "ORDER BY count DESC", "no-where");
	while($row = $sql->db_Fetch()){
		$text .= recruitBlock($row['calling'], $row['role'], $row['count']);
	}
}else{
	$text .= "<tr>
	<td colspan='3' style='text-align:center;'>".RIFTREC_MENU02."</td>
	</tr>";
}

$text .= "
<tr>
	<td colspan='3' style='text-align: center;'>
		<br /><a href='".$applyurl."'>".RIFTREC_MENU03."</a>
	</td>
</tr>
</table>";

$ns->tablerender(RIFTREC_MENU04, $text, 'riftrecruit');

?>