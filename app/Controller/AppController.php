<?php
App::uses('Controller', 'Controller');
App::import('Vendor', 'Nexmo', array('file' => 'Nexmo/NexmoMessage.php'));


class AppController extends Controller {

	protected function _nexmoSendMessage($from = null, $to = null, $text = null)
	{
		try {
		
			$url = 'https://rest.nexmo.com/sms/json?';
			$queryParam = array(
				'api_key' => 'api_key',
				'api_secret' => 'api_secret',
				'from' => $from,
				'to' => $to,
				'text' => $text
			);
			$urlQueryString = $url . http_build_query($queryParam);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $urlQueryString);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Receive server response
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$responseData = curl_exec($ch);
			pr($responseData);
			if (curl_error($ch)) {
				throw new Exception(curl_error($ch));
			}
			curl_close ($ch);
			$data = json_decode($responseData, true);
			if (!isset($data['messages'])) {
				throw new Exception('Unknown API Response.');
			}
			foreach ($data['messages'] as $message) {
				if ($message['status'] != 0) {
					throw new Exception($message['error-text']);
				}
			}
		} catch(Exception $e) {
			CakeLog::write('nexmo_sms_gateway_error_log', $e->getMessage());
		}
	}

}
