<?php
# Wikistats by mutante - 2006-02-08 - S23 Wiki - http://s23.org
#

require_once("/etc/wikistats/config.php");

# enable CORS (T193094)
header("Access-Control-Allow-Origin: *");

# db connect
try {
    $wdb = new PDO("mysql:host=${dbhost};dbname=${dbname}", $dbuser, $dbpass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br />";
    die();
}

$default_fields="prefix,good,lang,loclang,total,edits,admins,users,activeusers,images,ts";

$query = <<<FNORD
(SELECT ${default_fields},'wikipedia' AS type FROM wikipedias WHERE prefix IS NOT null)
 UNION ALL (SELECT ${default_fields},'wikisource' AS type FROM wikisources)
 UNION ALL (SELECT ${default_fields},'wiktionary' AS type FROM wiktionaries)
 UNION ALL (SELECT ${default_fields},'wikiquote' AS type FROM wikiquotes)
 UNION ALL (SELECT ${default_fields},'wikibooks' AS type FROM wikibooks)
 UNION ALL (SELECT ${default_fields},'wikinews' AS type FROM wikinews)
 UNION ALL (SELECT ${default_fields},'wikiversity' AS type FROM wikiversity)
 UNION ALL (SELECT url,good,lang,loclang,total,edits,admins,users,activeusers,images,ts,'special' AS type FROM wmspecials)
 ORDER BY good desc,total desc;
FNORD;

$fnord = $wdb->prepare($query);
$fnord -> execute();
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
! Active Users
! Files
! Updated
<?php
$count=1;
$gtotal=0;
$ggood=0;
$gedits=0;
$gadmins=0;
$gusers=0;
$gausers=0;
$gimages=0;


while ($row = $fnord->fetch()) {

    $gtotal=$gtotal+$row['total'];
    $ggood=$ggood+$row['good'];
    $gedits=$gedits+$row['edits'];
    $gadmins=$gadmins+$row['admins'];
    $gusers=$gusers+$row['users'];
    $gausers=$gausers+$row['activeusers'];
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
| style="font-size: 70%;" | <?php echo "[//".$row['prefix']."/wiki/Special:ActiveUsers ".$row['activeusers']; ?>]
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
| style="font-size: 70%;" | <?php echo "[//".$row['prefix'].".".$row['type'].".org/wiki/Special:ActiveUsers ".$row['activeusers']; ?>]
| style="font-size: 70%;" | <?php echo "[//".$row['prefix'].".".$row['type'].".org/wiki/Special:FileList ".$row['images']; ?>]
| style="font-size: 70%;" | <?php echo $row['ts']; ?>

<?php
    }
    $count++;
}

# close db connection
$wdb = null;

echo "|}\n\n";
include ("$IP/grandtotal_wiki.php");
?>
</pre>
