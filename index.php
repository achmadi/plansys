<?php

## Define Root Dir
$root = dirname(__FILE__);

## Define core lib path
$yii = $root . '/framework/yii.php';
$config = $root . '/config/main.php';
$setting = $root . '/components/utility/Setting.php';
$composer = require ($root . '/vendor/autoload.php');

## Initialize settings
require_once ($setting);
Setting::init($config);

## Initialize Yii
require_once ($yii);
Yii::createWebApplication($config)->run();
