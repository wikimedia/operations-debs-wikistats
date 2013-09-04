<?php
/*
-----------------------------------------------------------------------------------------------
-- wikistats.wmflabs.org - mediawiki statistics                                              --
--                                                                                           --
-- based on "wikistats by s23.org" (http://www.s23.org/wiki/Wikistats)                       --
-- Copyright 2005-2011 - Daniel Zahn, Sven Grewe, Mattis Manzel, et.al.                      --
--                                                                                           --
-- which was released under Attribution-NonCommercial-ShareAlike 2.5 and inspired by:        --
-- - "BiggestWiki" on Meatball wiki (meatballwiki.org/ usemod.com) by Robert Werner Hanke    --
-- - "one big soup" / wiki-net lightning talks at 21C3 congress (2004) by Mattis Manzel      --
-- thanks for: endless task managing: R.W. Hanke  years of hosting: the s23.org community    --
--                                                                                           --
-- This rewrite is now Copyright 2012 - Wikimedia Foundation, Inc. (<dzahn@wikimedia.org>)   --
-- and released under GNU General Public License with the consent of the original authors.   --
--                                                                                           --
-- This program is free software: you can redistribute it and/or modify it under the terms   --
-- of the GNU General Public License as published by the Free Software Foundation,           --
-- either version 3 of the License, or (at your option) any later version.                   --
--                                                                                           --
-- This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; --
-- without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. --
-- See the GNU General Public License for more details.                                      --
--                                                                                           --
-- You should have received a copy of the GNU General Public License                         --
-- along with this program.  If not, see <http://www.gnu.org/licenses/>.                     --
-----------------------------------------------------------------------------------------------
*/

# require_once("get_methods.php");

# background color of the version column

function version_color($version) {
	global $goodversions;
	global $devversions;

	if (in_array($version, $goodversions)) {
		$color="version-stable";
	} elseif (in_array($version, $devversions)) {
		$color="version-edge";
	} elseif ($version=="n/a or error") {
		$color="version-warn";
	} else {
		$color="version-crit";
	}

	return $color;

}

# fetch extended siteinfo from Mediawiki API
function siteinfo($url) {
	global $user_agent;
	global $api_query_info;

	ini_set('user_agent','${user_agent}');

	$siteinfo_url=explode("api.php",$url);
	$siteinfo_url=$siteinfo_url[0]."api.php".$api_query_info;

	#DEBUG# echo "Fetching siteinfo from $siteinfo_url\n";

	$buffer=file_get_contents("$siteinfo_url");

	if (isset($http_response_header[0])) {

		$statuscode=explode(" ",$http_response_header[0]);
		if (isset($statuscode[1])) {

			$statuscode=$statuscode[1];
			$wikidata=unserialize($buffer);

			if (isset($wikidata['query']['general'])) {
				$siteinfo=$wikidata['query']['general'];
			} else {
				$siteinfo="error";
				$statuscode="894";
			}

		} else {
			$siteinfo="error";
			$statuscode="893";
		}

	} else {
		$siteinfo="error";
		$statuscode="892";
	}

	$siresult=array();
	$siresult['statuscode']=$statuscode;
	$siresult['siteinfo']=$siteinfo;

return $siresult;
}

# fetch stats data from API in PHP serialized format
function method9($url) {
	global $user_agent;
	global $api_query_stat;

	ini_set('user_agent','${user_agent}');
	$sitestats_url=explode("api.php",$url);
	$sitestats_url=$sitestats_url[0]."api.php".$api_query_stat;
	$buffer=file_get_contents("$sitestats_url");

	if (isset($http_response_header[0])) {
		$statuscode=explode(" ",$http_response_header[0]);
		if (isset($statuscode[1])) {
			$statuscode=$statuscode[1];
		} else {
			$statuscode="993";
		}
	} else {
		$statuscode="992";
	}

	if ($statuscode=="200") {

		$wikidata=unserialize(trim($buffer));

		if (isset($wikidata['query']['statistics'])) {
			$result=$wikidata['query']['statistics'];

			# echo gettype($result['pages']), "\n";
			# already integer | convert into array of integers (from comment on PHP manual page for function settype)
			# $result=array_map(create_function('$value', 'return (int)$value;'),$result);

			if (is_numeric($result['pages'])) {
				# activeusers may not exist on older wikis
				if (!isset($result['activeusers']) OR !is_numeric($result['activeusers'])) {
					print "--> NOTICE - no active users column - setting to 0\n";
					$result['activeusers']=0;
				}

				$result['statuscode']=$statuscode;
				$result['returncode']=0;
			} else {
				$result=array("returncode" => 2, "statuscode" => 997);
			}
		} else {
			echo "\\n 991 error ! - sitestats_URL: $sitestats_url - buffer is '$buffer' - wikidata array is: \n";
			print_r($wikidata);
			$result=array("returncode" => 3, "statuscode" => 991);
		}
	} else {
		$result=array("returncode" => 1, "statuscode" => $statuscode);
	}

return $result;
}

# method8 (API) stats parsing

function method8($statsurl) {
	global $user_agent;
	ini_set('user_agent','${user_agent}');

	#DEBUG# print "\nAPI call: ${statsurl} \n";

	$buffer = file_get_contents($statsurl);

	if (isset($http_response_header[0])) {
		$statuscode=explode(" ",$http_response_header[0]);
		if (isset($statuscode[1])) {
			$statuscode=$statuscode[1];
		} else {
			$statuscode="993";
		}
	} else {
		$statuscode="992";
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
	global $dbhost,$dbuser,$dbpass,$dbname,$valid_api_tables;

	if (in_array($table,$valid_api_tables)) {

		mysql_connect("$dbhost", "$dbuser", "$dbpass") or die(mysql_error());
		mysql_select_db("$dbname") or die(mysql_error());
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
	global $dbuser,$dbpass,$dbname,$valid_api_tables;
	$table=strip_tags(trim(mysql_escape_string($table)));

	if (in_array($table,$valid_api_tables)) {
		header("Content-Type: text/xml; charset=UTF-8");
		$command="mysql -X -u".$dbuser." -p".$dbpass." -e 'select * from $table where users is not NULL order by good desc,total desc' $dbname";
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

function get_name_from_api($url) {
	global $user_agent;
	global $api_query_info;

	ini_set('user_agent','${user_agent}');

	$api_url=explode("api.php",$url);
	$api_url=$api_url[0]."api.php".$api_query_info;

	$buffer=file_get_contents($api_url);
	$siteinfo=unserialize($buffer);
	$sitename=$siteinfo['query']['general']['sitename'];

	return $sitename;
}

function detailtable($row_array) {

global $table_width;

arsort($row_array);
$offset=0;
$output="<table class=\"detail\"><tr>\n";

$colcount=0;
$rowcount=0;

foreach ($row_array as $myrow_array) {

	$myrow=array_slice($row_array, $offset, $table_width);

	foreach ($myrow as $myhkey => &$myhvalue) {
		$output.="<th class=\"sub\">${myhkey}</th>\n";
		$colcount++;
	}

	if ($colcount == $table_width OR $rowcount==0) {
		$output.="</tr><tr>\n";
		$colcount=0;
		$rowcount++;
	}

	foreach ($myrow as $mydkey => &$mydvalue) {
		if (!isset($mydvalue)) {
			$mydvalue="n/a";
		}
		$output.="<td class=\"detail\">${mydvalue}</td>\n";
		$colcount++;
	}

	if ($colcount == $table_width OR $rowcount==0) {
		$output.="</tr><tr>\n";
		$colcount=0;
		$rowcount++;
	}

	$offset=$offset+$table_width;

	}

$output.="</tr></table>\n";

return $output;
}

# add nice format for ranking (from http://phpsnips.com/snip-37)

function ordinal($cdnl){
	$test_c = abs($cdnl) % 10;
	$ext = ((abs($cdnl) %100 < 21 && abs($cdnl) %100 > 4) ? 'th'
	: (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1)
	? 'th' : 'st' : 'nd' : 'rd' : 'th'));
	return $cdnl.$ext;
}


function grandtotal($ggood, $gtotal, $gedits, $gadmins, $gusers, $gimages){

	$ggood=number_format($ggood, 0, ',', ' ');
	$gtotal=number_format($gtotal, 0, ',', ' ');
	$gedits=number_format($gedits, 0, ',', ' ');
	$gadmins=number_format($gadmins, 0, ',', ' ');
	$gusers=number_format($gusers, 0, ',', ' ');
	$gimages=number_format($gimages, 0, ',', ' ');

$output = <<< GRANDTOTAL
<br />
<table>
<tr><th colspan="6" class="grand">Grand Total (of current display)</th></tr>
<tr>
<th class="grand">Articles</th>
<th class="grand">Total</th>
<th class="grand">Edits</th>
<th class="grand">Admins</th>
<th class="grand">Users</th>
<th class="grand">Images</th>
</tr>
<tr>
<td class="grand"> ${ggood} </td>
<td class="grand"> ${gtotal} </td>
<td class="grand"> ${gedits} </td>
<td class="grand"> ${gadmins} </td>
<td class="grand"> ${gusers} </td>
<td class="grand"> ${gimages} </td>
</tr>
</table>
GRANDTOTAL;

	return $output;
}

# url_get_contents function by Andy Langton: http://andylangton.co.uk/
function url_get_contents($url,$useragent='cURL',$headers=false,
	$follow_redirects=false,$debug=false) {

	# initialise the CURL library
	$ch = curl_init();

	# specify the URL to be retrieved
	curl_setopt($ch, CURLOPT_URL,$url);

	# we want to get the contents of the URL and store it in a variable
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

	# specify the useragent: this is a required courtesy to site owners
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

	# ignore SSL errors
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	# return headers as requested
	if ($headers==true){
		curl_setopt($ch, CURLOPT_HEADER,1);
	}

	# only return headers
	if ($headers=='headers only') {
		curl_setopt($ch, CURLOPT_NOBODY ,1);
	}

	# follow redirects - note this is disabled by default in most PHP installs from 4.4.4 up
	if ($follow_redirects==true) {
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	}

	# if debugging, return an array with CURL's debug info and the URL contents
	if ($debug==true) {
		$result['contents']=curl_exec($ch);
		$result['info']=curl_getinfo($ch);
	}

	# otherwise just return the contents as a variable
	else $result=curl_exec($ch);

	# free resources
	curl_close($ch);
 
	# send back the data
	return $result;
}
?>
