<?php
/**
 * 返回可读性更好的文件尺寸
 *
 */
function human_filesize($bytes, $decimals = 2) {
    $size = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) -1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)). @$size[$factor];
}

/**
 * 判断文件的MIME类型是否是图片
 *
 */
function is_image($mimeType) {
    return starts_with($mimeType, 'image/');
}

function checked($value) {
    return $value ? 'checked' : '';
}

/**
 * Return img url for headers
 * @param null $value
 */
function page_image($value = null) {
    if(empty($value)) {
        $value = config('blog.page_image');
    }
    if(!starts_with($value, 'http') && $value[0] !== '/') {
        $value = config('blog.uploads.webpath') . '/' . $value;
    }

    return $value;
}

function msubstr($str, $start=0, $len=30, $charset='utf-8') {
    return mb_substr($str, $start, $len, $charset);
}