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

        $default_user_data = array(
            'user_id' => DEFAULT_USER_ID,
            'oauth_token' => DEFAULT_USER_KEY,
            'oauth_token_secret' => DEFAULT_USER_SECRET,
            'token_expired_at' => "9999-12-31 23:59:59"
        )
        $this->db->insert('users', $default_user_data);
        $tweets = $this->connection->get("favorites/list", ["count" => 200]);
        $tweets_formatter = function($tweet) {
            return array(
                'tweet_id' => $tweet['id'],
                'user_id' => $tweet['user']['id'],
                'text' => $tweet['text'],
                'published_at' => $tweet['']
            );
        }

        $tweets = array_map()
    }
}
