<?php
# allowable values for s= (order by)
if (isset($_GET['s'])) {

	$sort=mysql_escape_string($_GET['s']);

	switch ($sort) {
	case "name_asc":
	case "name_desc":
	case "good_asc":
	case "good_desc":
	case "total_asc":
	case "total_desc":
	case "edits_asc":
	case "edits_desc":
	case "views_asc":
	case "views_desc":
	case "admins_asc":
	case "admins_desc":
	case "users_asc":
	case "users_desc":
	case "ausers_asc":
	case "ausers_desc":
	case "ts_asc":
	case "ts_desc":
	case "ratio_asc":
	case "ratio_desc":
	case "images_asc":
	case "images_desc":
	case "prefix_asc":
	case "prefix_desc":
	case "lang_asc":
	case "lang_desc":
	case "loclang_asc":
	case "loclang_desc":
	case "id_asc":
	case "id_desc":
	case "http_asc":
	case "http_desc":
	case "title_asc":
	case "title_desc":
	case "numwikis_asc":
	case "numwikis_desc":
		$msort=str_replace("_"," ",$sort);
	break;
	case "domain_asc":
		$msort = "tld asc";
	break;
	case "domain_desc":
		$msort = "tld desc";
	break;
	case "method_asc":
		$msort = "method asc,http asc";
	break;
	case "method_desc":
		$msort = "method desc,http asc";
	break;
	case "rights_asc":
		$msort = "si_rights asc";
	break;
	case "rights_desc":
		$msort = "si_rights desc";
	break;
	case "version_asc":
		$msort = "si_generator desc,substring(version,3,2) asc";
	break;
	case "version_desc":
		$msort = "si_generator desc,substring(version,3,2) desc";
	break;
	default:
		$msort = "good desc,total desc";
	}
} else {
	$sort = "good_desc";
	$msort = "good desc,total desc";
}
?>
