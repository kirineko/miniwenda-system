<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Booklist extends CI_Controller {
    public function index() {
        $books = DB::select('books', ['*'], '', '', '');
        $this->json([
            'code' => 0,
            'data' => [
                'list' => $books
            ]
        ]);
    }
}
