<?php
function gbToUtf8($str)
{
    return iconv('GB2312', 'UTF-8', $str);
}

function requestPage($target_url, $post_data = array(), $header = array())
{
    $cp = curl_init();

    curl_setopt($cp, CURLOPT_URL, $target_url);
    curl_setopt($cp, CURLOPT_HEADER, false);
    curl_setopt($cp, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cp, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36');

    if (!empty($post_data)) {
        curl_setopt($cp, CURLOPT_POST, true);
        curl_setopt($cp, CURLOPT_POSTFIELDS, $post_data);
    }

    if (!empty($header)) {
        curl_setopt($cp, CURLOPT_HTTPHEADER, $header);
    }

    curl_setopt($cp, CURLOPT_TIMEOUT, 10);

    $page = curl_exec($cp);

    $http_code = curl_getinfo($cp, CURLINFO_HTTP_CODE);

    curl_close($cp);

    if (in_array(substr($http_code, 0, 1), array(2, 3))) {
        return $page;
    } else {
        return false;
    }
}

function reindexArr($arr, $key)
{
    $res = array();

    foreach ($arr as $row) {
        $res[$row[$key]] = $row;
    }

    return $res;
}
