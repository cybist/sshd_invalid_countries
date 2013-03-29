#!/usr/bin/php
<?php
/**
 * DefaultPassword - ランダムパスワードの生成クラス
 * <pre>
 * 「英大文字」「英小文字」「数字」「記号」の半角文字種別のうち
 * n種類以上の文字種別を使ってランダムな文字列を生成する
 * </pre>
 * @author cybist
 * @see https://codeiq.jp/challenge.php?challenge_id=234
 */
Class DefaultPassword {

    /** 何種類の文字種別の組み合わせを最低条件とするか */
    protected $lowest_combo_cnt = 3;

    /** 生成するパスワードの最小文字数 */
    protected $min_length = 12;

    /** 生成するパスワードの最大文字数 */
    protected $max_length = 16;

    /** 英大文字セット */
    protected $upper_alphas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /** 英小文字セット */
    protected $lower_alphas = 'abcdefghijklmnopqrstuvwxyz';

    /** 数字セット */
    protected $numbers = '0123456789';

    /** 記号セット */
    protected $marks = '!"#$%&\'()';

    /**
     * パスワード生成I/F
     * @param void
     * @return String
     */
    public function generate() {
        // 生成したパスワードがバリデーションを通過するまで生成を繰り返します
        while (!isset($password) or !$this->validate($password)) {
            $length = mt_rand($this->min_length, $this->max_length);

            $password = str_shuffle(
                $this->upper_alphas .
                $this->lower_alphas .
                $this->numbers .
                $this->marks
            );
            $password = substr($password, 0, $length);
        }
        return $password;
    }

    /**
     * パスワードのバリデーション用I/F
     * @param String $password
     * @return Boolean
     */
    public function validate($password) {
        $combo_cnt = 0;
        // パスワードがそれぞれの文字セットを含む度にカウントアップします
        $combo_cnt += intval(preg_match("/[{$this->upper_alphas}]/", $password));
        $combo_cnt += intval(preg_match("/[{$this->lower_alphas}]/", $password));
        $combo_cnt += intval(preg_match("/[{$this->numbers}]/",      $password));
        $combo_cnt += intval(preg_match("/[{$this->marks}]/",        $password));

        return $combo_cnt >= $this->lowest_combo_cnt;
    }

    /** 文字種別の組み合わせ最低条件の変更用I/F */
    public function setLowestComboCnt($cnt) {
        $this->lowest_combo_cnt = $cnt;
        return $this;
    }

    /** パスワード最小文字数の変更用I/F */
    public function setMinLength($length) {
        $this->min_length = $length;
        return $this;
    }

    /** パスワード最大文字数の変更用I/F */
    public function setMaxLength($length) {
        $this->max_length = $length;
        return $this;
    }

    /** 英大文字セットの変更用I/F */
    public function setUpperAlphas($words) {
        $this->upper_alphas = $words;
        return $this;
    }

    /** 英小文字セットの変更用I/F */
    public function setLowerAlphas($words) {
        $this->lower_alphas = $words;
        return $this;
    }

    /** 数字セットの変更用I/F */
    public function setNumbers($words) {
        $this->numbers = $words;
        return $this;
    }

    /** 記号セットの変更用I/F */
    public function setMarks($words) {
        $this->marks = $words;
        return $this;
    }
}

// 実処理
$DefaultPassword = new DefaultPassword();
$password = $DefaultPassword->generate();
var_dump($password, $DefaultPassword->validate($password));
