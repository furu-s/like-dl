<?php

class TwitterModelTest extends TestCase {
    public function setUp() {
        $this->resetInstance();
        $this->obj = $this->newModel('TwitterModel');;
    }
    public function testFetchTweets() {
        try{
            $this->obj->fetch_tweets();
            $this->assertTrue(true);
        }catch(Exception $e){
            $this->fail($e->getMessage());
        }
    }
}
