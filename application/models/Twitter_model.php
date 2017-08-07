<?php
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter_model extends CI_Model {
    private $connection = NULL;
    private $user_id;

    public function __construct()
    {
        $this->load->database();
        $user_id = DEFAULT_USER_ID;
    }
    public function login_twitter() {
        return $this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, DEFAULT_USER_KEY, DEFAULT_USER_SECRET);
    }

    public function fetch_tweets() {
        if($this->connection == NULL) {
            $this->login_twitter();
        }

        $default_user_data = array(
            'user_id' => $user_id,
            'oauth_token' => DEFAULT_USER_KEY,
            'oauth_token_secret' => DEFAULT_USER_SECRET,
            'token_expired_at' => "9999-12-31 23:59:59"
        );
        $this->db->insert('users', $default_user_data);
        $raw_tweets = $this->connection->get("favorites/list", ["count" => 200]);
        $tweets_formatter = function($tweet) {
            return array(
                'tweet_id' => $tweet['id'],
                'user_id' => $tweet['user']['id'],
                'text' => $tweet['text'],
                'published_at' => $tweet['created_at'],
                'lang' => $tweet['lang']
            );
        };

        $tweets = array_map($tweets_formatter, $raw_tweets);
        $this->db->insert_batch('tweets', $tweets);

        $favorite_formatter = function($tweet) {
            return array(
                'tweet_id' => $tweet['id'],
                'user_id' => $user_id
            );
        };
        $favorites = array_map($favorite_formatter, $raw_tweets);
        $this->db->insert_batch('favorites', $favorites);
    }
}
