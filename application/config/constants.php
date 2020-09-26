<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

define('API_LOGIN_ID', 'API564706');
define('API_PASSWORD', 'Mdsaddm0120@');
define('API_PIN', '514379');
define('API_DEDUCT_AMOUNT', '22');
define('PACKAGE_DISPLAY_ID', 'CRNMP');


define('ADMIN_DISPLAY_ID', 'CRNA');
define('MEMBER_DISPLAY_ID', 'CRNM');
define('SELLER_DISPLAY_ID', 'CRNS');
define('USER_DISPLAY_ID', 'CRNU');
define('WALLET_DISPLAY_ID', 'CRNMW');

define('FILE_UPLOAD_SERVER_PATH', '/home/cranesmart/public_html/media/member/');
define('KYC_FILE_UPLOAD_SERVER_PATH', '/home/cranesmart/public_html/media/kyc_document/');

/*define('SMS_API_URL', 'http://www.dakshinfosoft.com/api/sendhttp.php?');
define('SMS_API_AUTH_KEY', '7361AwIRVGhXCOf5c9cb929');
define('SMS_API_SENDERNAME', '');
define('SMS_API_SENDERID', 'CRNMRT');*/

define('SMS_API_URL', 'http://bulksms.thedigitalindia.net/index.php/smsapi/httpapi/?uname=cranesmart&password=123456&sender=CRANES&route=TA&msgtype=3&');

/*define('SMS_API_URL', 'http://msg.codunite.com/api/sendhttp.php?');
define('SMS_AUTH_KEY', '8572A7QwlGI7F7v5e84bf41P11');
define('SMS_SENDER_ID', 'CRNMRT');*/

//recharge api
define('RECHARGE_API_URL', 'http://paymyrecharge.in/api/recharge.aspx?');
define('RECHARGE_MEMBERID', 'API744599');
define('RECHARGE_API_PIN', '4578');

define('ELECTRICITY_RECHARGE_FETCH_API_URL', 'http://paymyrecharge.in/api/bbps/fatchbiller.aspx?');
define('ELECTRICITY_RECHARGE_FETCH_CUSTOMER_API_URL', 'http://paymyrecharge.in/api/bbps/FatchBillDetails.aspx?');
define('ELECTRICITY_RECHARGE_API_URL', 'http://paymyrecharge.in/api/bbps/Paybillnow.aspx?');

//DMR API 
define('DMR_API_URL', 'http://paymyrecharge.in/api/DMR/');
define('DMR_MEMBERID', 'API744599');
define('DMR_API_PIN', '4578');


#define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
define('PAYTM_ENVIRONMENT', 'PROD'); // PROD
define('PAYTM_MERCHANT_KEY', '#c&ks1qAG#RzK43M'); //Change this constant's value with Merchant key received from Paytm.
define('PAYTM_MERCHANT_MID', 'SDKizA36411607422855'); //Change this constant's value with MID (Merchant ID) received from Paytm.
define('PAYTM_MERCHANT_WEBSITE', 'DEFAULT'); //Change this constant's value with Website name received from Paytm.

$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
}

define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);

#define('PAYU_BASE_URL', 'https://sandboxsecure.payu.in');
define('PAYU_BASE_URL', 'https://secure.payu.in');
define('PAYU_MERCHANT_KEY', 'FTjslT7F');
define('PAYU_MERCHANT_SALT', 'vzBI3Hy3AI');


define('PRODUCT_IMAGE_FILE_PATH', '/home/cranesmart/public_html/media/product_images/');

#define('PDF_TEMPLATE_SYSTEM_URL','/home/academy/public_html/print/');
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
