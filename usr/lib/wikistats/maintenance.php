<?php
# maintenance functions for wikistats admins

# connect to the mysql database
function dbConnect(){
	include "/etc/wikistats/config.php";
	mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());
	mysql_select_db("$dbname") or die(mysql_error());
	#print "wikistats updater \n connected to mysql at $dbhost as $dbuser on $dbname. \n";
}

# run a query,log it and print the number of affected rows
function dbResult($query){
	$result = mysql_query("$query") or die(mysql_error()); echo "\n\n";
	$time = @date('[Y-m-d H:i:s]');
	$processUser = posix_getpwuid(posix_geteuid());
	error_log("${time} - user '".$processUser['name']."' ran query: '${query}' \n", 3, "/var/log/wikistats/wsa.log");
	printf("affected rows: %d\n", mysql_affected_rows());
}

# get the update method of a wiki
function getMethod($id) {
	$query="SELECT method FROM mediawikis WHERE id='${id}';";
	$result = mysql_query("$query") or die(mysql_error());
	while($row = mysql_fetch_array( $result )) {
		$method=$row['method'];
	}
	return $method;
}

# set the update method used by a wiki
# id - id of the wiki in mediawikis table
# method - number of method used
# TODO: document methods
function setMethod($id,$method) {
	dbresult("UPDATE mediawikis SET method='${method}' WHERE id='${id}';");
}


# change the stats URL of a wiki
# id - id of the wiki in mediawikis table
# url - stats URL (ends in api.php or action=raw)
function setStatsUrl($id,$url) {
	dbresult("UPDATE mediawikis SET statsurl='${url}' WHERE id='${id}';");

}

# add a wiki to a table
function addWiki($hive, $url) {
	$table=mysql_escape_string($hive);
	echo "adding '$url' to '$table'\n\n";
	echo "dbresult(\"INSERT INTO ${table} (statsurl) values ('${url}');\");";
}

# delete a wiki from the table
function deleteWiki($id) {
	dbresult("DELETE FROM mediawikis WHERE id='${id}';");
}

# get the latest wiki id
function getLatestWiki($table) {
	$query="SELECT id FROM ${table} order by id desc limit 1;";
	$result = mysql_query("$query") or die(mysql_error());
	while($row = mysql_fetch_array( $result )) {
		$wikiid=$row['id'];
	}
	return $wikiid;
}

# main / examples
dbconnect();
#
#
#print "the method used for 6720 is ".getMethod('6720')."\n";
#print "setting method to 0\n";
#setMethod('6720','0');
#print "the method used for 6720 is ".getMethod('6720')."\n";
#print "setting method to 8\n";
#setMethod('6720','8');
#print "the method used for 6720 is ".getMethod('6720')."\n";

#deleteWiki('10528');

#
#mysql_close();
?>
