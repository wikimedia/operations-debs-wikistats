<?php
header("Content-Type: text/css; charset=UTF-8");

$color['back']="ffffff";
$color['table']="eeeeee";
$color['text']="000000";
$color['linkbg']="eeeeee";
$color['linktext']="000000";
$color['linkact']="0000ff";
$color['linkactbg']="eeeeee";
$color['linkvisit']="008000";
$color['linkvisitbg']="eeeeee";
$color['linkhover']="00cccc";
$color['linkhoverbg']="222222";
$color['tborder']="000000";
$font="Arial";
$fontsizet="80";
$fontsizem="120";

echo "
body {
	color: #".$color['text'].";
	background: #".$color['back'].";
	font-family: $font;
	font-variant: normal;
	font-size: ".$fontsizet."%;
}

a:link {color: #".$color['linktext']."; background: #".$color['linkbg']."; text-decoration: underline; }
a:active {color: #".$color['linkact']."; background: #".$color['linkactbg']."; text-decoration: underline; }
a:visited {color: #".$color['linkvisit']."; background: #".$color['linkvisitbg']."; text-decoration: underline; }
a:hover {color: #".$color['linkhover']."; background: #".$color['linkhoverbg']."; text-decoration: underline; }

p.nextpage {
	text-align: right;
}
table {
	table-layout: fixed;
	color: #".$color['text'].";
	background: #".$color['table'].";
	border: solid 1px #".$color['tborder'].";
	border-collapse: collapse;
}

.main {
	font-size: ".$fontsizem."%;
}

th {
	font-family: arial, futura, helvetica, serif;
	font-variant: normal;
}

th.head {
	font-size: 150%;
	text-align: center;
	border: none;
}

th.sub {
	font-size: 100%;
	text-align: center;
	border: solid 1px black;
	white-space: nowrap;
}

th.grand {
	font-size: 100%;
	text-align: center;
	border: solid 1px black;
	font-family: arial, futura, helvetica, serif;
	font-variant: normal;
	font-weight: bold;
	padding: 1px 1px 1px 1px;
}

td.foo {
	border: solid 1px white;
	white-space: nowrap;
}


td.grand {
	font-size: 100%;
	text-align: right;
	border: solid 1px black;
	font-family: arial, futura, helvetica, serif;
	font-variant: normal;
	font-weight: bold;
	padding: 1px 1px 1px 1px;
}

td.text {
	font-family: arial, futura, helvetica, serif;
	font-variant: normal;
	font-size: 100%;
	text-align: right;
	padding: 1px 1px 1px 1px;
	white-space: nowrap;
}

td.milestone {
	font-family: arial, futura, helvetica, serif;
	font-variant: normal;
	font-weight: bold;
	font-size: 100%;
	text-align: center;
	padding: 1px 1px 1px 1px;
	white-space: nowrap;
}

td.number {
	font-family: arial, futura, helvetica, serif;
	font-variant: normal;
	font-size: 100%;
	text-align: right;
	padding: 1px 1px 1px 1px;
	white-space: nowrap;
}

td.timestamp {
	font-family: arial, futura, helvetica, serif;
	font-variant: normal;
	font-size: 80%;
	text-align: left;
	padding: 2px 2px 2px 2px;
	white-space: nowrap;
}

td.timestamp-ok {
	background: #aaeeaa;
}

td.timestamp-warn {
	background: #dd6666;
}

td.timestamp-crit {
	background: #aa3333;
}

td.version {
	font-family: arial, futura, helvetica, serif;
	font-variant: normal;
	font-size: 80%;
	text-align: left;
	padding: 2px 2px 2px 2px;
	white-space: nowrap;
}

td.version-edge {
	background: #aaeeaa;
}

td.version-stable {
	background: #ff6666;
}

td.version-warn {
	background: #ff6666;
}

td.version-crit {
	background: #dd6666;
}

td.detail {
	font-family: arial, futura, helvetica, serif;
	font-variant: normal;
	font-size: 90%;
	text-align: center;
	padding: 1px 1px 1px 1px;
	white-space: nowrap;
	background: white;
}

td.blank {
	border: none;
	padding: 1px 1px 1px 1px;
	font-family: arial, futura, helvetica, serif;
	font-size: 100%;
}

li { 
	padding: 6px 0px 6px 6px;
	list-style: disc outside;
}

p.footer {
	font-family: arial, futura, helvetica, serif;
	font-size: 100%;
}

ul.foot {
	font-family: arial, futura, helvetica, serif;
	font-size: 100%;
}

h2.dt-header {
	font-family: arial, futura, helvetica, serif;
	font-size: 160%;
}

p.ranking {
	font-size: 110%;
	font-style: italic;
}

span.bold {
	font-weight: bold;
}

div.mainleft {
	float:left;
	width:90%;
}

";
?>
