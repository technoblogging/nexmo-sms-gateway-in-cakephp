<?php
App::uses('AppController', 'Controller');
class SendTextController extends AppController {

	public function send(){

		$from='number';
		$to='number';
		$text='Hello';
		$this->_nexmoSendMessage($from, $to, $text);
		die;

	}

}
