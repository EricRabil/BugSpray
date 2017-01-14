<?php

namespace BugSpray;

class Messages{
    
    private $messages;
    private $app;
    
    public function __construct(\BugSpray\Controller $app){
        $this->app = $app;
        $this->init_errors();
    }
    
    public function init_errors(){
        $this->messages['errors'] = array();
    //Generic errors
    $this->messages['errors']['000'] = "Internal Error";

    //Login / Registration - User authentication is disabled
    $this->messages['errors']['A01'] = "Sorry! User authentication systems are currently down. Please check back later.";
    //Registration - Registrations, and only registrations, are disabled.
    $this->messages['errors']['A02'] = "Sorry! User registration has been disabled. If you would like an account, please contact the admins.";
    //Registration - The e-mail is taken
    $this->messages['errors']['A03'] = "Sorry! That e-mail is taken. Please use a different one.";
    //Registration - The e-mail is empty
    $this->messages['errors']['A04'] = "Sorry! The e-mail field cannot be empty and must be valid.";
    //Registration - The displayname is empty.
    $this->messages['errors']['A05'] = "Sorry! The displayname field cannot be empty.";
    //Registration - The password is empty
    $this->messages['errors']['A06'] = "Sorry! The password field cannot be empty.";
    //Registration - The passwords do not match
    $this->messages['errors']['A07'] = "Sorry! The passwords must match.";
    //Registration - The password does not score a level 3 or higher on the ZXCVBN scale
    $this->messages['errors']['A08'] = "Sorry! The password does not meet ZXCVBN requirements. Please make sure you have alternating caps and your password is nothing obvious (like your name, email, displayname, etc.)";
    //Registration - The password's characters are shorter than INT $this->app->steel->config['security']['registration']['minimumCharacters']
    $this->messages['errors']['A09'] = "Sorry! The password must be at least ".$this->app->steel->config['security']['registration']['minimumCharacters']." characters long.";
    //Registration - The password's characters are longer than 4096 characters
    $this->messages['errors']['A10'] = "Hey there, you cryptographically-savy user! Your password is too secure - Please make it 4096 characters or lower.";
    //Registration - No fields were posted. /signup/process was likely called manually.
    $this->messages['errors']['A11'] = "Sorry! You must fill out the <b>entire</b> form.";

    //Login - The password is empty
    $this->messages['errors']['C01'] = $this->messages['errors']['A06'];
    //Login - The email is empty
    $this->messages['errors']['C02'] = $this->messages['errors']['A04'];
    //Login - The password is incorrect
    $this->messages['errors']['C03'] = "Sorry! The email or password is incorrect.";

$this->messages = array();
    //Registration - Successful, awaiting manual approval
    $this->messages['messages']['A01'] = "Thanks for registering! This bug tracker requires users to be manually approved by the admins. Please check back in a few days/hours to see your status.";
    //Registration - Successful, no approval needed
    $this->messages['messages']['A02'] = "Thanks for registering! Your account is now active and free to report bugs :)";
    //Registration - Registration (and only registration) is disabled
    $this->messages['messages']['A03'] = "Sorry, registration has been disabled.";

    //General - Not authorized
    $this->messages['messages']['001'] = "Sorry, you must be logged in and have the proper permissions to do that.";
    //General - Not found
    $this->messages['messages']['404'] = "Sorry, %s could not be found.";

$this->messages['titles'] = array();
    //Registration - Successful, awaiting manual approval
    $this->messages['titles']['A01'] = "Registration submitted - Awaiting approval";
    //Registration - Successful, no approval needed
    $this->messages['titles']['A02'] = "Registration Successful!";
    //Registration - Registration (and only registration) is disabled
    $this->messages['titles']['A03'] = "Registration Disabled";

    //General - Not authorized
    $this->messages['titles']['001'] = "Not Authorized";
    }
    
    public function get_error($code){
        return (array_key_exists($code, $this->messages['errors'])) ? $this->messages['errors'][$code] : "Sorry! Something went wrong.";
    }
    
    public function get_message($code){
        return (array_key_exists($code, $this->messages['errors'])) ? $this->messages['messages'][$code] : "Message body";
    }
    
    public function get_message_title($code){
        return (array_key_exists($code, $this->messages['errors'])) ? $this->messages['titles'][$code] : "Message title";
    }
    
    public function get_errors(){
        return $this->messages['errors'];
    }
    
    public function get_messages(){
        return $this->messages['messages'];
    }
    
    public function get_message_titles(){
        return $this->messages['titles'];
    }
    
    public function get_all_strings(){
        return $this->messages;
    }
}