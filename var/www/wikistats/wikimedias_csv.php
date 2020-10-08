<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=wikimedias.csv");
header("Pragma: no-cache");
header("Expires: 0");

# enable CORS (T193094)
header("Access-Control-Allow-Origin: *");

require_once("/etc/wikistats/config.php");

# db connect
try {
    $wdb = new PDO("mysql:host=${dbhost};dbname=${dbname}", $dbuser, $dbpass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br />";
    die();
}

$default_fields="prefix,good,lang,loclang,total,edits,admins,users,activeusers,images,ts";

$query = <<<FNORD
 (select ${default_fields},'wikipedia' as type,good/total as ratio from wikipedias where prefix is not null)
 union all (select ${default_fields},'wikisource' as type,good/total as ratio from wikisources)
 union all (select ${default_fields},'wiktionary' as type,good/total as ratio from wiktionaries)
 union all (select ${default_fields},'wikiquote' as type,good/total as ratio from wikiquotes)
 union all (select ${default_fields},'wikibooks' as type,good/total as ratio from wikibooks)
 union all (select ${default_fields},'wikinews' as type,good/total as ratio from wikinews)
 union all (select ${default_fields},'wikiversity' as type,good/total as ratio from wikiversity)
 union all (select ${default_fields},'wikivoyage' as type,good/total as ratio from wikivoyage)
 union all (select url,good,lang,loclang,total,edits,admins,users,activeusers,images,ts,'special' as type,good/total as ratio from wmspecials)
 order by good desc,total desc,edits desc;
FNORD;

$fnord = $wdb->prepare($query);
$fnord -> execute();

$count=1;
$cr = "\n";

if (isset($_GET['semicolon'])) {
    $delim=";";
} else {
    $delim=",";
}

echo "rank${delim}prefix${delim}type${delim}language${delim}loclang${delim}good${delim}total${delim}edits${delim}admins${delim}users${delim}activeusers${delim}images${delim}stubratio${delim}timestamp${delim} $cr";

while ($row = $fnord->fetch()) {
    echo "$count${delim}".$row['prefix']."${delim}".$row['type']."${delim}".$row['lang']."${delim}".$row['loclang']."${delim}".$row['good']."${delim}".$row['total']."${delim}".$row['edits']."${delim}".$row['admins']."${delim}".$row['users']."${delim}".$row['activeusers']."${delim}".$row['images']."${delim}".$row['ratio']."${delim}".$row['ts']."$cr";
    $count++;
}

# close db connection
$wdb = null;
?>
