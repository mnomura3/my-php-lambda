<?php

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
}
// エラーをSQSへqueメッセージをSlack通知
// todo ↓へ管理者へ通知その処理



