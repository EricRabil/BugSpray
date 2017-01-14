<?php
namespace BugSpray;

require_once dirname(__FILE__).'/autoload.php';

class Controller implements \Steel\IApplication{

    public $steel;
    private $bundle;
    private $args;
    
    public $messages;

    private $intercepted_classes = array();

    public function __construct(\Steel\Steel $steel) {
        $this->steel = $steel;
        $this->messages = new \BugSpray\Messages($this);
    }

    public function on_load() {
      $this->filter_session();
      if(isset($_COOKIE[$this->steel->config['security']['rememberMeCookieKey']])){
        $this->remember_me();
      }
    }

    private function filter_session(){
      if(isset($_SESSION['user']) && $_SESSION['user']['session_active']){
        $user = $_SESSION['user'];
        if($user['login_activation_time'] < time() - $config['security']['login']['userLoginDeactivationTime']){
          //The user's login has timed out. Deactivate and remove all data from $_SESSION['user']
          $_SESSION['pages']['login']['timeoutMessage'] = array('code' => 'B01', 'name' => $user['displayname']);
          $_SESSION['user']['session_active'] = false;
          $_SESSION['user']['expiredAt'] = time();
          unset($_SESSION['user']['email']);
          unset($_SESSION['user']['displayname']);
          unset($_SESSION['user']['rank']);
        }
      }else{
        $_SESSION['user'] = array('session_active' => false);
      }
    }

    private function remember_me(){
        $validator = $_COOKIE[$config['security']['rememberMeCookieKey']];
        $sql = 'SELECT validator, userid, expires FROM persistence_tokens WHERE validator = ?';
        $stmt = getConn()->prepare($sql);
        $stmt->execute(array($validator));
        if($stmt->rowCount() === 0){
          //Unset cookie - Expired or invalid validator
          setcookie($config['security']['rememberMeCookieKey'], "invalidated-by-server", 1);
        }else{
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $expiretime = strtotime($result['expires']);
          if(time() > $expiretime){
            setcookie($config['security']['rememberMeCookieKey'], "invalidated-by-expiration", 1);
            $sql = "DELETE FROM persistence_tokens WHERE validator = ?";
            $stmt = getConn()->prepare($sql);
            $stmt->execute(array($result['validator']));
          }elseif(hash_equals($result['validator'], $validator)){
            //RememberMe Validated; Delete and regenerate token
            $sql = "DELETE FROM persistence_tokens WHERE validator = ?";
            $stmt = getConn()->prepare($sql);
            $stmt->execute(array($_COOKIE[$config['security']['rememberMeCookieKey']]));

            $userid = $result['userid'];

            //Get User

            $sql = "SELECT user_email, user_dname, user_rank FROM users WHERE user_id = ?";
            $stmt = getConn()->prepare($sql);
            $stmt->execute(array($userid));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user'] = array(
              'email' => $result['user_email'],
              'displayname' => $result['user_dname'],
              'rank' => $result['user_rank'],
              'session_active' => true,
              'login_activation_time' => time()
            );

            //Regenerate
            $newValidator = hash('sha256', UUID::generateUUID());

            //Table data
            $expires = date('Y-m-d H:i:s', strtotime('+7 days'));

            //Insert
            $sql = "INSERT INTO persistence_tokens (validator, userid, expires) VALUES (?, ?, ?)";
            $stmt = getConn()->prepare($sql);
            $stmt->execute(array($newValidator, $userid, $expires));

            //Set
            setcookie($config['security']['rememberMeCookieKey'], $newValidator, strtotime('+7 days'), '/');
          }else{
            //Unset cookie
            setcookie($config['security']['rememberMeCookieKey'], "invalidated-by-server", 1);
          }
        }
    }

    public function create_input_field($faClass, $inputType, $placeholder, $id){
    	return '<span class="input-group-addon" id="basic-addon1"><i class="'.$faClass.'" aria-hidden="true"></i></span> <input type="'.$inputType.'" class="form-control" placeholder="'.$placeholder.'" id="'.$id.'" name="'.$id.'" required autofocus>';
    }

    public function create_input_field_with_value($faClass, $inputType, $placeholder, $value, $id){
    	return '<span class="input-group-addon" id="basic-addon1"><i class="'.$faClass.'" aria-hidden="true"></i></span> <input type="'.$inputType.'" class="form-control" placeholder="'.$placeholder.'" id="'.$id.'" name="'.$id.'" required autofocus>';
    }

    public function call(\Steel\MVC\MVCBundle $bundle, $arguments) {
        $this->on_load();
        if(in_array($arguments[0], $this->intercepted_classes)){
            $this->bundle = $bundle;
            $this->args = $arguments;
            return true;
        }else{
            return false;
        }
    }

    public function intercepts($classname){
        return in_array($classname, $intercepted_classes);
    }

}
