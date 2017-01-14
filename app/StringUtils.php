<?php
namespace BugSpray;

class StringUtils{
  public static function email_meets_standards($email){
  	if(!filter_var($email, FILTER_VALIDATE_EMAIL) || preg_match('/\s/',$email)){
  		return false;
  	}else{
  		return true;
  	}
  }
}
?>
