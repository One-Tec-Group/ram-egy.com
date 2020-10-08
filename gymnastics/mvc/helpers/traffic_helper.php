<?php
// function varifyValidUser($email = NULL, $purchase_username = NULL, $purchase_code = NULL, $version = NULL) {
//
// 	$returnData['status'] = FALSE;
//
// 	if(is_null($purchase_username) || is_null($purchase_code)) {
// 		$file = APPPATH.'config/purchase.php';
// 		// @chmod($file, FILE_WRITE_MODE);
// 		$purchase = file_get_contents($file);
// 		$purchase = json_decode($purchase);
//
//
// 		if(is_array($purchase)) {
// 			$purchase_code = trim($purchase[1]);
// 			$purchase_username = trim($purchase[0]);
//
// 		}
//
// 		if(empty($purchase_code) || empty($purchase_username)) {
// 			return json_decode(json_encode($returnData));
// 		}
// 	}
//
// 	$site = base_url();
// 	$ip = getIpAddress();
// 	$email = trim($email);
// 	$version = config_item('ini_version');
//
//     $data = array(
//         'purchase_code' => $purchase_code,
//         'username'      => $purchase_username,
//         'ip'            => $ip,
//         'domain'        => $site,
//         'purpose'       => 'update',
//         'product_name'  => config_item('product_name'),
//         'version'		=> $version,
//         'email' 		=> $email,
//     );
//
//     $apiCurl = apiCurl($data);
// 	return $apiCurl;
// }

function apiCurl($data, $url = NULL) {

	if(is_null($url)) {
        $url = activeServer();
    }

	if(!$url) {
		return (object) array(
			'status' => FALSE,
			'message' => 'Server Down',
			'for' => 'purchasecode',
		);
	}

	$data_string = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)]
    );
    $result = curl_exec($ch);
    $jsondata = json_decode($result);
    return $jsondata;
}

function activeServer() {
	$allDomain = config_item('installDomain');
	if(count($allDomain)) {
		foreach ($allDomain as $domainKey => $domain) {
			$url = parse_url($domain);
			if(checkInternetConnection($url['host'])) {
				return $domain.'/api/check';
			}

		}
	}
	return FALSE;
}

function checkInternetConnection($sCheckHost = 'www.google.com')  {
	return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 30);
}
