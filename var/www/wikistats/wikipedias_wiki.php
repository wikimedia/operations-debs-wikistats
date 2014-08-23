<?php
# Wikistats by mutante - 2006-02 - S23 Wiki
#
require_once("/etc/wikistats/config.php");

mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());
mysql_select_db("$dbname") or die(mysql_error());

$query = "select *,good/total as ratio from wikipedias order by good desc,total desc,edits desc";

$result = mysql_query("$query") or die(mysql_error());
?>

<pre>
<?php
$count=1;
$gtotal=0;
$ggood=0;
$gedits=0;
$gadmins=0;
$gusers=0;
$gimages=0;

while($row = mysql_fetch_array( $result )) {
    if ($row['prefix']!="") {
        $gtotal=$gtotal+$row['total'];
        $ggood=$ggood+$row['good'];
        $gedits=$gedits+$row['edits'];
        $gadmins=$gadmins+$row['admins'];
        $gusers=$gusers+$row['users'];
        $gimages=$gimages+$row['images'];
        $edits=$row['edits'];
        $good=$row['good'];
        $total=$row['total'];
        $nonarticles=$total-$good;
        $ratio=$row['ratio'];

        if ($good==0) {
            $depth="-";
        } else {
            # $depth=($edits/$good*$nonarticles/$good)/(1-$ratio);
            $depth=$edits/$good*$nonarticles/$good*(1-$ratio);
            $depth=round($depth);
            # $depth=number_format($depth, 4);
        }

        if ($depth > 500 && $good < 100000) { $depth="--"; }

            # number format change
            $good=number_format($row['good'],0,'.',',');
            $total=number_format($row['total'],0,'.',',');;
            $edits=number_format($row['edits'],0,'.',',');
            $admins=number_format($row['admins'],0,'.',',');
            $users=number_format($row['users'],0,'.',',');
            $ausers=number_format($row['activeusers'],0,'.',',');
            $images=number_format($row['images'],0,'.',',');

?>
|-
| <?php echo $count; ?>

| <?php echo "[[w:".$row['lang']." language|".$row['lang']."]]"; ?>
| class="plainlinksneverexpand" | <?php echo "[{{fullurl:".$row['prefix'].":".$row['loclanglink']."}} ".$row['loclang']."]"; ?>

| <?php echo "[[:".$row['prefix'].":|".$row['prefix']."]]"; ?>

| class="plainlinksneverexpand" | <?php echo "[{{fullurl:".$row['prefix'].":Special:Statistics|action=raw}} '''".$good; ?>'''</span>]

| <?php echo $total; ?>

| <?php echo "[[:".$row['prefix'].":Special:Statistics|".$edits; ?>]]
| <?php echo "[[:".$row['prefix'].":Special:Listadmins|".$admins; ?>]]
| <?php echo "[[:".$row['prefix'].":Special:Listusers|".$users; ?>]]
| <?php echo "[[:".$row['prefix'].":Special:ActiveUsers|".$ausers; ?>]]
| <?php echo "[[:".$row['prefix'].":Special:Imagelist|".$images; ?>]]
| <?php echo $depth; ?>

<?php
} else {
if ($count>1) {
echo "|} \n";
}
?>
=== <?php echo $row['lang']; ?> ===
{| border="1" cellpadding="2" cellspacing="0" style="width:100%; background: #f9f9f9; border: 1px solid #aaaaaa; border-collapse: collapse; white-space: nowrap; text-align: right" class="sortable"
|-
! &#8470;
! Language
! Language (local)
! Wiki
! Articles
! Total
! Edits
! Admins
! Users
! Active Users
! Images
! Depth
<?php
}
if ($row['prefix']!="") {
$count++;
}
}
mysql_close();
echo "|}\n\n";
include ("grandtotal_wiki.php");
?>
</pre>
