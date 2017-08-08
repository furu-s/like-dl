<?php
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterModel extends CI_Model {
    private $connection = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('userModel');
    }
    public function login_twitter() {
        return $this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->userModel->getUserToken(), $this->userModel->getUserSecret());
    }

    public function fetch_tweets() {
        if($this->connection == NULL) {
            $this->login_twitter();
        }

        /*$default_user_data = array(
            'user_id' => $this->userModel->getUserID(),
            'oauth_token' => $this->userModel->getUserToken(),
            'oauth_token_secret' => $this->userModel->getUserSecret(),
            'token_expired_at' => "9999-12-31 23:59:59"
        );
        $this->db->insert('users', $default_user_data);*/
        $raw_tweets = $this->connection->get("favorites/list", ["count" => 200]);
        $tweets_formatter = function($tweet) {
            return array(
                'tweet_id' => $tweet->id,
                'user_id' => $tweet->user->id,
                'text' => $tweet->text,
                'published_at' => $tweet->created_at,
                'lang' => $tweet->lang
            );
        };

        // TODO 1回のクエリで済むようにする
        $tweets = array_map($tweets_formatter, $raw_tweets);
        foreach($tweets as $tweet) {
            $this->db->replace('tweets', $tweet);
        }

        $favorite_formatter = function($tweet) {
            return array(
                'tweet_id' => $tweet->id,
                'user_id' => $this->userModel->getUserID()
            );
        };
        $favorites = array_map($favorite_formatter, $raw_tweets);
        foreach($favorites as $favorite) {
            $this->db->replace('tweets', $favorite);
        }
    }
}
