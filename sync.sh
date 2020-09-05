#!/bin/bash
RSYNC="/usr/bin/rsync"
RSYNC_OPTS="-avp"
EXCLUDE=(--exclude-from='./.rsync_exclude')

HOST=$(cat ./.vpshost)
PROJECT='wikistats'
DIRS=('/var/www' '/etc' '/usr/lib' '/usr/share/php' '/usr/local/bin')
LOCAL_DIR=$(pwd)

for DIR in "${DIRS[@]}"; do
    echo "${RSYNC} ${RSYNC_OPTS} ${EXCLUDE} ${HOST}:${DIR}/${PROJECT}/ ${LOCAL_DIR}${DIR}/${PROJECT}/"
    ${RSYNC} ${RSYNC_OPTS} ${EXCLUDE} ${HOST}:${DIR}/${PROJECT}/ ${LOCAL_DIR}${DIR}/${PROJECT}/
done

echo -n "\nremoving db pass from config.php"
sed -i 's/$dbpass.*/$dbpass="<not included>";/' ./etc/wikistats/config.php

