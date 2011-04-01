<?php
if(!defined("e107_INIT")) {
	require_once("../../class2.php");
}
require_once(e_HANDLER."userclass_class.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");
include_lan(e_PLUGIN."riftrecruit_menu/languages/".e_LANGUAGE.".php");

// until I work up the motivation to manage this better
$calling = array(
	0 => 	RIFTREC_CLERIC,
	1 => 	RIFTREC_MAGE,
	2 => 	RIFTREC_ROGUE,
	3 => 	RIFTREC_WARRIOR
);
$role = array(
	RIFTREC_CLERIC => array(RIFTREC_MELEE, RIFTREC_RANGED, RIFTREC_HEALING, RIFTREC_TANK),
	RIFTREC_MAGE => array(RIFTREC_RANGED, RIFTREC_HEALING, RIFTREC_SUPPORT),
	RIFTREC_ROGUE => array(RIFTREC_MELEE, RIFTREC_RANGED, RIFTREC_TANK, RIFTREC_SUPPORT),
	RIFTREC_WARRIOR => array(RIFTREC_MELEE, RIFTREC_RANGED, RIFTREC_TANK, RIFTREC_SUPPORT)
);


if(isset($_POST['add'])){
	if($_POST['count'] >= 0 && is_numeric($_POST['count'])){
		$calling_role = explode(".", $_POST['calling_role']);
		$sql->db_Insert("riftrecruit_needed", "'', '".intval($_POST['count'])."', '".$tp->toDB($calling[$calling_role[0]])."', '".$tp->toDB($role[$calling[$calling_role[0]]][$calling_role[1]])."'") or die(mysql_error());
		$message = RIFTREC_ADD01.$_POST['count']." ".$role[$calling[$calling_role[0]]][$calling_role[1]]." ".$calling[$calling_role[0]].($_POST['count'] > 1 ? "s" : "")."!";
	}else{
		$message = RIFTREC_ADD02;
	}
}

if (isset($message)) {
	$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}

if(check_class($pref['riftrecruit_manageclass'])){

	$text = "
	<div style='text-align:center'>
	<form method='post' action='".e_SELF."'>
	<table style='width:50%' class='fborder'>
	<td style='width:70%;' class='fcaption'>".RIFTREC_ADD03."</td>
	<td style='width:20%;' class='fcaption'>".RIFTREC_ADD04."</td>
	<td style='width:10%;' class='fcaption'>&nbsp;</td>
	<tr>
	<td style='width:70%; text-align:center;' class='forumheader3'>
	<select name='calling_role' class='tbox'>";
	for($i = 0; $i <= (count($calling)-1); $i++){
		$text .= "<option value='".$i.".0'>".$role[$calling[$i]][0]." ".$calling[$i]."</option>
		<option value='".$i.".1'>".$role[$calling[$i]][1]." ".$calling[$i]."</option></option>
		<option value='".$i.".2'>".$role[$calling[$i]][2]." ".$calling[$i]."</option></option>";
	}
	$text .= "</select>
	</td>
	<td style='width:20%; text-align:center;' class='forumheader3'>
	<input  size='10' class='tbox' type='text' name='count' value=''>
	</td>
	<td style='width:10%; text-align:center;' class='forumheader3'>
	<input class='button' type='submit' name='add' value='".RIFTREC_ADD05."' />
	</td>
	</tr>
	</table>
	</form>
	</div>
	";

}else{
	$text = RIFTREC_ADD06;
}

$ns->tablerender(RIFTREC_ADD07, $text);
require_once(e_ADMIN."footer.php");
?>