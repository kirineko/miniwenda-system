<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Addbook extends CI_Controller {
    public function index() {

        $doubanApikey =  $this->config->item('doubanApikey');
        $raw_input = $this->input->raw_input_stream;
        $arr_input = json_decode($raw_input);

        if (isset($arr_input->isbn) && isset($arr_input->openId)) {
            $url = 'https://api.douban.com/v2/book/isbn/' . $arr_input->isbn . '?apikey=' . $doubanApikey;
            $raw_bookinfo = Requests::get($url)->body;
            $bookinfo = json_decode($raw_bookinfo, true);
        }

        $rate = $bookinfo['rating']['average'];
        [
            'title' => $title,
            'image' => $image,
            'alt' => $alt,
            'publisher' => $publisher,
            'summary' => $summary,
            'price' => $price
        ] = $bookinfo;

        $arr_tags = array_map(function($v) {
            return "{$v['title']} {$v['count']}";
        }, $bookinfo['tags']);
        $tags = implode(',', $arr_tags);
        $author = implode(',', $bookinfo['author']);
        log_message('info', json_encode([$rate, $title, $image, $alt, $publisher,
        $summary, $price, $tags, $author], JSON_UNESCAPED_UNICODE));


        $this->json([
            'code' => 0,
            'data' => [
                'isbn' => $title,
                'openid' => $image
            ]
        ]);
    }
}
