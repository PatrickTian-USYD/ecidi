<?php
header("content-type:text/html; charset=utf-8");
include("PubApi.php");
include("DatatableConn.php");



$data = $_POST['mydate'];
//print_r($data);
//$count_json = count($data);
//echo $count_json;
$method = $data[0]['method'];
ITMSWriteLog("Debug","FunApi","method:".$method);
$con=CreatDatabaseConn();
switch ($method)
{
    case "pub_getequipmentclass":
        //echo "{".'"returndata"'.":".pub_getequipmentclass($con)."}";
        echo pub_getequipmentclass($con);
        break;
    case "pub_getequipmenttype":
        $classvalue = $data[0]['classvalue'];
        echo pub_getequipmenttype($con,$classvalue);
        break;
    case "pub_getequipmentbrand":
            echo pub_getequipmentbrand($con);
            break;
    case "pub_getequipmentmodle":
            $brandpkid = $data[0]['brandpkid'];
            $typevalue = $data[0]['typevalue'];
            echo pub_getequipmentmodle($con,$typevalue,$brandpkid);
            break;
    case "pub_getequipmentmodlebytypename":
            $brandpkid = $data[0]['brandpkid'];
            $typevalue = $data[0]['typevalue'];
            $classvalue = $data[0]['classvalue'];
            echo pub_getequipmentmodlebytypename($con,$typevalue,$brandpkid,$classvalue);
            break;
    case "pub_getosversion":
            $osclass = $data[0]['osclass'];
            echo pub_getosversion($con,$osclass);
            break;            
    case "pub_getequipmentclassmodel":
            $oid = $data[0]['oid'];
            $descr = $data[0]['descr'];
            $discoveryHostPkid = $data[0]['discoveryHostPkid'];
            echo pub_getequipmentclassmodel($con,$oid,$descr,$discoveryHostPkid);
            break;            
    case "pub_getAuthid":
            $username = $data[0]['username'];
            $password = $data[0]['password'];
            echo pub_getAuthid($con,$username,$password);
            break;
    case "pub_Logout":
            echo pub_Logout();
            break;            
    default:
        break;
}
class enumData
{
    public $id ;
    public $name ;
}


class classModel
{
    public $EquipModel_Pkid;
    public $EquipModel_Value;
    public $EquipModel_ClassValue;
    public $EquipModel_TypeValue;
    public $EquipModel_CompanyPkid;
    public $EquipModel_Key;
    public $EquipModel_Series;
    
    public $OSSystem_Pkid;
    public $OSSystem_Version;
    public $OSSystem_Name;
    public $OSSystem_Class;
    public $OSSystem_Key;    
}

function pub_getequipmentclass($con)
{
    //$sql="update ITMS_EquipClass set  EquipClass_Name='服务器'  where EquipClass_value= '02'";
    //$queryresult=mysqli_query($con,$sql);
    $sql="select EquipClass_Value,EquipClass_Name from ITMS_EquipClass where isdelete is null or isdelete<>'1' order by EquipClass_Order";
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $data =array();
    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
        {
            $enumDataobj=new enumData();
            $enumDataobj->id=$row["EquipClass_Value"];
            $enumDataobj->name=$row["EquipClass_Name"];
            $data[]= $enumDataobj;
        }
    }
    return json_encode($data);
}

function pub_getequipmenttype($con,$classvalue)
{
    $sql="select EquipType_Value,EquipType_Name from ITMS_EquipType where EquipType_ClassValue='".$classvalue."' and ( isdelete is null or isdelete<>'1') order by EquipType_order";
    //return "[{'sql':'"+$sql+"'}]";
    
    
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $data =array();
    /*  
    $enumDataobj=new enumData();
    $enumDataobj->id="kk";
    $enumDataobj->name=$sql;
    $data[]= $enumDataobj;
    return json_encode($data);
    */
    
    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
        {
            $enumDataobj=new enumData();
            $enumDataobj->id=$row["EquipType_Value"];
            $enumDataobj->name=$row["EquipType_Name"];
            $data[]= $enumDataobj;
        }
    }
    return json_encode($data);
}

function pub_getequipmentbrand($con)
{
    //$sql="update ITMS_EquipClass set  EquipClass_Name='服务器'  where EquipClass_value= '02'";
    //$queryresult=mysqli_query($con,$sql);
    $sql="select EquipCompany_Pkid,EquipCompany_Brand from ITMS_EquipCompany where isdelete is null or isdelete<>'1' group by EquipCompany_Brand order by EquipCompany_Brand";
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $data =array();
    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
        {
            $enumDataobj=new enumData();
            $enumDataobj->id=$row["EquipCompany_Pkid"];
            $enumDataobj->name=$row["EquipCompany_Brand"];
            $data[]= $enumDataobj;
        }
    }
    return json_encode($data);
}
function pub_getequipmentmodle($con,$typevalue,$brandpkid)
{
    if($typevalue=="")
        $sql="select EquipModel_Pkid,EquipModel_Value from ITMS_EquipModel where EquipModel_CompanyPkid='".$brandpkid."' and ( isdelete is null or isdelete<>'1') order by EquipModel_Value";
    else
        $sql="select EquipModel_Pkid,EquipModel_Value from ITMS_EquipModel where EquipModel_TypeValue='".$typevalue."'  and EquipModel_CompanyPkid='".$brandpkid."' and ( isdelete is null or isdelete<>'1') order by EquipModel_Value";
    //return "[{'sql':'"+$sql+"'}]";
    
    
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $data =array();
    /*
     $enumDataobj=new enumData();
     $enumDataobj->id="kk";
     $enumDataobj->name=$sql;
     $data[]= $enumDataobj;
     return json_encode($data);
     */
    
    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
        {
            $enumDataobj=new enumData();
            $enumDataobj->id=$row["EquipModel_Pkid"];
            $enumDataobj->name=$row["EquipModel_Value"];
            $data[]= $enumDataobj;
        }
    }
    return json_encode($data);
}

function pub_getequipmentmodlebytypename($con,$typename,$brandpkid,$classvalue)
{
    $typevalue="";
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $data =array();
    
    $sql="select EquipType_Value from ITMS_EquipType where EquipType_Name='".$typename."' and EquipType_ClassValue='".$classvalue."'";
    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
        {
            $typevalue=$row["EquipType_Value"];
        }
    }
    
    if($typevalue=="")
        $sql="select EquipModel_Pkid,EquipModel_Value from ITMS_EquipModel where EquipModel_CompanyPkid='".$brandpkid."' and ( isdelete is null or isdelete<>'1') order by EquipModel_Value";
    else
        $sql="select EquipModel_Pkid,EquipModel_Value from ITMS_EquipModel where EquipModel_TypeValue='".$typevalue."'  and EquipModel_CompanyPkid='".$brandpkid."' and ( isdelete is null or isdelete<>'1') order by EquipModel_Value";
    //return "[{'sql':'"+$sql+"'}]";
    /*
     $enumDataobj=new enumData();
     $enumDataobj->id="kk";
     $enumDataobj->name=$sql;
     $data[]= $enumDataobj;
     return json_encode($data);
    */

    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
        {
            $enumDataobj=new enumData();
            $enumDataobj->id=$row["EquipModel_Pkid"];
            $enumDataobj->name=$row["EquipModel_Value"];
            $data[]= $enumDataobj;
        }
    }
    return json_encode($data);
}

function pub_getosversion($con,$osclass)
{
    $sql="select OSSystem_Pkid,OSSystem_Version from ITMS_OSSystem where OSSystem_Class='".$osclass."' and ( isdelete is null or isdelete<>'1') order by OSSystem_Version";
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $data =array();
    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
        {
            $enumDataobj=new enumData();
            $enumDataobj->id=$row["OSSystem_Pkid"];
            $enumDataobj->name=$row["OSSystem_Version"];
            $data[]= $enumDataobj;
        }
    }
    return json_encode($data);
}
function pub_getequipmentclassmodel($con,$oid,$descr,$discoveryHostPkid)
{
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $datas=array();
    $data =new classModel();
    if($oid=="")
        return json_encode($datas);

    $data->EquipModel_Pkid="";
    $data->EquipModel_Value="";
    $data->EquipModel_ClassValue="";
    $data->EquipModel_TypeValue="";
    $data->EquipModel_CompanyPkid="";
    $data->EquipModel_Key="";
    $data->EquipModel_Series="";

    $data->OSSystem_Pkid="";
    $data->OSSystem_Version="";
    $data->OSSystem_Name="";
    $data->OSSystem_Class="";
    $data->OSSystem_Key="";

    /*
     $enumDataobj=new enumData();
     $enumDataobj->id="kk";
     $enumDataobj->name=$sql;
     $data[]= $enumDataobj;
     return json_encode($data);
    */
    $sql="select EquipModel_Pkid,EquipModel_Value,EquipModel_ClassValue,EquipModel_TypeValue,EquipModel_CompanyPkid,EquipModel_Key,EquipModel_Series from ITMS_EquipModel where EquipModel_SysObjectID='".$oid."'  and ( isdelete is null or isdelete<>'1') order by EquipModel_Value";
    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
        {
            $data->EquipModel_Pkid=$row["EquipModel_Pkid"];
            $data->EquipModel_Value=$row["EquipModel_Value"];
            $data->EquipModel_ClassValue=$row["EquipModel_ClassValue"];
            $data->EquipModel_TypeValue=$row["EquipModel_TypeValue"];
            $data->EquipModel_CompanyPkid=$row["EquipModel_CompanyPkid"];
            $data->EquipModel_Key=$row["EquipModel_Key"];
            $data->EquipModel_Series=$row["EquipModel_Series"];
        }
    }
    else
    {
        $sql="select DiscoveryHost_Hostid from ITMS_DiscoveryHost where DiscoveryHost_Pkid='".$discoveryHostPkid."'";
        error_log("\r\n查找设备编号：".$sql."\n", 3, 'd:\phplog.txt');
        $queryresult=mysqli_query($con,$sql);
        if(mysqli_num_rows($queryresult) ==1)
        {
            $row=mysqli_fetch_row($queryresult);
            $sql="select Equipment_ClassValue,Equipment_TypeValue,Equipment_CompanyBrand,Equipment_Model from ITMS_Equipment where Equipment_Pkid='".$row[0]."'";
            error_log("\r\n查找设备分类型号：".$sql."\n", 3, 'd:\phplog.txt');
            $queryresult=mysqli_query($con,$sql);
            if(mysqli_num_rows($queryresult) ==1)
            {
                $row=mysqli_fetch_row($queryresult);
                $data->EquipModel_ClassValue=$row[0];
                $data->EquipModel_TypeValue=$row[1];
                $data->EquipModel_Pkid=$row[3];
                $data->EquipModel_CompanyPkid=$row[2];
            }

        }

    }
    
    
    $sql="select OSSystem_Pkid,OSSystem_Version,OSSystem_Name,OSSystem_Class,OSSystem_Key from ITMS_OSSystem where OSSystem_ObjectID='".$oid."'  and ( isdelete is null or isdelete<>'1') order by OSSystem_Class,OSSystem_Version";
    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        $tempKey="";
        $findFlag=false;
        error_log($descr."\n", 3, 'd:\phplog.txt');
        while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
        {
            if($findFlag)
                break;
            $tempKey=$row["OSSystem_Key"];
            $arr = explode(";",$tempKey);
            foreach($arr as $subKey){
                error_log("subKey:".$subKey."\r\n", 3, 'd:\phplog.txt');
                 if(strpos($descr,$subKey)==true)
                 {
                     $findFlag=true;
                     $data->OSSystem_Pkid=$row["OSSystem_Pkid"];
                     $data->OSSystem_Version=$row["OSSystem_Version"];
                     $data->OSSystem_Name=$row["OSSystem_Name"];
                     $data->OSSystem_Class=$row["OSSystem_Class"];
                     $data->OSSystem_Key=$row["OSSystem_Key"];
                     break;
                 }
            }
        }
    }   
    $datas[]=$data;
    return json_encode($datas);
}
function pub_getAuthid($con,$username,$password)
{
    $Jsonrpc_Status="0";
    $Jsonrpc_Code="-1";
    $Jsonrpc_Result="";
    //$user = 'Admin';
    //$password = 'zabbix';
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    $sql="select User_Pkid,User_FullName from ITMS_User where User_UserName='".$username."' and User_Password='".$password."'";
    ITMSWriteLog("Debug","FunApi","Check User Infor:".$sql);
    $queryresult=mysqli_query($con,$sql);
    if(mysqli_num_rows($queryresult) >0)
    {
        $row=mysqli_fetch_array($queryresult);
        //global $UserName;
        //global $FullName;
        $UserName=$username;
        $FullName=$row["User_FullName"];
        session_start();
        $_SESSION["UserName"]=$UserName; 
        $_SESSION["FullName"]=$FullName;
        
        $Jsonrpc_Status="1";
        $Jsonrpc_Code=$FullName;
    }
    else 
    {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
    }


    $resultarray=array("status" => $Jsonrpc_Status,
        "code" => $Jsonrpc_Code,
        "result" => $Jsonrpc_Result
    );
    return json_encode($resultarray);
}

function pub_Logout()
{
    $Jsonrpc_Status="0";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";

    try {
        session_start();
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        $Jsonrpc_Status="1";
    }catch (Exception $ex)
    {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
    }
    $resultarray=array("status" => $Jsonrpc_Status,
        "code" => $Jsonrpc_Code,
        "result" => $Jsonrpc_Result
    );
    return json_encode($resultarray);
}

function pub_getAuthid2($username,$password)
{
    $Jsonrpc_Status="0";
    $Jsonrpc_Code="-1";
    $Jsonrpc_Result="";
    //$user = 'Admin';
    //$password = 'zabbix';
    $logininfo = array(
        'jsonrpc' => '2.0',
        'method' => 'user.login',
        'params' => array(
            'user' => $username,
            'password' => $password,
            'userData' => true
        ),
        'id' => 1,
    );
    $data = json_encode($logininfo);
    $result = ITMSJsonrpc($data);
    
    if($result=="")
    {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
        
        //print_r("Exception");
    }
    else
    {
        if(array_key_exists("result", $result))
        {
            $Jsonrpc_Status="1";
            $Jsonrpc_Code=$result->result->name;
            //session_start();
            //$_SESSION["sessionid"] = 1;
            //$GLOBALS['sessionid']=$result->result->sessionid;
            $Jsonrpc_Result=$result->result->sessionid;
        }
        else
        {
            //print_r($result->error);
            $Jsonrpc_Status="0";
            $Jsonrpc_Code=$result->error->code;
            //$Jsonrpc_Result=$result->result;
        }
    }
    
    $resultarray=array("status" => $Jsonrpc_Status,
        "code" => $Jsonrpc_Code,
        "result" => $Jsonrpc_Result
    );
    return json_encode($resultarray);
}
?>