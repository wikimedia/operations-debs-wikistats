<?php

$query="(select 'wp' as project,'wikipedias' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikipedias where prefix is not NULL) 
union all
(select 'wt' as project,'wiktionaries' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wiktionaries) 
union all
(select 'wq' as project,'wikiquotes' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikiquotes) 
union all
(select 'wb' as project,'wikibooks' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikibooks) 
union all
(select 'wn' as project,'wikinews' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikinews) 
union all
(select 'ws' as project,'wikisources' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikisources)
union all
(select 'wy' as project,'wikivoyage' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikivoyage)
union all
(select 'wx' as project,'wmspecials' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwkis from wmspecials)
union all
(select 'wi' as project,'wikia' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, max(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikia) 
union all
(select 'et' as project,'editthis' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins)-count(id) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from editthis) 
union all
(select 'wr' as project,'wikitravel' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikitravel) 
union all
(select 'mw' as project,'mediawikis' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from mediawikis where statsurl not like '%opensuse%') 
union all
(select 'mt' as project,'metapedias' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from metapedias)
union all
(select 'sc' as project,'scoutwiki' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from scoutwiki)
union all
(select 'os' as project,'opensuse' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from opensuse) 
union all
(select 'un' as project,'uncyclomedia' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, max(users) as gusers,sum(images) as gimages, count(id) as numwikis from uncyclomedia) 
union all
(select 'wf' as project,'wikifur' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, max(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikifur)
union all
(select 'an' as project,'anarchopedias' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from anarchopedias) 
union all
(select 'si' as project,'wikisite' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikisite) 
union all
(select 'ne' as project,'neoseeker' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from neoseeker) 
union all
(select 'wv' as project,'wikiversity' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from wikiversity)
union all
(select 're' as project,'referata' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from referata)
union all
(select 'pa' as project,'pardus' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from pardus)
union all
(select 'ro' as project,'rodovid' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from rodovid)
union all
(select 'lx' as project,'lxde' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from lxde)
union all
(select 'sw' as project,'shoutwiki' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from shoutwiki)
union all
(select 'w3' as project,'w3cwikis' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from w3cwikis)
union all
(select 'ga' as project,'gamepedias' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from gamepedias)
union all
(select 'sf' as project,'sourceforge' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from sourceforge)
union all
(select 'or' as project,'orain' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from orain)
union all
(select 'mh' as project,'miraheze' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers,sum(images) as gimages, count(id) as numwikis from miraheze)
order by ${sort};";

?>
