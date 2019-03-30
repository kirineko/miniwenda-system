<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** 
 * url: http://localhost:5757/weapp/booklist
 * return book list
 */
class Booklist extends CI_Controller {
    public function index() {
        $page = $this->input->get('page');
        $limit = 10;
        $offset = intval($page) * $limit;
        $this->load->database();
        $result = $this->db->query("select books.*, cSessionInfo.user_info from `books`, `cSessionInfo` where books.openid = cSessionInfo.open_id order by books.id desc limit $limit offset $offset");
        $books = $result->result_array();
        $books = array_map(function($book){
            $userinfo = json_decode($book['user_info'], true);
            $book['user_info'] = ['nickName' => $userinfo['nickName']];
            return $book;
        }, $books);
        $this->json([
            'code' => 0,
            'data' => [
                'list' => $books
            ]
        ]);
    }
}
