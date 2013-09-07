<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
 

 
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user using a password.
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
    
    /*
     * Password hashing with PBKDF2.
     * Author: havoc AT defuse.ca
     * www: https://defuse.ca/php-pbkdf2.htm
     */
     
    //validates the password
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

    // Compares two strings $a and $b in length-constant time. This prevents hackers
    //from finding out whether their guesses are correct from how long it takes to compare strings.
    private function slow_equals($a, $b)
    {
        $diff = strlen($a) ^ strlen($b);
        for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
        {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }
    
/*
 * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
 * $algorithm - The hash algorithm to use. Recommended: SHA256
 * $password - The password.
 * $salt - A salt that is unique to the password.
 * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
 * $key_length - The length of the derived key in bytes.
 * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
 * Returns: A $key_length-byte key derived from the password and salt.
 *
 * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
 *
 * This implementation of PBKDF2 was originally created by https://defuse.ca
 * With improvements by http://www.variations-of-shadow.com
 */
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
