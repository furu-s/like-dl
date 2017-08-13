<?php

class TwitterModelTest extends TestCase {
    public function setUp() {
        $this->resetInstance();
        $this->obj = $this->newModel('TwitterModel');;

            /*$default_user_data = array(
                'user_id' => DEFAULT_USER_ID,
                'oauth_token' => DEFAULT_USER_TOKEN,
                'oauth_token_secret' => DEFAULT_USER_SECRET,
                'token_expired_at' => "9999-12-31 23:59:59"
            );
            $this->db->replace('users', $default_user_data);*/
    }


    /**
     * @dataProvider formatMediaProvider
     */
    public function testFormatMedia($media, $media_id, $expected) {
        $reflection = new ReflectionClass($this->obj);
        $method = $reflection->getMethod('formatMedia');
        $method->setAccessible(true);
        $response = $method->invoke($this->obj, $media, $media_id);
        $this->assertEquals($response, $expected);
    }

    public function formatMediaProvider() {
        return [
            [
                (object) [
                    'id' => 123,
                    'media_url_https' => 'https://example.com/image.png',
                    'type' => "photo"
                ],
                100,
                "(123, 'https://example.com/image.png', 100, 'https://example.com/image.png', 'photo'), "
            ],
            [
                (object) [
                    'id' => 456,
                    'media_url_https' => 'https://example.com/image.png',
                    'type' => 'animated_gif',
                    'video_info' => (object) [
                        'variants' => [
                            (object)[
                                'bitrate' => 0,
                                'content_type' => 'video\/mp4',
                                'url' => 'https://example.com/video.mp4'
                            ]
                        ]
                    ]
                ],
                200,
                "(456, 'https://example.com/image.png', 200, 'https://example.com/video.mp4', 'video\\\/mp4'), "
            ]
        ];
    }

    /**
     * 例外を飛ばさずにツイートをフェッチできるかどうか
     * @return [type] [description]
     */
    public function testFetchTweets() {
        try {
            $this->assertTrue($this->obj->fetchTweets());
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGetMedia() {
        $media_data = $this->obj->getMedia(50, 0);
        $this->assertEquals(50, count($media_data));
        $this->assertArrayHasKey('media_id', $media_data[0]);
        $this->assertArrayHasKey('media_thumb_url', $media_data[0]);
        $this->assertArrayHasKey('media_url', $media_data[0]);
    }
}
