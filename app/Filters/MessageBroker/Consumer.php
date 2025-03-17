<?php
namespace App\Filters\MessageBroker;

use App\Controllers\ThirdPartyController;
use App\Filters\Dto\MessageBrokerDto;
use App\Models\BeritaModel;
use App\Models\ListToken;
use App\Models\Pengguna;
use CodeIgniter\API\ResponseTrait;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer{
    use ResponseTrait;
    public function menerima($queue){
        $dataArr = array();
        try {
            $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');    
            $channel = $connection->channel();
            $channel->queue_declare($queue, false, false, false, false);
        
            $data = $channel->basic_get($queue, true, null)->getBody();
            array_push($dataArr, $data);
        
            $channel->close();
            $connection->close();
            return array_values($dataArr);
        } catch (\Exception $e) {
            return array_values($dataArr);
        }
    }
}