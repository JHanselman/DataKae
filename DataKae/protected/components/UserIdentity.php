<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
 

 
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */

    private $_id;
     
    public function authenticate()
    {
        $user=User::model()->find('"userName"=:userName', array(':userName'=>$this->username));
        if (!isset($user))
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        elseif(!$this->validate_password($this->password, $user->passwordHash))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {   
            $this->_id=$user->userId;
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
        

    }
    
    private function validate_password($password, $correct_hash)
    {
        
        $pbdata=Yii::app()->params;
        $params = explode(":", $correct_hash);
        if(count($params) < $pbdata['HASH_SECTIONS'])
        {
            return false;
        }
        $pbkdf2 = base64_decode($params[$pbdata['HASH_PBKDF2_INDEX']]);
        return $this->slow_equals(
            $pbkdf2,
            $this->pbkdf2(
                $params[$pbdata['HASH_ALGORITHM_INDEX']],
                $password,
                $params[$pbdata['HASH_SALT_INDEX']],
                (int)$params[$pbdata['HASH_ITERATION_INDEX']],
                strlen($pbkdf2),
                true
            )
        );
    }

    // Compares two strings $a and $b in length-constant time.
    private function slow_equals($a, $b)
    {
        $diff = strlen($a) ^ strlen($b);
        for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
        {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }
    
    private function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
    {
        $algorithm = strtolower($algorithm);
        if(!in_array($algorithm, hash_algos(), true))
            die('PBKDF2 ERROR: Invalid hash algorithm.');
        if($count <= 0 || $key_length <= 0)
            die('PBKDF2 ERROR: Invalid parameters.');

        $hash_length = strlen(hash($algorithm, "", true));
        $block_count = ceil($key_length / $hash_length);

        $output = "";
        for($i = 1; $i <= $block_count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . pack("N", $i);
            // first iteration
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if($raw_output)
            return substr($output, 0, $key_length);
        else
            return bin2hex(substr($output, 0, $key_length));
    }
    
    public function getId()
    {
        return $this->_id;
    }
}
?>
