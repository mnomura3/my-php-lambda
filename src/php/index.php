<?php

require 'vendor/autoload.php';
date_default_timezone_set('Asia/Tokyo');

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

/**
 * Class Test
 *
 * AWS Lambda上でphpを使用してJsonをResponseできるか確認
 */
class Test {
    /**
     * @param $n
     * @return int
     */
    public function fib($n) {
        if ($n == 0) {
            return 0;
        } else if ($n == 1) {
            return 1;
        }

        // 再帰
        return self::fib($n-1) + self::fib($n-2);
    }
}

for ($i = 0; $i <= 10; $i++) {
    $fib[] = Test::fib($i);
}

if (!empty($fib)) {
    $json = json_encode($fib, JSON_UNESCAPED_UNICODE);
    echo $json;
} else {
    // エラーをSQSへqueメッセージをSlack通知
    // todo ↓へ管理者へ通知その処理

    // キューの作成
    $queueName = "SQS_QUEUE_NAME";

    $client = new SqsClient([
        'profile' => 'default',
        'region' => 'ap-northeast-1',
        'version' => '2012-11-05'
    ]);

    try {
        $result = $client->createQueue(array(
            'QueueName' => $queueName,
            'Attributes' => array(
                'DelaySeconds' => 5,
                'MaximumMessageSize' => 4096, // 4 KB
            ),
        ));
        var_dump($result);
    } catch (AwsException $e) {
        // output error message if fails
        error_log($e->getMessage());
    }

}
