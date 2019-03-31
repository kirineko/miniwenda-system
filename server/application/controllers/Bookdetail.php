<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** 
 * url: http://localhost:5757/weapp/bookdetail
 * return book detail
 */
class Bookdetail extends CI_Controller {
    public function index() {
        $id = $this->input->get('id');
        $this->load->database();
        $result = $this->db->query("update books set count = count + 1 where id = $id");
        $this->json([
            'code' => 0,
            'data' => [
                'incr' => $result
            ]
        ]);
    }
}
