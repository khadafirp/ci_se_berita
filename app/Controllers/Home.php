<?php

namespace App\Controllers;

use App\Filters\MessageBroker\Consumer;
use App\Models\BeritaModel;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{

    use ResponseTrait;

    public function index()
    {
        $consumer = new Consumer;
        $result = $consumer->menerima('berita');
        $json_data = null;
        $message = null;
        $model = new BeritaModel();

        if(!empty($result)){
            $json_data = json_decode($result[0], true);
            $message = 'Sukses, data berhasil ditambahkan.';

            $model->set('kategori_id', $json_data['kategori_id']);
            $model->set('news_title', $json_data['news_title']);
            $model->set('news_description', $json_data['news_description'], true);
            $model->set('filename', $json_data['filename']);
            $model->set('filesize', $json_data['filesize']);
            $model->set('path', $json_data['path']);
            $model->insert();
        } else {
            $message = 'Gagal, karena data tidak ada.';
        }

        return $this->respond([
            'status-code' => 200,
            'message' => $message,
            'data' => $json_data
        ])->setStatusCode(200, 'success');
    }
}
