<?php
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter_model extends CI_Model {
    private $connection = NULL;

    public function __construct()
    {
        $this->load->database();
    }
    public function login_twitter() {
        return $this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, DEFAULT_USER_KEY, DEFAULT_USER_SECRET);
    }

    public function fetch_tweets() {
        if($this->connection == NULL) {
            $this->login_twitter();
        }
        $this->connection->get("statuses/favorites", ["count" => 25, "exclude_replies" => true]);
    }
}
