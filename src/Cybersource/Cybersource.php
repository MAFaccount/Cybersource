<?php

namespace Cybersource;

use Illuminate\Support\Facades\Config;
use Cybersource\Traits\CybersourceValidatorTrait;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;


class Cybersource {
	use CybersourceValidatorTrait;

	
	protected $_logPath;
	protected $_sha;

	public function __construct(){
		$this->init();
		$this->_logger = new Logger('Cybersource');

		// the default date format is "Y-m-d H:i:s"
		$dateFormat = "Y n j, g:i a";
		// the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
		$output = "%datetime% > %level_name% > %message% %context% %extra%\n";

		$formatter =  new LineFormatter($output,$dateFormat);
		$stream = new StreamHandler($this->_logPath, Logger::DEBUG);
		$stream->setFormatter($formatter);
		$this->_logger->pushHandler($stream);
	}

	protected function init(){
		//load data from configuration file
		$this->_sha = config('cybersource.sha');
        $this->_logPath = config('itwoc.log_path');
	}

	public function getSignedFormFields(array $data = [],$secretKey ) : array{
	   
        if($this->validateRedirectFormData($data) && $secretKey != ''){
        	$signiture = $this->signFields($data,$secretKey);
        	$data['signature'] = $signiture;
        	return ['code' => 200,'data' => $data];
        }

        $response = [
            'code' => 422,
            'message' => 'Validation error check your array one of the requiered filed missing or secret key empty'
        ];

        return $response;
	}

	public function signFields ($params,$secret_key) {
	  return $this->signFieldsData($this->buildDataToSignFields($params),$secret_key );
	}

	public function signFieldsData($data, $secretKey) {
		$sha        = $this->_sha;
	    return base64_encode(hash_hmac( $sha , $data, $secretKey, true));
	}

	public function buildDataToSignFields($params) {
	        $signedFieldNames = explode(",",$params["signed_field_names"]);
	        foreach ($signedFieldNames as &$field) {
	           $dataToSign[] = $field . "=" . $params[$field];
	        }
	        return $this->commaSeparateFields($dataToSign);
	}

	public function commaSeparateFields ($dataToSign) {
	    return implode(",",$dataToSign);
	}


	//logging functions

	/**
	 * @param  string 			$info 			Info message to log in the log files
	 */
	public function logInfo($info = ''){
		$this->_logger->info($info);
	}

	/**
	 * @param  string 			$notice 		Notice message to log in the log files
	 */
	public function logNotice($notice = ''){
		$this->_logger->notice($notice);
	}

	/**
	 * @param  string 			$error 			Error message to log in the log files
	 */
	public function logError($error = ''){
		$this->_logger->error($error);
	}

	/**
	 * @param  string 			$warning 			Warning message to log in log files
	 */
	public function logWarning($warning = ''){
		$this->_logger->warning($warning);
	}
}
