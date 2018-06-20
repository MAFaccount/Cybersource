<?php 

namespace Cybersource\Traits;

trait CybersourceValidatorTrait {
	
    /**
     * $_addCardAction shows the correct structure for AddCard Service Array
     * @var Array
     */
    protected $_redirectFormData = [
        'access_key' => '',
        'amount' => '',
        'currency' => '',
        'locale' => '',
        'profile_id' => '',
        'reference_number' => '',
        'signed_field_names' => '',
        'transacation_type' => '',
        'transaction_uid' => '',
        'unsigned_field_names' => '',
        'payment_method' => ''
    ];

   
    /**
     * validateAddCardAction accepts the array to be validated fot AddCard Service
     * it will pass the array it recieved along with it's correct structure that
     * it should implement to the followsFormat function
     * @param  Array  $data [array for AddCard Service]
     * @return Bool       [whether it follows the format or not]
     */
    protected function validateRedirectFormData(array $data = []) : bool {
        return $this->followsFormat($data , $this->_redirectFormData);
    }

    /**
     * followsFormat checks if the passed array follows it's predefined structure
     * @param  Array $data   [array of data for a particular service]
     * @param  [Array] $format [array of predefined data structure for a particular service  ]
     * @return [Bool]         [whether the match or not based on there keys matching recursively]
     */
    protected function followsFormat($data , $format) : bool {
        if(array_keys($data) != array_keys($format))
            return false;

        foreach ($data as $key => $value) {
            if(is_array($value)){
                $bool = $this->followsFormat($value , $format[$key]);

                if(!$bool)
                    return $bool;
            }
        }

        return true;
    }
}












