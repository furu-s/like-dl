<?php
use Abraham\TwitterOAuth\TwitterOAuth;

// TODO ちゃんとコメント書く
class TwitterModel extends CI_Model {
    private $connection = NULL;

    /*
     * メディアタイプ Twitter側で決められている
     */
    const MEDIA_TYPE_PHOTO        = 'photo';
    const MEDIA_TYPE_VIDEO        = 'video';
    const MEDIA_TYPE_ANIMATED_GIF = 'animated_gif';

    /**
     * コンストラクタ
     * DBとユーザーのログイン情報を使う
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('userModel');
    }

    /**
     * メディアを取ってきて配列で返す
     * @param  integer $limit  一度に取ってくる上限
     * @param  integer $offset 取ってくる場所をずらす
     * @return array           取ってきたいいねの配列
     */
    public function getMedia($limit = 50, $offset = 0) {
        $this->db->limit($limit, $offset)
                 ->select("media_id, media_thumb_url, media_url")
                 ->order_by("media_id", "DESC");
        return $this->db->get('media')->result_array();
    }

    /**
     * twitterのログイン処理
     * @return [type] twitterへの接続
     */
    public function loginTwitter() {
        return $this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->userModel->getUserToken(), $this->userModel->getUserSecret());
    }

    /**
     * メディアからクエリを生成します
     * @param  [type] $media    メディア
     * @param  [type] $tweet_id メディアが含まれるツイートのID
     * @return string           SQLを返します
     */
    private function formatMedia($media, $media_id) {
        $formatted_media = array(
            'media_id' => $media->id,
            'media_thumb_url' => $media->media_url_https,
            'tweet_id' => $media_id
        );
        if ($media->type === self::MEDIA_TYPE_PHOTO) {
            // 画像の場合、サムネイルとURLは同じ
            $formatted_media['media_url'] = $media->media_url_https;
            $formatted_media['media_type'] = $media->type;
        } else if (
            $media->type === self::MEDIA_TYPE_ANIMATED_GIF ||
            $media->type === self::MEDIA_TYPE_VIDEO) {
            // ビットレートが最も高い動画のみを抽出する
            $bitrate = -1;
            foreach($media->video_info->variants as $variant) {
                if (property_exists($variant, "bitrate")) {
                    if ($variant->bitrate > $bitrate) {
                        $formatted_media['media_url'] = $variant->url;
                        $formatted_media['media_type'] = $variant->content_type;
                        $bitrate = $variant->bitrate;
                    }
                }
            }
        }

        return '(' . $this->db->escape($formatted_media['media_id']) . ', ' . $this->db->escape($formatted_media['media_thumb_url']) . ', ' . $this->db->escape($formatted_media['tweet_id']) . ', ' . $this->db->escape($formatted_media['media_url']) . ', ' . $this->db->escape($formatted_media['media_type']) . '), ';
    }

    /**
     * いいねを取ってきてDBに登録する
     * @return boolean 成功したかどうか
     */
    public function fetchTweets() {
        // TODO 全体的に汚いので動いたらリファクタリング
        if($this->connection == NULL) {
            $this->loginTwitter();
        }

        // ツイートをフェッチしてくる
        $raw_tweets = $this->connection->get("favorites/list", ["count" => 200]);


        // ツイートの登録
        $sql_tweets = 'INSERT IGNORE INTO `tweets` (`tweet_id`, `user_id`, `text`, `published_at`, `lang`) VALUES ';

        foreach($raw_tweets as $tweet) {
            $sql_tweets .= '(' . $this->db->escape($tweet->id) . ', ' . $this->db->escape($tweet->user->id) . ',' . $this->db->escape($tweet->text) . ',' . $this->db->escape($tweet->created_at) . ',' . $this->db->escape($tweet->lang) . '), ';
        }
        $sql_tweets = rtrim($sql_tweets, ', ');  // 末尾のカンマを落とす
        if (!$this->db->query($sql_tweets)) {
            return false;
        }

        // ふぁぼの登録
        $sql_favorites = 'INSERT IGNORE INTO `favorites` (`tweet_id`, `user_id`) VALUES ';

        foreach($raw_tweets as $tweet) {
            $sql_favorites .= '(' . $this->db->escape($tweet->id) . ', ' . $this->db->escape($this->userModel->getUserID()) . '), ';
        }

        $sql_favorites = rtrim($sql_favorites, ', ');
        if (!$this->db->query($sql_favorites)) {
            return false;
        }

        // メディアの登録
        $sql_media = 'INSERT IGNORE INTO `media` (`media_id`, `media_thumb_url`, `tweet_id`, `media_url`, `media_type`) VALUES ';

        // メディアが含まれるツイートを抽出する
        $media_filter = function($tweet) {
            if(property_exists($tweet, "extended_entities")) {
                return property_exists($tweet->extended_entities, "media");
            }
            return false;
        };
        $media_tweets = array_filter($raw_tweets, $media_filter);

        foreach($media_tweets as $media_tweet) {
            foreach($media_tweet->extended_entities->media as $media) {
                $sql_media .= $this->formatMedia($media, $media_tweet->id);
            }
        }

        $sql_media = rtrim($sql_media, ', ');
        if (!$this->db->query($sql_media)) {
            return false;
        }

        return true;
    }
}
