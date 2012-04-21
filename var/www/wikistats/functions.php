<?php
# functions for Wikistats

# require_once("get_methods.php");

# background color of the version column

function version_color($version) {
	global $goodversions;
	global $devversions;

	if (in_array($version, $goodversions)) {
		$color="Green";
	} elseif (in_array($version, $devversions)) {
		$color="Blue";
	} elseif ($version=="n/a or error") {
		$color="Gray";
	} else {
		$color="Red";
	}
return $color;

}

# fetch extended siteinfo from Mediawiki API
# api.php?action=query&meta=siteinfo&format=xmlfm

function siteinfo($url) {
	ini_set('user_agent','https://wikistats.wmflabs.org');

	$siteinfo_url=explode("api.php",$url);
	$siteinfo_url=$siteinfo_url[0]."api.php?action=query&meta=siteinfo&format=xml";

	echo "Fetching siteinfo from $siteinfo_url\n";

	$buffer=file_get_contents($siteinfo_url);
	# print $buffer;

	$si_variables=array("mainpage","base","sitename","generator","phpversion","phpsapi","dbtype","dbversion","rev","case","rights","lang","fallback8bitEncoding","writeapi","timezone","timeoffset","articlepath","scriptpath","script","variantarticlepath","server","wikiid","time");

	foreach ($si_variables as &$si_variable) {

		$siteinfo[$si_variable]=explode("$si_variable=\"",$buffer);
		$siteinfo[$si_variable]=explode("\"",$siteinfo[$si_variable][1]);
		$siteinfo[$si_variable]=strip_tags($siteinfo[$si_variable][0]);
	}

return $siteinfo;
}

# method8 (API) stats parsing

function method8($statsurl) {
	# or set user_agent to wikistats.wmflabs.org
	ini_set('user_agent','Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.2) Gecko/20070219 Firefox/2.0.0.2');

	#DEBUG# print "\nAPI call: ${statsurl} \n";

	$buffer = file_get_contents($statsurl);

	if (isset($http_response_header[0])) {
		$statuscode=explode(" ",$http_response_header[0]);
	} else {
		$statuscode="992";
	}

	if (isset($statuscode[1])) { 
		$statuscode=$statuscode[1]; 
	} else {
		$statuscode="993";
	}

	#DEBUG# print "\nhttp status: ${statuscode} \n";

	if ($statuscode=="200") {

		# parse it using explosives
		$pages=explode("pages=&quot;",$buffer);
		if (isset($pages[1])) { $pages=explode("&quot;",$pages[1]); }	
		$articles=explode("articles=&quot;",$buffer);
		if (isset($articles[1])) { $articles=explode("&quot;",$articles[1]); }
		$edits=explode("edits=&quot;",$buffer);
		if (isset($edits[1])) { $edits=explode("&quot;",$edits[1]); }
		$images=explode("images=&quot;",$buffer);
		if (isset($images[1])) { $images=explode("&quot;",$images[1]); }
		$users=explode("users=&quot;",$buffer);
		if (isset($users[1])) { $users=explode("&quot;",$users[1]); }
		$activeusers=explode("activeusers=&quot;",$buffer);
		if (isset($activeusers[1])) { $activeusers=explode("&quot;",$activeusers[1]); }
		# activeusers may not exist on older wikis	
		if (!is_numeric($activeusers[0])) {
		print "--> NOTICE - no active users column - setting to 0\n";
		$activeusers[0]=0;
		}
		$admins=explode("admins=&quot;",$buffer);
		if (isset($admins[1])) { $admins=explode("&quot;",$admins[1]); }
 
		if (is_numeric($pages[0])) {
			$result=array("returncode" => 0, "statuscode" => $statuscode, "pages" => $pages[0], "articles" => $articles[0], "edits" => $edits[0], "images" => $images[0], "users" => $users[0], "activeusers" => $activeusers[0], "admins" => $admins[0]);
		} else {
			$result=array("returncode" => 2, "statuscode" => 997);
		}

	} else {
		$result=array("returncode" => 1, "statuscode" => $statuscode);
	}

return $result;
}

# dump csv / ssv data

function data_dumper($table,$format) {
	global $dbhost,$dbname,$dbpass,$dbdatabase,$valid_api_tables;

	if (in_array($table,$valid_api_tables)) {

		mysql_connect("$dbhost", "$dbname", "$dbpass") or die(mysql_error());
		mysql_select_db("$dbdatabase") or die(mysql_error());
		$count=1;
		$cr = "\n";

		switch($format) {
			case "csv":
			$delimiter=",";
		break;	
			case "ssv":
			$delimiter=";";
		break;
			default:
			$delimiter=",";
		}

		switch($table) {
			case "wikipedias":
				$my_query = "select *,good/total as ratio from ".mysql_real_escape_string($table)." where lang not like \"%articles%\" order by good desc,total desc";
			break;
			default:
			$my_query = "select *,good/total as ratio from ".mysql_real_escape_string($table)." order by good desc,total desc";
		}

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$table.$format");
		header("Pragma: no-cache");
		header("Expires: 0");

		# modified from an example on http://php.net/manual/en/function.mysql-fetch-field.php (mewsterus at yahoo dot com  07-Jul-2009 06:18)

		$result = mysql_query("SELECT * FROM $table LIMIT 1");
		$describe = mysql_query("SHOW COLUMNS FROM $table");
		$num = mysql_num_fields($result);
		$output = array();
		for ($i = 0; $i < $num; ++$i) {
			$field = mysql_fetch_field($result, $i);
			// Analyze 'extra' field
			$field->auto_increment = (strpos(mysql_result($describe, $i, 'Extra'), 'auto_increment') === FALSE ? 0 : 1);
			// Create the column_definition
			$field->definition = mysql_result($describe, $i, 'Type');
			if ($field->not_null && !$field->primary_key) $field->definition .= ' NOT NULL';
			if ($field->def) $field->definition .= " DEFAULT '" . mysql_real_escape_string($field->def) . "'";
			if ($field->auto_increment) $field->definition .= ' AUTO_INCREMENT';
			if ($key = mysql_result($describe, $i, 'Key')) {
			if ($field->primary_key) $field->definition .= ' PRIMARY KEY';
			else $field->definition .= ' UNIQUE KEY';
		}
		// Create the field length
		$field->len = mysql_field_len($result, $i);
		// Store the field into the output
		# $output[$field->name] = $field;
		# we just want the column names (mutante)
		$columns.=$field->name."$delimiter";
		}
		$columns=substr($columns,0,-1);
		# /from

		$output=$columns."\n";
		$columns=explode($delimiter,$columns);

		$my_result = mysql_query("$my_query") or die(mysql_error());

		while($row = mysql_fetch_array( $my_result )) {

			foreach ($columns as &$column) {
				$myrow=mb_convert_encoding($row[$column], "UTF-8", "HTML-ENTITIES");
				$output.=$myrow.$delimiter;
			}
		$count++;
		$output.="\n";
		}

	mysql_close();

} else {

$output="unknown or invalid table.";
}

	return $output;
}

# dump XML data, the lazy way

function xml_dumper($table) {
	global $dbname,$dbpass,$valid_api_tables;
	$table=strip_tags(trim(mysql_escape_string($table)));

	if (in_array($table,$valid_api_tables)) {
		header("Content-Type: text/xml; charset=UTF-8");
		$command="mysql -X -u".$dbname." -p".$dbpass." -e 'select * from $table where users is not NULL order by good desc,total desc' wikidb";
		$output=shell_exec("$command");
		# $output=str_replace("&amp;","&",$output);
		return $output;
	} else {
		$output="error. Unknown or invalid table.";
	}

return $output;
}


# maintenance functions
# find and add new wikis

# extract a Mediawiki statsurl from a WikiIndex page
function statsurl_from_wikiindex($page_title) {

}

?>
