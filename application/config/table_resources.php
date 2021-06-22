<?php

$config['table_resources'] = array(
	
	// CORE
	array('model' => 'de/system/Sequences'),
	array('model' => 'de/system/Countries'),
	array('model' => 'de/system/Taxes'),
	array('model' => 'de/system/Crons'),
	
	array('model' => 'de/setting/Groups'),
	array('model' => 'de/setting/Users'),
	array('model' => 'de/setting/Clients'),
	array('model' => 'de/setting/Projects'),
	array('model' => 'de/setting/UsersGroups'),
	array('model' => 'de/setting/AclResource'),
	array('model' => 'de/setting/AclRestrictedResource'),

	// POSTS
	//array('model' => 'de/content/Posts'),
	
	// TICKET
	//array('model' => 'de/ticket/OperatorCategories'),
	//array('model' => 'de/ticket/Offices'),
	//array('model' => 'de/ticket/Operators'),
	array('model' => 'de/ticket/ProductEvents'),
	array('model' => 'de/ticket/ProductTaxes'),
	array('model' => 'de/ticket/TicketOrders'),
	array('model' => 'de/ticket/TicketOrdersDtl'),
	array('model' => 'de/ticket/TicketPayments'),
	array('model' => 'de/ticket/TicketPaymentVaNumbers'),
	array('model' => 'de/ticket/Sales'),
	
	
	// REPORTS
	//array('model' => 'de/report/Months'),
	
	// CONTEST
	//array('model' => 'de/contest/Questions'),
	//array('model' => 'de/contest/Contestants'),
	//array('model' => 'de/contest/Scores'),

);
