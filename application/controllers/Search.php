<?php
class Search extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('TwitterModel');
    }

    public function index() {
        $media_data = $this->TwitterModel->getMedia(50, 0);
        $this
            ->output
            ->set_content_type('application/json')
            ->set_output(json_encode($media_data));
    }
}
