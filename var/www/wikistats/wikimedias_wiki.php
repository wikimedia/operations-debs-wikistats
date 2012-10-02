<?php
# Wikistats by mutante - 2006-02-08 - S23 Wiki - http://s23.org
#
require_once("/etc/wikistats/config.php");

mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());
mysql_select_db("$dbname") or die(mysql_error());

$query = <<<FNORD
(select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikipedia' as type from wikipedias where prefix is not null)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikisource' as type from wikisources)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wiktionary' as type from wiktionaries)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikiquote' as type from wikiquotes)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikibooks' as type from wikibooks)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikinews' as type from wikinews)
 union all (select url,good,lang,loclang,total,edits,admins,users,images,ts,'special' as type from wmspecials)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikiversity' as type from wikiversity)
 order by good desc,total desc;
FNORD;

$result = mysql_query("$query") or die(mysql_error());
# echo "Sent query: '$query'.<br /><br />";
?>

<pre>
{| border="1" cellpadding="2" cellspacing="0" style="background: #f9f9f9; border: 1px solid #aaaaaa; border-collapse: collapse; white-space: nowrap; text-align: left" class="sortable"
|-
! &#8470;
! Type
! Project
! Language
! Good
! Total
! Edits
! Admins
! Users
! Images
! Updated
<?php
$count=1;
$gtotal=0;
$ggood=0;
$gedits=0;
$gadmins=0;
$gusers=0;
$gimages=0;

while($row = mysql_fetch_array( $result )) {

	$gtotal=$gtotal+$row['total'];
	$ggood=$ggood+$row['good'];
	$gedits=$gedits+$row['edits'];
	$gadmins=$gadmins+$row['admins'];
	$gusers=$gusers+$row['users'];
	$gimages=$gimages+$row['images'];

	switch ($row['type']) {
	case "wikipedia":
		$color="#ffffff";
	break;
	case "wiktionary":
		$color="#ff8080";
	break;
	case "wikisource":
		$color="#ffcc11";
	break;
	case "wikiquote":
		$color="blue";
	break;
	case "wikibooks":
		$color="purple";
	break;
	case "wikinews":
		$color="green";
	break;
	case "wikiversity":
		$color="#a66";
	break;
	case "special":
		$color="red";
	break;
	default:
	$color="white";
	}

	if ($row['type'] == "special") {
		$pieces = explode(".", $row['prefix']);
		$label = $pieces[0].".".$pieces[1];
		$prefix = $pieces[0];
		if ($prefix == "wikimediafoundation") {
			$prefix = "foundation";
		}
?>
|- style="text-align: right;"
| <?php echo $count; ?>

| style="background: <?php echo $color;?>;" |
| <?php echo "[//".$row['prefix']."/wiki/ $label]"; ?>

|
| <?php echo "[//".$row['prefix']."/wiki/Special:Statistics?action=raw '''".$row['good']; ?>''']
| <?php echo $row['total']; ?>

| style="font-size: 70%;" | <?php echo "[//".$row['prefix']."/wiki/Special:RecentChanges ".$row['edits']; ?>]
| style="font-size: 70%;" | <?php echo "[//".$row['prefix']."/wiki/Special:ListUsers/sysop ".$row['admins']; ?>]
| style="font-size: 70%;" | <?php echo "[//".$row['prefix']."/wiki/Special:ListUsers ".$row['users']; ?>]
| style="font-size: 70%;" | <?php echo "[//".$row['prefix']."/wiki/Special:FileList ".$row['images']; ?>]
| style="font-size: 70%;" | <?php echo $row['ts']; ?>

<?php
	} else {
?>
|- style="text-align: right;"
| <?php echo $count; ?>

| style="background: <?php echo $color;?>;" |
| <?php echo "[//".$row['prefix'].".".$row['type'].".org/wiki/ ".$row['prefix'].".".$row['type']."]"; ?>

| <?php echo "[[w:".$row['lang']." language|".$row['lang']."]]"; ?>

| <?php echo "[//".$row['prefix'].".".$row['type'].".org/wiki/Special:Statistics?action=raw '''".$row['good']; ?>''']
| <?php echo $row['total']; ?>

| style="font-size: 70%;" | <?php echo "[//".$row['prefix'].".".$row['type'].".org/wiki/Special:RecentChanges ".$row['edits']; ?>]
| style="font-size: 70%;" | <?php echo "[//".$row['prefix'].".".$row['type'].".org/wiki/Special:ListUsers/sysop ".$row['admins']; ?>]
| style="font-size: 70%;" | <?php echo "[//".$row['prefix'].".".$row['type'].".org/wiki/Special:ListUsers ".$row['users']; ?>]
| style="font-size: 70%;" | <?php echo "[//".$row['prefix'].".".$row['type'].".org/wiki/Special:FileList ".$row['images']; ?>]
| style="font-size: 70%;" | <?php echo $row['ts']; ?>

<?php
	}
	$count++;
}
mysql_close();
echo "|}\n\n";
include ("$IP/grandtotal_wiki.php");
?>
</pre>
