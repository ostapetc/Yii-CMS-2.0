#!/bin/bash

. props.sh

cd $deploy_dir


#git pull
echo '-----------git pull-----------'
git pull > /dev/null
#last_tag=$(git tag -l "*.*.*" | sort -V | tail -n 1)
#git_tag=$(echo $last_tag | awk -F \. {'print $1"."$2"."++$3'})
#git tag $git_tag && git push --tags


#rsync
echo '-----------rsync-----------'
rsync -ax --delete $deploy_dir $webroot


#configuring
echo '-----------configuring-----------'
sed -f ${overlays}production.sed ${app_dir}config/constants.php.tpl > ${app_dir}config/constants.php
sed -f ${overlays}production.sed ${app_dir}config/production.php.tpl > ${app_dir}config/production.php

chown -R www-data:www-data $deploy_dir
chown -R www-data:www-data $webroot


#clear
echo '-----------clear-----------'
rm -rf ${app_dir}/assets/*
rm -rf ${app_dir}/protected/runtime/*


#migate
echo '-----------migrate-----------'
php $yiic migrate up

#sphinx reindex
php $yiic sphinx_conf
sed -f ${overlays}production.sed $runtime/sphinx/sphinx.conf > /etc/sphinxsearch/sphinx.conf
/usr/local/bin/indexer --all --rotate --config /etc/sphinxsearch/sphinx.conf
/etc/init.d/sphinxsearch restart