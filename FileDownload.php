<?php
/**
 * Created by PhpStorm.
 * User: jinchunguang
 * Date: 20-1-10
 * Time: 下午3:41
 */

class FileDownload {

    /**
     * http下载文件
     *
     * Reads a file and send a header to force download it.
     *
     * @access public
     *
     * @param string $filePath 文件路径
     * @param string $rename 文件重命名后的名称
     *
     * @return void
     */
    public static function getData($filePath, $rename = null) {

        //参数分析
        if(!$filePath) {
            return false;
        }

        if(headers_sent()) {
            return false;
        }

        //分析文件是否存在
        if (!is_file($filePath)) {
            Response::showMsg('Error 404:The file not found!');
        }

        //分析文件名
        $fileName = (!$rename) ? basename($filePath) : $rename;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=\"{$fileName}\"");
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        ob_clean();
        flush();

        readfile($filePath);

        exit();
    }
}