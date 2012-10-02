<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=wikimedias.csv");
header("Pragma: no-cache");
header("Expires: 0");

require_once("/etc/wikistats/config.php");

mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());
mysql_select_db("$dbname") or die(mysql_error());

$query = <<<FNORD
 (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikipedia' as type,good/total as ratio from wikipedias where prefix is not null)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikisource' as type,good/total as ratio from wikisources)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wiktionary' as type,good/total as ratio from wiktionaries)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikiquote' as type,good/total as ratio from wikiquotes)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikibooks' as type,good/total as ratio from wikibooks)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikinews' as type,good/total as ratio from wikinews)
 union all (select url,good,lang,loclang,total,edits,admins,users,images,ts,'special' as type,good/total as ratio from wmspecials)
 union all (select prefix,good,lang,loclang,total,edits,admins,users,images,ts,'wikiversity' as type,good/total as ratio from wikiversity)
 order by good desc,total desc,edits desc;
FNORD;

$result = mysql_query("$query") or die(mysql_error());
$count=1;
$cr = "\n";

echo "rank,prefix,type,language,loclang,good,total,edits,admins,users,images,stubratio,timestamp, $cr";

while($row = mysql_fetch_array( $result )) {
	echo "$count,".$row['prefix'].",".$row['type'].",".$row['lang'].",".$row['loclang'].",".$row['good'].",".$row['total'].",".$row['edits'].",".$row['admins'].",".$row['users'].",".$row['images'].",".$row['ratio'].",".$row['ts']."$cr";
	$count++;
}

mysql_close();
?>
