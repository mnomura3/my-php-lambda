<?php

/**
 * Class Test
 *
 * AWS Lambda上でphpを使用してJsonをResponseできるか確認
 */
class Test {
    private $memo = [];
    /**
     * @param $n
     * @return int
     */
    public function fib($n) {
        global $memo;
        if ($n == 0) {
            return 0;
        } else if ($n == 1) {
            return 1;
        }

        if(isset($memo[$n])) {
            return $memo[$n];
        }

        // 再帰
        return $memo[$n] = self::fib($n-1) + self::fib($n-2);
    }
}

for ($i = 0; $i <= 10; $i++) {
    $fib[] = Test::fib($i);
}

$json = json_encode($fib, JSON_UNESCAPED_UNICODE);
echo $json;



