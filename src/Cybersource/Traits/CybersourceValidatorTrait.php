<?php 

namespace Cybersource\Traits;

trait CybersourceValidatorTrait { 
    
    /**
     * $_redirectFormData shows the correct structure for AddCard Service Array
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
        'transaction_type' => '',
        'transaction_uuid' => '',
        'unsigned_field_names' => '',
        'payment_method' => '',
        
    ];

   
    
    protected function validateRedirectFormData(array $data = []) : bool {
        return $this->followsFormat($data , $this->_redirectFormData);
    }

    protected function followsFormat($data , $format) : bool {
        $arrayKeys = array_keys($format);
        foreach ($arrayKeys as $key => $value){
            if(!isset($data[$value])){
                return false;
            }
        }
       
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












