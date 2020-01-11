<?php

require 'vendor/autoload.php';
date_default_timezone_set('Asia/Tokyo');

use Aws\Sdk;
use Aws\DynamoDb\Marshaler;
use Aws\DynamoDb\Exception\DynamoDbException;

$sdk = new Sdk([
    'region'   => 'ap-northeast-1',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'lambda_test_table';
$user_id = $_GET["user_id"];

$key = $marshaler->marshalJson('{
        "user_id": "' . $user_id . '"
    }
');

$params = [
    'TableName' => $tableName,
    'Key' => $key
];

try {
    $result = $dynamodb->getItem($params);
    print_r($result["Item"]);

} catch (DynamoDbException $e) {
    echo "Unable to get item:\n";
    echo $e->getMessage() . "\n";
}