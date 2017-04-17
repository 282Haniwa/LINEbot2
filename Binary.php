<?php
class Binary
{
    //画像ファイルの作成
    public static function save ($binary, $directory, $name)
    {
        $fp = fopen($directory . $name, 'wb');
        if ($fp){
            if (flock ($fp, LOCK_EX)){
                if (fwrite($fp,  $binary) === FALSE){
                    $result = 'ファイル書き込みに失敗しました';
                }else{
                    $result = $name . 'をファイルに書き込みました';
                }

                flock($fp, LOCK_UN);
            }else{
                $result = 'ファイルロックに失敗しました';
            }
        }
        fclose($fp);
        return $result;
    }
}
?>
