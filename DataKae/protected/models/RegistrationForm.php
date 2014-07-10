<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
 
require_once '/../util/PasswordHash.php';
 
class RegistrationForm extends CFormModel
{

    public $username;
    public $password;
    public $locationId;
    public $emailAddress;
    public $verifyCode;
    
    public $playerName;
    public $playerLastName;
    public $playerNickname;
    
    private $_identity;

    const WEAK = 0;
    const STRONG = 1;
    
    function create_hash($password)
    {
    $pbdata=Yii::app()->params;
        // format: algorithm:iterations:salt:hash
        $salt = base64_encode(mcrypt_create_iv($pbdata['PBKDF2_SALT_BYTE_SIZE'], MCRYPT_DEV_URANDOM));
        return $pbdata['PBKDF2_HASH_ALGORITHM'] . ":" . $pbdata['PBKDF2_ITERATIONS'] . ":" .  $salt . ":" .
            base64_encode(pbkdf2(
                $pbdata['PBKDF2_HASH_ALGORITHM'],
                $password,
                $salt,
                $pbdata['PBKDF2_ITERATIONS'],
                $pbdata['PBKDF2_HASH_BYTE_SIZE'],
                true
            ));
    }
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('username, password, locationId, emailAddress, playerName, playerLastName, playerNickname', 'safe'),
            array('username, password, emailAddress', 'required'),
            array('password', 'passwordStrength', 'strength'=>self::STRONG),
            //array('emailAddress', 'email'),
            //array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements())
        );
    }

    /**
     * Registers the user if the given data is correct
     * @return boolean whether registration is successful
     */
    public function register()
    {
        $connection = Yii::app()->db;
        
        $transaction=$connection->beginTransaction();
        try
        {
            $newPlayer=new Player;
            $newPlayer->playerName = $this->playerName;
            $newPlayer->playerLastName = $this->playerLastName;
            $newPlayer->playerNickname = $this->playerNickname;
            $newPlayer->locationId=$this->locationId;
            
            $newPlayer->save();
            
            
            $newUser=new User;
            $newUser->userName = $this->username;
            $newUser->passwordHash=$this->create_hash($this->password);
            $newUser->playerId=$newPlayer->playerId;
            $newUser->emailAddress=$this->emailAddress;
            
            $newUser->save();
            
            $transaction->commit();
            return true;
        }
        catch(Exception $e) // an exception is raised if a query fails
        {
            $transaction->rollback();
            return false;
        }
    }
    
    public function passwordStrength($attribute,$params)
    {
        if ($params['strength'] === self::WEAK)
            $pattern = '/^(?=.*[a-zA-Z0-9]).{5,}$/';  
            
        elseif ($params['strength'] === self::STRONG)
            $pattern = '/^(?=.*\d(?=.*\d))(?=.*[a-zA-Z](?=.*[a-zA-Z])).{5,}$/';  
     
        if(!preg_match($pattern, $this->$attribute))
          $this->addError($attribute, 'Your password is not strong enough!');
    }
    
    function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
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

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'username'=>'Username',
            'password'=>'Password',
            'emailAddress'=>'E-mail address',
            'verifyCode'=>'Verification Code',
        );
    }
}
