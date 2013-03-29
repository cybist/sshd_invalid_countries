#!/usr/bin/php
<?php
/**
 * Password - パスワードの強度測定クラス
 * <pre>
 * パスワード文字列を引数にとり、『強中弱』のいずれかの一文字を返す
 * </pre>
 * @author cybist
 * @see https://codeiq.jp/challenge.php?challenge_id=235
 */
Class Password
{
    /** パスワード最低文字長 (n以上なら評価) */
    const MIN_LENGTH  = 4;
    /** パスワード安全文字長 (n以上なら評価) */
    const SAFE_LENGTH = 8;

    /** 「弱」評価ポイント (n以上NORMAL_LEVEL未満なら評価) */
    const WEAK_LEVEL   = 0;
    /** 「中」評価ポイント (n以上STRONG_LEVEL未満なら評価) */
    const NORMAL_LEVEL = 3;
    /** 「強」評価ポイント (n以上なら評価) */
    const STRONG_LEVEL = 6;


    /**
     * check - パスワードの強度測定I/F
     * @param String $password
     * @return String (弱|中|強)
     */
    public function check($password = '') {
        $points = 0;

        $points += $this->getPointLength(strlen($password));
        $points += $this->getPointConbination($password);

        $result = $this->convert($points);
        return $result;
    }


    /** パスワードの文字長から強度を判定 */
    protected function getPointLength($length) {
        $points = 0;

        // self::MIN_LENGTH 以上なら1ポイント加算
        $length >= self::MIN_LENGTH  and $points ++;
        // self::SAFE_LENGTH 以上なら1ポイント加算
        $length >= self::SAFE_LENGTH and $points ++;

        return $points;
    }


    /** パスワードの文字列から強度を判定 */
    protected function getPointConbination($password) {
        $points = 0;

        // 数字が含まれていれば1ポイント加算
        preg_match('/[0-9]+/',  $password, $matches) and $points ++;
        // 半角英語(小文字)が含まれていれば1ポイント加算
        preg_match('/[a-z]+/',  $password, $matches) and $points ++;
        // 半角英語(大文字)が含まれていれば1ポイント加算
        preg_match('/[A-Z]+/',  $password, $matches) and $points ++;
        // それ以外(記号等)が含まれていれば1ポイント加算
        preg_match('/(\W|_)+/', $password, $matches) and $points ++;

        return $points;
    }


    /** 強度に関する評価ポイントから『強中弱』に変換 */
    protected function convert($points) {
        if ($points >= self::STRONG_LEVEL) {
            // self::STRONG_LEVEL 以上なら、評価「強」
            return '強';
        }
        if ($points >= self::NORMAL_LEVEL) {
            // self::NORMAL_LEVEL 以上なら、評価「中」
            return '中';
        }
        if ($points >= self::WEAK_LEVEL) {
            // self::WEAK_LEVEL 以上なら、評価「弱」
            return '弱';
        }
    }
}


// 実処理
isset($argv[1]) or die("set arg password\n");

$Pw = new Password();
echo $Pw->check($argv[1]) . "\n";
