#!/bin/bash

basedir=/var/www/phpenv.com/
deploy_dir=${basedir}deploy/
webroot=${basedir}www/

app_dir=${webroot}protected/
yiic=${app_dir}libs/yii/yiic.php

#'main-action := $(or $(shell if [ "${mainaction}" != "" ]; then echo ${mainaction}; else whiptail --clear --menu 'What do you want to do?' 13 30 5 'deployment' '' 'rollback' '' 'remove-maintenance-page' '' 'remove-deploy-lock' '' 'sync-local-git' '' 3>&1 1>&2 2>&3; fi), $(shell $(on-cancel)), $(error cancelled))'