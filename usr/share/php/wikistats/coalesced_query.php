<?php

$default_fields="sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers, sum(activeusers) as gausers, sum(images) as gimages, count(id) as numwikis";

$query="(select 'wp' as project,'wikipedias' as name,${default_fields} from wikipedias where prefix is not NULL) 
union all
(select 'wt' as project,'wiktionaries' as name,${default_fields} from wiktionaries) 
union all
(select 'wq' as project,'wikiquotes' as name,${default_fields} from wikiquotes) 
union all
(select 'wb' as project,'wikibooks' as name,${default_fields} from wikibooks) 
union all
(select 'wn' as project,'wikinews' as name,${default_fields} from wikinews) 
union all
(select 'ws' as project,'wikisources' as name,${default_fields} from wikisources)
union all
(select 'wy' as project,'wikivoyage' as name,${default_fields} from wikivoyage)
union all
(select 'wx' as project,'wmspecials' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, sum(users) as gusers, sum(activeusers) as gausers, sum(images) as gimages, count(id    ) as numwkis from wmspecials)
union all
(select 'wi' as project,'wikia' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, max(users) as gusers, 0 as gausers, sum(images) as gimages, count(id) as numwikis from wikia) 
union all
(select 'et' as project,'editthis' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins)-count(id) as gadmins, sum(users) as gusers,sum(activeusers) as gausers,sum(images) as gimages, count(id) as numwikis from editthis) 
union all
(select 'wr' as project,'wikitravel' as name,${default_fields} from wikitravel) 
union all
(select 'mw' as project,'mediawikis' as name,${default_fields} from mediawikis where statsurl not like '%opensuse%') 
union all
(select 'mt' as project,'metapedias' as name,${default_fields} from metapedias)
union all
(select 'sc' as project,'scoutwiki' as name,${default_fields} from scoutwiki)
union all
(select 'os' as project,'opensuse' as name,${default_fields} from opensuse) 
union all
(select 'un' as project,'uncyclomedia' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, max(users) as gusers, 0 as gausers,sum(images) as gimages, count(id) as numwikis from uncyclomedia) 
union all
(select 'wf' as project,'wikifur' as name,sum(good) as ggood, sum(total) as gtotal, sum(edits) as gedits, sum(admins) as gadmins, max(users) as gusers, 0 as gausers,sum(images) as gimages, count(id) as numwikis from wikifur)
union all
(select 'an' as project,'anarchopedias' as name,${default_fields} from anarchopedias) 
union all
(select 'si' as project,'wikisite' as name,${default_fields} from wikisite) 
union all
(select 'ne' as project,'neoseeker' as name,${default_fields} from neoseeker) 
union all
(select 'wv' as project,'wikiversity' as name,${default_fields} from wikiversity)
union all
(select 're' as project,'referata' as name,${default_fields} from referata)
union all
(select 'ro' as project,'rodovid' as name,${default_fields} from rodovid)
union all
(select 'lx' as project,'lxde' as name,${default_fields} from lxde)
union all
(select 'sw' as project,'shoutwiki' as name,${default_fields} from shoutwiki)
union all
(select 'w3' as project,'w3cwikis' as name,${default_fields} from w3cwikis)
union all
(select 'ga' as project,'gamepedias' as name,${default_fields} from gamepedias)
union all
(select 'sf' as project,'sourceforge' as name,${default_fields} from sourceforge)
union all
(select 'mh' as project,'miraheze' as name,${default_fields} from miraheze);";

?>
