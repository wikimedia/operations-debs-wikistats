<?php
# maintenance functions for wikistats admins

# connect to the mysql database
function dbConnect(){
    include "/etc/wikistats/config.php";
    # db connect
    try {
        $wdb = new PDO("mysql:host=${dbhost};dbname=${dbname}", $dbuser, $dbpass);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br />";
        die();
    }
    #print "wikistats updater \n connected to mysql at $dbhost as $dbuser on $dbname. \n";
}

# run a query and log it
function dbResult($query){
    $fnord = $wdb->prepare($query);
    $fnord -> execute();
    $time = @date('[Y-m-d H:i:s]');
    $processUser = posix_getpwuid(posix_geteuid());
    error_log("${time} - user '".$processUser['name']."' ran query: '${query}' \n", 3, "/var/log/wikistats/wsa.log");
    # printf("affected rows: %d\n", mysql_affected_rows());
    # replace with PDO?
}

# get the update method of a wiki
function getMethod($id) {
    $query="SELECT method FROM mediawikis WHERE id='${id}';";

    $fnord = $wdb->prepare($query);
    $fnord -> execute();
    while ($row = $fnord->fetch()) {
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
    $table=$hive;
    echo "adding '$url' to '$table'\n\n";
    dbresult("INSERT INTO ${table} (statsurl) values ('${url}');");
}

# delete a wiki from the table
function deleteWiki($id) {
    dbresult("DELETE FROM mediawikis WHERE id='${id}';");
}

# get the latest wiki id
function getLatestWiki($table) {
    $query="SELECT id FROM ${table} order by id desc limit 1;";
    $fnord = $wdb->prepare($query);
    $fnord -> execute();
    while ($row = $fnord->fetch()) {
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
# close db connection
$wdb = null;
?>
