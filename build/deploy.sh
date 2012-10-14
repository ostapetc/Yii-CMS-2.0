#!/bin/bash


. props.sh


action=$(whiptail --clear --menu 'What do you want to do?' 13 30 5 'deploy' '' 'rollback' '' 'remove-maintenance-page' '' 'remove-deploy-lock' '' 3>&1 1>&2$
. $action;







cd $deploy_dir


#git pull
echo '-----------git pull-----------'
git pull > /dev/null
#last_tag=$(git tag -l "*.*.*" | sort -V | tail -n 1)
#git_tag=$(echo $last_tag | awk -F \. {'print $1"."$2"."++$3'})
#git tag $git_tag && git push --tags


#rsync
echo '-----------rsync-----------'
rsync -azx --delete $deploy_dir $webroot


#configuring
echo '-----------configuring-----------'
sed -f ${overlays}production.sed ${app_dir}config/constants.php.tpl > ${app_dir}config/constants.php
sed -f ${overlays}production.sed ${app_dir}config/production.php.tpl > ${app_dir}config/production.php

chown -R www-data:www-data $deploy_dir
chown -R www-data:www-data $webroot


#migate
echo '-----------migrate-----------'
php $yiic migrate up




