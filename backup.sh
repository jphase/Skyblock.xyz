#!/bin/bash

# jphase's minecraft backup script

BACKUPDIR="/home/backup/backups"
DAYSBACK="4"
BACKUP=("/root/minecraft/plugins/GroupManager/worlds/world" "/root/minecraft/plugins/uSkyBlock/players" "/root/minecraft/skyworld/region")

# Remove backups that are before our days back window
find $BACKUPDIR -mtime +$DAYSBACK -exec rm -f {} \;

# Loop through database list and create gzipped backups
for bkup in "${BACKUP[@]}"; do
        DIRS=(${bkup//\// })
        NAME=${DIRS[${#DIRS[@]} - 1]}
        echo "`date +%Y-%m-%d\ %I:%M%p`: Compressing: $bkup   to   $BACKUPDIR/$NAME-`date +%Y-%m-%d`.tgz"
        tar -zcvf $BACKUPDIR/$NAME-`date +%Y%m%d`.tgz $bkup
done
