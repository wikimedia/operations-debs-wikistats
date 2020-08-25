<?php
#$wikioutput=$listtable."_wiki.php";
$wikioutput="";
$wikipage="";
$selfurl=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; $selfurl=str_replace("&","&amp;",$selfurl);
?>
<ul><li><a class="foot" href="<?php echo "$wikioutput"; ?>">Table in Mediawiki Syntax</a></li>
<li>In use on: <a class="foot" href="<?php echo "$wikipage"; ?>"><?php echo "$wikipage"; ?></a></li>
<li><a class="foot" href="index.php">Back to Index</a></li></ul>
<a class="foot" href="http://validator.w3.org/check?uri=<?php echo "http://".$selfurl; ?>">
validate html</a>
<br />
<a class="foot" href="https://gerrit.wikimedia.org/r/admin/repos/operations/puppet">source code (puppet)</a> (sets up a wikistats instance, see role::wikistats::instance, profile::wikistats, modules/wikistats)<br />
<a class="foot" href="https://gerrit.wikimedia.org/r/admin/repos/operations/debs/wikistats">source (PHP)</a> (application code, not really a .deb anymore)<br />
<?php echo "Last modified: " . date( "F d Y - H:i:s", getlastmod() ); ?>
