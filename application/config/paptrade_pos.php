<?php
defined('BASEPATH') OR exit('No direct script access allowed');




$config['USER_STATUS_ASSOC'] = array(

	//key					database key	Description

	'NEW'		=> array(	'NEW', 			'New'),
	'ACTIVE'	=> array(	'ACTIVE', 		'Active'),
	'LOCKED'	=> array(	'LOCKED', 		'Locked'),
	'BLOCKED'	=> array(	'BLOCKED', 		'Blocked')
);


$config['USER_STATUS'] = array(
	$config['USER_STATUS_ASSOC']['NEW'],
	$config['USER_STATUS_ASSOC']['ACTIVE'],
	$config['USER_STATUS_ASSOC']['LOCKED'],
	$config['USER_STATUS_ASSOC']['BLOCKED'],
);




$config['USER_ROLE_ASSOC'] = array(
	//key						database key		Description 
	'SYS_ADMIN'		=> array('SYS_ADMIN', 		'System Administrator'),
	'WHOUSE_USER'	=> array('WHOUSE_USER', 		'Warehouse User'),
	'BRANCH_USER'	=> array('BRANCH_USER', 	'Branch User'),
	'CASHIER'		=> array('CASHIER', 		'Cashier')
);

$config['USER_ROLE_ASSOC_MENU'] = array(
	'SYS_ADMIN'		=> array('POS', 'BRAND', 'CATEGORY', 'STOCK_TYPE', 'ITEM', 'WH_INVENTORY', 'WH_SUPPLY_REQUEST', 'BR_INVENTORY', 'BR_SUPPLY_REQUEST', 'SALES', 'ADMIN', 'BRANCH', 'USER'),
	'WHOUSE_USER'	=> array('WH_INVENTORY', 'WH_SUPPLY_REQUEST'),
	'BRANCH_USER'	=> array('POS', 'BR_INVENTORY', 'BR_SUPPLY_REQUEST', 'SALES'),
	'CASHIER'		=> array('POS')
);


$config['USER_ROLE'] = array(
	$config['USER_ROLE_ASSOC']['SYS_ADMIN'],
	$config['USER_ROLE_ASSOC']['WHOUSE_USER'],
	$config['USER_ROLE_ASSOC']['BRANCH_USER'],
	$config['USER_ROLE_ASSOC']['CASHIER']
);

$config['USER_ROLE_MENU'] = array(
	$config['USER_ROLE_ASSOC_MENU']['SYS_ADMIN'],
	$config['USER_ROLE_ASSOC_MENU']['WHOUSE_USER'],
	$config['USER_ROLE_ASSOC_MENU']['BRANCH_USER'],
	$config['USER_ROLE_ASSOC_MENU']['CASHIER']
);


