<?php

$menutitle  = "Rift Recruit Navigation";

$butname[]  = "Configuration";
$butlink[]  = "admin_config.php";
$butid[]    = "config";

$butname[]  = "Manage Recruitment";
$butlink[]  = "admin_manage.php";
$butid[]    = "manage";

$butname[]  = "Add New Request";
$butlink[]  = "admin_add.php";
$butid[]    = "add";

global $pageid;
for ($i=0; $i<count($butname); $i++) {
	$var[$butid[$i]]['text'] = $butname[$i];
	$var[$butid[$i]]['link'] = $butlink[$i];
};

show_admin_menu($menutitle, $pageid, $var);

?>
