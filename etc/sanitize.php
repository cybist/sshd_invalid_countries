<?php
/**
 * sanitize - 再帰型サニタイズ関数
 *
 * <pre>
 * 第１引数に与えた配列の値から、特定のメタ文字を削除します。
 * 第２引数にtrueを付与すると、ヌルバイトのみ削除します。
 *
 * 使用例:
 *   //基本形
 *     $_GET = sanitize($_GET);
 *
 *   //一括処理
 *     list($_POST, $_GET, $_SESSION) = array_map('sanitize', array($_POST, $_GET, $_SESSION));
 *
 *   //テキストエリア
 *     $_POST['textarea'] = sanitize($_POST['textarea'], true);
 * </pre>
 *
 * @author cybist
 * @param array   ユーザー由来の動的パラメータ
 * @param boolean テキストエリアか否か。デフォルトはテキストエリア以外でfalse
 * @return array  サニタイズ後のパラメータ
 */

function sanitize($params, $is_textarea = false) {
    $is_arr = is_array($params);
    $is_arr or $params = (array)$params;

    $dirts = $is_textarea ? array("\0") : array("\0", "\t", "\r", "\n");
    array_walk_recursive($params, function(&$item) use ($dirts) {
        $item = str_replace($dirts, '', $item);
    });

    $is_arr or $params = array_pop($params);
    return $params;
}
