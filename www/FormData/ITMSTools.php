<?php
header("content-type:text/html; charset=utf-8");

function GetmaskByMarkLen($markLen)
{
    try {
        $mark = 0xFFFFFFFF << (32 - $markLen) & 0xFFFFFFFF;
        return  long2ip($mark);
    } catch (Exception $e) {
        return null;
    }
}

function  GetStartEndIpAddress($netIpAddr,$markLen)
{
    try {
         $ip = ip2long($netIpAddr);
         $mark = 0xFFFFFFFF << (32 - $markLen) & 0xFFFFFFFF;
         $ip_start = $ip & $mark;
         $ip_end = $ip | (~$mark) & 0xFFFFFFFF;
         return array(long2ip($ip_start), long2ip($ip_end));

    } catch (Exception $e) {
        return null;
    }
}
function JudgeIpInSegment($ipAddress,$netIpAddr,$markLen)
{
    try {
        $right_len = 32 - $markLen;
        return ip2long($ipAddress) >> $right_len == ip2long($netIpAddr) >> $right_len;
    } catch (Exception $e) {
        return null;
    }
}

function GetNumberByIpAddress($ipAddress)
{
    try {
        return bindec( decbin( ip2long( $ipAddress ) ) );
    } catch (Exception $e) {
        return null;
    }
}
//number bindec ( string $binary_string ); //二进制转换为十进制
//string decbin ( int $number ); //十进制转换为二进制

?>