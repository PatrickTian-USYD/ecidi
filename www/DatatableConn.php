<?php
//$serverIPAddress="172.29.16.11";
//$serverIPAddress="192.168.128.134";
date_default_timezone_set('prc');
function CreatDatabaseConn(){
    $serverIPAddress="10.215.138.43";
    //$serverIPAddress="192.168.188.128";
    try 
    {
        $conn = mysqli_connect($serverIPAddress,"ITMS","ecidiecidi99","zabbix");
        mysqli_query($conn,"SET character_set_client = 'utf8'");
        mysqli_query($conn,"SET character_set_results = 'utf8'");
        mysqli_query($conn,"SET character_set_connection = 'utf8'");
        return $conn;
    }
    catch(Exception $e)
    {
        return "";
    }
}


//jquer序列化的表单数据转换成关联数组
function FormdataToRelationArray($formdata)
{
        $RelationArray="";
        $formdataArray= explode("&",$formdata);
        foreach ($formdataArray as $params){
            $paramsArray = explode("=",$params);
            //$temp=$paramsArray[0];
            $RelationArray[$paramsArray[0]] =$paramsArray[1];
        }
        return $RelationArray;
    
}

function GetGUID($prefix)
{
    $t_temp="";
    $t_temp = $prefix.date("Y").sprintf("%02d", date("m")).sprintf("%02d", date("d")).sprintf("%02d", date("h")).sprintf("%02d", date("i")).sprintf("%02d", date("sa")).rand(100,999);    
    return $t_temp;

}

?>