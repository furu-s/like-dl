<?php

class UserModel extends CI_Model {
    protected $user_id = DEFAULT_USER_ID;
    protected $user_token = DEFAULT_USER_TOKEN;
    protected $user_secret = DEFAULT_USER_SECRET;
    public function __construct() {
    }
    public function getUserID() {
        return $this->user_id;
    }
    public function getUserToken() {
        return $this->user_token;
    }
    public function getUserSecret() {
        return $this->user_secret;
    }
}
