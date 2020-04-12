<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$config['USER_STATUS'] = array(

	//key					database key	Description

	'NEW'		=> array(	'NEW', 			'New'),
	'ACTIVE'	=> array(	'ACTIVE', 		'Active'),
	'LOCKED'	=> array(	'LOCKED', 		'Locked'),
	'BLOCKED'	=> array(	'BLOCKED', 		'Blocked')
);




$config['USER_ROLE'] = array(

	//key						database key		Description 				Functions

	'SYS_ADMIN'		=> array(	'SYS_ADMIN', 		'System Administrator',		array('POS', 'BRAND', 'CATEGORY', 'STOCK_TYPE', 'ITEM', 'WH_INVENTORY', 'WH_SUPPLY_REQUEST', 'BR_INVENTORY', 'BR_SUPPLY_REQUEST', 'SALES', 'BRANCH', 'USER')),

	'WHOUSE_USER'	=> array(	'WH_USER', 		'Warehouse User',				array('WH_INVENTORY', 'WH_SUPPLY_REQUEST')),

	'BRANCH_USER'	=> array(	'BRANCH_USER', 		'Branch User',				array('POS', 'BR_INVENTORY', 'BR_SUPPLY_REQUEST', 'SALES')),

	'CASHIER'		=> array(	'CASHIER', 			'Cashier',					array('POS'))
);


