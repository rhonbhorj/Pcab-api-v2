<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route[ 'default_controller' ] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the 'welcome' class
| would be loaded.
|
|	$route[ '404_override' ] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route[ 'translate_uri_dashes' ] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login/index' ;
$route['404_override'] = '' ;
$route['translate_uri_dashes'] = FALSE ;


// $route['login']  = 'login/index'; 
$route['logout']  = 'login/logout'; 



// $route['test']  = 'welcome/test'; 

$route['transaction-table']  = 'welcome/index';
$route['acknowledgement-receipt']  = 'welcome/index';
$route['deposit']  = 'welcome/index';
$route['dashboard']  = 'welcome/index';
$route['get-transactions']  = 'welcome/getTransactions';
$route['get-transactions-by-date'] = 'welcome/getTransactionsByDate';
$route['get-transaction'] = 'welcome/getTransactionById';
$route['transaction-dashboard']  = 'Welcome/index';
$route['transaction-report']  = 'TransactionReport/dasboardReportData';

// $route['get-data']  = 'welcome/get_data';
//api  deposit_log
$route['generate-qr'] = 'middleware/generate_qr';
$route['generate-token'] = 'api/generate_token';
$route['transaction-status'] = 'api/trans_status';
// $route['all-transaction-data'] = 'api/all_transaction_data';

$route['total-txn-amount'] = 'middleware/total_txnamount_indate';
$route['submit-deposit'] = 'middleware/deposit_log';
$route['deposit-logs'] = 'middleware/all_deposit_data';
$route['all-transaction-data'] = 'middleware/all_transaction_data';
$route['logout'] = 'login/logout';

$route['FAQ'] = 'welcome/faq_page';
$route['Maintenance'] = 'welcome/maintenance';
