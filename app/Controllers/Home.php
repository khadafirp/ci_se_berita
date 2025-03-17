<?php

namespace App\Controllers;

use App\Filters\MessageBroker\Consumer;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{

    use ResponseTrait;

    public function index()
    {
        $consumer = new Consumer;
        $result = $consumer->menerima('berita');

        $json_data = json_decode($result[0], true);

        return $this->respond([
            'status-code' => 200,
            'message' => $json_data
        ])->setStatusCode(200, 'success');
    }
}
