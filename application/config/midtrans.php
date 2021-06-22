<?php

$sandbox = array();
$sandbox['api_url']    = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
$sandbox['client_key'] = 'VT-client-4ceymOCQcozPJliH';
$sandbox['server_key'] = 'VT-server-U7ikS7r-qJez4zoQwa_rJO66';
$sandbox['is_production'] = false;
$sandbox['lib_snap'] = 'https://app.sandbox.midtrans.com/snap/snap.js';


$production = array();
$production['api_url']    = 'https://app.midtrans.com/snap/v1/transactions';
$production['client_key'] = 'VT-client-w5AZ3haIfVlfBSGk';
$production['server_key'] = 'VT-server-uoa8LTn7Dq-mgcMTdi3k5i-m';
$production['is_production'] = true;
$production['lib_snap'] = 'https://app.midtrans.com/snap/snap.js';


$config['midtrans'] = $sandbox;
