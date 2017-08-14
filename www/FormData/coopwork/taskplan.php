<?php
header("content-type:text/html; charset=utf-8");
include("../../DatatableConn.php");
include("../../PubApi.php");
include("../ITMSTools.php");
require_once '../PHPExcel/PHPExcel.php';
require_once '../PHPExcel/PHPExcel/IOFactory.php';
require_once '../PHPExcel/PHPExcel/Reader/Excel5.php';

$data = $_POST['mydate'];

//$count_json = count($data);
//echo $count_json;
//error_log(print_r($data), 3, 'd:\phplog.txt');
$method = $data[0]['method'];
$datatype = $data[0]['datatype'];
$formdata = $data[0]['formdata'];

//error_log($method, 3, 'd:\phplog.txt');
//error_log($datatype, 3, 'd:\phplog.txt');
//error_log($formdata, 3, 'd:\phplog.txt');
//$method="import_iptaskplan";
//$formdata="";
switch ($method)
{
    case "add_taskplan":
        echo add_taskplan($formdata);
        break;
    case "mod_taskplan":
        echo mod_taskplan($formdata);
        break;   
    case "mod_PSRelation":
        $parentpkid = $data[0]['parentpkid'];
        echo mod_PSRelation($formdata,$parentpkid);
        break;        
    case "del_taskplan":
        echo del_taskplan($formdata);
        break;
    case "get_taskplan":
        echo get_taskplan($formdata);
        break;
    case "import_taskplan":
        echo import_taskplan($formdata);
        break;        
    case "import_ippart":        
        echo import_ippart($formdata);
        break;
    case "import_ipaddress":        
        echo import_ipaddress($formdata);
        break;        
    case "discovery_iptaskplan":
        echo discovery_iptaskplan($formdata);
        break;
    case "rebuild_iptaskplantree":
        echo rebuild_iptaskplantree($formdata);
        break;        
    case "Get_Pregress":
        echo Get_Pregress($formdata);
        break;
    case "cancelaction_discovery":
        echo cancelaction_discovery($formdata);
        break;
    case "get_discoveryequipment":
        echo get_discoveryequipment($formdata);
        break;        
    default:
        echo "default";
        break;
}

function add_taskplan($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();
    //error_log($formdata, 3, 'd:\phplog.txt');
    //表单反序列化
    $RelationArray=FormdataToRelationArray($formdata);
    //error_log("$RelationArray", 3, 'd:\phplog.txt');
    
    try {
        $Pkid=GetGUID('Task');
        $currentdate=date('Y-m-d H:i:s');

        $sql="insert into ITMS_Task (Task_Pkid,Task_Name,Task_Class,Task_Grade,Task_Stage,Task_StartDate,Task_DutyUserA,Task_DutyUserB,Task_CreateDate,Task_LastChangeDate,Task_Remark) values ";
        $sql = $sql." ('".$Pkid."','".$RelationArray['taskname']."','".$RelationArray['taskclass']."','".$RelationArray['taskgrade']."','".$RelationArray['taskstage']."','".$RelationArray['taskstartdate']."','".$RelationArray['taskdutyusera']."','".$RelationArray['taskdutyuserb']."','".$currentdate."','".$currentdate."','".$RelationArray['remark']."')";
        
        ITMSWriteLog("Debug","coopwork->taskplan->add_taskplan","Insert SQL:".$sql);
        
        $queryresult=mysqli_query($con,$sql);
        
        
        $Jsonrpc_Status=1;
        $Jsonrpc_Result=$Pkid;
        mysqli_close($con);


        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_add_taskplan";
        //$Jsonrpc_Result=$err->getMessage();
        ITMSWriteLog("Fatal","coopwork->taskplan->add_taskplan","Exception:".$err->getMessage());

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);

    }

}
function getTaskPkid($SelectedPkid)
{
    $typeValueArr=explode("-", $SelectedPkid);
    if(count($typeValueArr)==2)
    {
       return $typeValueArr[1];
    }
    return "";
}

function mod_taskplan($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();
    //error_log($formdata, 3, 'd:\phplog.txt');
    //表单反序列化
    $RelationArray=FormdataToRelationArray($formdata);
    //error_log("$RelationArray", 3, 'd:\phplog.txt');
    $pkid = getTaskPkid($RelationArray['selectedrowpkid']);

    
    try {
        $OldParentPkid="";

        $currentdate=date('Y-m-d H:i:s');

        $sql="update ITMS_Task set Task_Name='".$RelationArray['taskname'].
        "',Task_Class='".$RelationArray['taskclass'].
        "',Task_Grade='".$RelationArray['taskgrade'].
        "',Task_Stage='".$RelationArray['taskstage'].
        "',Task_StartDate='".$RelationArray['taskstartdate'].
        "',Task_DutyUserA='".$RelationArray['taskdutyusera'].
        "',Task_DutyUserB='".$RelationArray['taskdutyuserb'].        
        "',Task_Remark='".$RelationArray['remark'].
        "' where Task_Pkid='".$pkid."'";
    
        ITMSWriteLog("Debug","coopwork->taskplan->mod_taskplan","Update SQL:".$sql);
        $queryresult=mysqli_query($con,$sql);
        
        if($queryresult!=false)
        {
            $Jsonrpc_Status=1;
            $Jsonrpc_Result=$pkid;
        }
    

        
        mysqli_close($con);
    
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_mod_taskplan";
        //$Jsonrpc_Result=$err->getMessage();
        ITMSWriteLog("Fatal","coopwork->taskplan->mod_taskplan","Exception:".$err->getMessage());
    
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    
    }
}

function SetPSRelationFlag($con,$OpType,$ParentPkid)
{
    try 
    {
        $ResultStat=false;
        
        if($ParentPkid=="")
            return true;
        
        if($OpType=="Add")
        {
   
            $sql="update ITMS_taskplan set taskplan_HaveSubFlag='1'".
                ",taskplan_CreatePSRelationFlag='1'".
                " where taskplan_Pkid='".$ParentPkid."'";
            ITMSWriteLog("Debug","resources->iptaskplan->SetPSRelationFlag","Update SQL:".$sql);
            $queryresult=mysqli_query($con,$sql);
            if($queryresult!=false)
                $ResultStat=true;
        }
        
        if($OpType=="Del")
        {
            $sql="select taskplan_Pkid from ITMS_taskplan where taskplan_ParentPkid='".$ParentPkid."'";
            ITMSWriteLog("Debug","resources->iptaskplan->SetPSRelationFlag","Select SQL:".$sql);
            $queryresult=mysqli_query($con,$sql);
            $rowcount=mysqli_num_rows($queryresult);
            if($queryresult!=false && mysqli_num_rows($queryresult)==0)
            {
                $sql="update ITMS_taskplan set taskplan_HaveSubFlag='0'".
                    "',taskplan_CreatePSRelationFlag='1'".
                    "' where taskplan_Pkid='".$ParentPkid."'";
                ITMSWriteLog("Debug","resources->iptaskplan->SetPSRelationFlag","Update SQL:".$sql);
                $queryresult=mysqli_query($con,$sql);
                if($queryresult!=false)
                    $ResultStat=true;
            }
        }
        
        return  $ResultStat;
    }
    catch (Exception $err)
    {
        ITMSWriteLog("Fatal","resources->iptaskplan->SetPSRelationFlag","Exception:".$err->getMessage());
        return false;
    }  
}


function mod_PSRelation($formdata,$parentpkid)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="Unknow";
    $con=CreatDatabaseConn();

    $pkid = $formdata;


    try {
        $Pkid=GetGUID('Account');
        $currentdate=date('Y-m-d H:i:s');

        $sql="select taskplan_ParentPkid from ITMS_taskplan where taskplan_Pkid='".$pkid."'";
        ITMSWriteLog("Debug","resources->iptaskplan->mod_PSRelation","Select SQL:".$sql);
        $queryresult=mysqli_query($con,$sql);
        
        if($queryresult!=false && mysqli_num_rows($queryresult)==1)
        {
            $row=mysqli_fetch_array($queryresult);
            $OldParentPkid=$row[0];
        }
        
        $sql="update ITMS_taskplan set taskplan_ParentPkid='".$parentpkid.
        "' where taskplan_Pkid='".$pkid."'";

        ITMSWriteLog("Debug","resources->iptaskplan->mod_PSRelation","Update SQL:".$sql);
        $queryresult=mysqli_query($con,$sql);

        
        if($queryresult!=false)
        {
            if($OldParentPkid!=$parentpkid)
            {
                SetPSRelationFlag($con,"Add",$parentpkid);
                SetPSRelationFlag($con,"Del",$OldParentPkid);
            }

        }
        
        if($queryresult!=false)
        {
            $Jsonrpc_Status="1";
            $Jsonrpc_Result="Success";
        }
        
        mysqli_close($con);

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_mod_PSRelation";
        //$Jsonrpc_Result=$err->getMessage();
        ITMSWriteLog("Fatal","resources->iptaskplan->mod_PSRelation","Exception:".$err->getMessage());

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);

    }
}

function del_taskplan($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();
    $pkid = getTaskPkid($formdata);

    try {

        $currentdate=date('Y-m-d h:i:s');
        

        $sql="delete from ITMS_Task where Task_Pkid='".$pkid."'";

        
        ITMSWriteLog("Debug","coopwork->taskplan->del_taskplan","Delete SQL:".$sql);
        $queryresult=mysqli_query($con,$sql);
        
        if($queryresult!=false)
        {
            $Jsonrpc_Status=1;
            $Jsonrpc_Result=$pkid;
        }
        mysqli_close($con);
    
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_del_taskplan";
        //$Jsonrpc_Result=$err->getMessage();
        ITMSWriteLog("Fatal","coopwork->taskplan->del_taskplan","Exception:".$err->getMessage());
    
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);    
    }
}


function get_taskplan($formdata)
{
    try {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
        $Jsonrpc_Result="";
        //表单反序列化
        $TaskPkid=$formdata;
        //先查询该设备是否已经存在
        $con=CreatDatabaseConn();
        $sql="select Task_Name,Task_Class,Task_Type,Task_Grade,Task_Stage,Task_StartDate,Task_DutyUserA,Task_DutyUserB,Task_Remark from ITMS_Task where Task_Pkid='".$TaskPkid."'";
        ITMSWriteLog("Debug","coopwork->taskplan->get_taskplan","Select SQL:".$sql);
        $queryresult=mysqli_query($con,$sql);
        $rowcount=mysqli_num_rows($queryresult);
        if($rowcount==1)
        {
            $Jsonrpc_Status="1";
            $Jsonrpc_Code=$TaskPkid;
            $Jsonrpc_Result=mysqli_fetch_array($queryresult);

        }
        else
        {
            ITMSWriteLog("Error","coopwork->taskplan->get_taskplan","Error Message:Non Record");
            $Jsonrpc_Code=$TaskPkid;
            $Jsonrpc_Result="Non Record";
        }

        mysqli_close($con);

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch(exception $err)
    {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
        $Jsonrpc_Result=$err->getMessage();

        ITMSWriteLog("Fatal","coopwork->taskplan->get_taskplan","Exception:".$err->getMessage());
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}
///////////////////////////////////////////////////////////////////////////////////
function import_taskplan($formdata)
{
    
    try {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
        $Jsonrpc_Result="";
        
        $Taskplan_Name="";
        $Taskplan_Class="";
        $Taskplan_Grade="";
        $Taskplan_Stage="";
        $Taskplan_Startdate="";
        $Taskplan_DutyA="";
        $Taskplan_DutyB="";
        $Taskplan_Remark="";
        
        ITMSWriteLog("Debug","coopwork->taskplan->import_taskplan","formdata:".$formdata);
        $RelationArray=FormdataToRelationArray($formdata);
        ITMSWriteLog("Debug","coopwork->taskplan->import_taskplan","FormdataToRelationArray Complete.");
        $SuccessCount=0;
        $overlap=0;
        $objReader = PHPExcel_IOFactory::createReader('Excel2007'); //use Excel5 for 2003 format
        $excelpath='../../style/assets/global/plugins/jquery-file-upload/server/php/files/';
        $excelpath=$excelpath.$RelationArray['FileServerName'];
        ITMSWriteLog("Debug","coopwork->taskplan->import_taskplan","File Path:".$excelpath);
        
        $objPHPExcel = $objReader->load($excelpath);        
        $sheet = $objPHPExcel->getSheet(0);        
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn();     //取得总列数
        
        if($highestColumn!="H")
        {
            $Jsonrpc_Status=0;
            $Jsonrpc_Result="Incorrect import file format";
        }
        else 
        {
            $con=CreatDatabaseConn();
            for($j=2;$j<=$highestRow;$j++)                        //从第二行开始读取数据
            {
            
                $Taskplan_Name=$objPHPExcel->getActiveSheet()->getCell("A$j")->getValue();
                $Taskplan_Class=$objPHPExcel->getActiveSheet()->getCell("B$j")->getValue();
                $Taskplan_Grade=$objPHPExcel->getActiveSheet()->getCell("C$j")->getValue();
                $Taskplan_Stage=$objPHPExcel->getActiveSheet()->getCell("D$j")->getValue();
                $Taskplan_Startdate=PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell("E$j")->getValue());
                $Taskplan_Startdate=gmdate("Y-m-d", $Taskplan_Startdate);
                $Taskplan_DutyA=$objPHPExcel->getActiveSheet()->getCell("F$j")->getValue();
                $Taskplan_DutyB=$objPHPExcel->getActiveSheet()->getCell("G$j")->getValue();
                $Taskplan_Remark=$objPHPExcel->getActiveSheet()->getCell("H$j")->getValue();
                
                $Pkid=GetGUID('taskplan').strval($j);
               
                $currentdate=date('Y-m-d H:i:s');
            
                ////////////////////////////////////////////////////////////////////////////////
                //判断是否有重复记录
                $sql="select Task_Pkid from ITMS_Task where Task_Name='".$Taskplan_Name."'";
                ITMSWriteLog("Debug","coopwork->taskplan->import_taskplan","Select SQL:".$sql);
                $queryresult=mysqli_query($con,$sql);
                if($queryresult!=false)
                {
                    if(mysqli_num_rows($queryresult)>0)
                    {
                        $row=mysqli_fetch_array($queryresult);


                        $sql="update ITMS_Task set Task_Name='".$Taskplan_Name."',";
                        $sql = $sql." Task_Class='".$Taskplan_Class."',";
                        $sql = $sql." Task_Grade='".$Taskplan_Grade."',";
                        $sql = $sql." Task_Stage='".$Taskplan_Stage."',";
                        $sql = $sql." Task_StartDate='".$Taskplan_Startdate."',";
                        $sql = $sql." Task_LastChangeDate='".$currentdate."',";
                        $sql = $sql." Task_DutyUserA='".$Taskplan_DutyA."'";
                        $sql = $sql." Task_DutyUserB='".$Taskplan_DutyB."'";
                        $sql = $sql." Task_Remark='".$Taskplan_Remark."'";
                        $sql = $sql." where Task_Pkid='".$row[0]."'";
                        ITMSWriteLog("Debug","coopwork->taskplan->import_taskplan","Update SQL:".$sql);
                        
                        $queryresult=mysqli_query($con,$sql);
                        
                        if($queryresult!=false)
                        {
                            $overlap++;
                        }
                    }
                    else 
                    {
                        ///////////////////////////////////////////////////////////////////////////////
                        //新增记录
                        $sql="insert into ITMS_Task (Task_Pkid,Task_Name,Task_Class,Task_Grade,Task_Stage,Task_StartDate,Task_DutyUserA,Task_DutyUserB,Task_CreateDate,Task_LastChangeDate,Task_Remark) values ";
                        $sql = $sql." ('".$Pkid."','".$Taskplan_Name."','".$Taskplan_Class."','".$Taskplan_Grade."','".$Taskplan_Stage."','".$Taskplan_Startdate."','".$Taskplan_DutyA."','".$Taskplan_DutyB."','".$currentdate."','".$currentdate."','".$Taskplan_Remark."')";
                        
                        ITMSWriteLog("Debug","coopwork->taskplan->import_taskplan","Insert SQL:".$sql);
                        
                        $queryresult=mysqli_query($con,$sql);
                        
                        if($queryresult!=false)
                        {
                            $SuccessCount++;
                        }
                    }
                    
                }
                
            }
            mysqli_close($con);

            $Jsonrpc_Status=1;
            $Jsonrpc_Code=$overlap;
            $Jsonrpc_Result=$SuccessCount;
        }
        
        
        unlink($excelpath);
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch(exception $err)
    {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
        $Jsonrpc_Result=$err->getMessage();

        ITMSWriteLog("Fatal","resources->iptaskplan->import_iptaskplan","Exception:".$err->getMessage());
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}

function  GetEquipPkidByName($con,$EquipName)
{
    $EquipPkid="";
    if($EquipName!="")
    {
        $sql="select Equipment_Pkid from ITMS_Equipment where Equipment_Name='".$EquipName."'";
        ITMSWriteLog("Debug","resources->iptaskplan->GetEquipPkidByName","Select Equipment Pkid SQL:".$sql);
        $queryresult=mysqli_query($con,$sql);
        if($queryresult!=false && mysqli_num_rows($queryresult)>0)
        {
            $row=mysqli_fetch_array($queryresult);
            $EquipPkid=$row[0];
        }
    }
    return $EquipPkid;
}

///////////////////////////////////////////////////////////////////////////////////
function import_ippart($formdata)
{
    try {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
        $Jsonrpc_Result="";
    
        $IPPart_Name="";
        $IPPart_BeginIp="";
        $IPPart_BeginIpNumber="";
        $IPPart_EndIp="";
        $IPPart_EndIpNumber="";
        $IPPart_Type="";
        $IPPart_Manager="";

    
        ITMSWriteLog("Debug","resources->iptaskplan->import_ippart","formdata:".$formdata);
        $RelationArray=FormdataToRelationArray($formdata);
    
        $SuccessCount=0;
        $overlap=0;
        $objReader = PHPExcel_IOFactory::createReader('excel2007'); //use Excel5 for 2003 format
        $excelpath='../../style/assets/global/plugins/jquery-file-upload/server/php/files/';
        $excelpath=$excelpath.$RelationArray['FileServerName'];
        ITMSWriteLog("Debug","resources->iptaskplan->import_ippart","File Path:".$excelpath);
    
        $objPHPExcel = $objReader->load($excelpath);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn();     //取得总列数
        ITMSWriteLog("Debug","resources->iptaskplan->import_ippart","highestColumn:".$highestColumn);
        if($highestColumn!="E")
        {
            $Jsonrpc_Status=0;
            $Jsonrpc_Result="Incorrect import file format";
        }
        else
        {
            $con=CreatDatabaseConn();
            for($j=2;$j<=$highestRow;$j++)                        //从第二行开始读取数据
            {
    
                $IPPart_Name=$objPHPExcel->getActiveSheet()->getCell("A$j")->getValue();
                $IPPart_BeginIp=$objPHPExcel->getActiveSheet()->getCell("B$j")->getValue();
                $IPPart_EndIp=$objPHPExcel->getActiveSheet()->getCell("C$j")->getValue();
                $IPPart_Type=$objPHPExcel->getActiveSheet()->getCell("D$j")->getValue();
                $IPPart_Manager=$objPHPExcel->getActiveSheet()->getCell("E$j")->getValue();
                
                if($IPPart_BeginIp=="")
                    continue;
                
                $IPPart_BeginIpNumber=GetNumberByIpAddress($IPPart_BeginIp);
                $IPPart_EndIpNumber=GetNumberByIpAddress($IPPart_EndIp);
                
                $Pkid=GetGUID('IPPart').strval($j);
                $currentdate=date('Y-m-d H:i:s');
                ////////////////////////////////////////////////////////////////////////////////
                //判断是否有重复记录
                $sql="select IPPart_Pkid from ITMS_IPPart where (IPPart_BeginIpNumber<='".$IPPart_BeginIpNumber."' and IPPart_EndIpNumber>='".$IPPart_BeginIpNumber."') or (IPPart_BeginIpNumber<='".$IPPart_EndIpNumber."' and IPPart_EndIpNumber>='".$IPPart_EndIpNumber."')";
                ITMSWriteLog("Debug","resources->iptaskplan->import_ippart","Select ippart Infor SQL:".$sql);
                $result=mysqli_query($con,$sql);
                
                if($result!=false)
                {
                    if(mysqli_num_rows($result)>0)
                    {
                        $overlap++;
                    }
                    else
                    {
                        $cmdSql="insert into ITMS_IPPart (IPPart_Pkid,IPPart_Name,IPPart_BeginIp,IPPart_BeginIpNumber,IPPart_EndIp,IPPart_EndIpNumber,IPPart_Type,IPPart_FullName,IPPart_CreateDate,IPPart_LastChangeDate) values ";
                        $cmdSql = $cmdSql." ('".$Pkid."','".$IPPart_Name."','".$IPPart_BeginIp."','".$IPPart_BeginIpNumber."','".$IPPart_EndIp."','".$IPPart_EndIpNumber."','".$IPPart_Type."','".$IPPart_Manager."','".$currentdate."','".$currentdate."')";
                        ITMSWriteLog("Debug","resources->iptaskplan->import_ippart","Save ippart Infor SQL:".$cmdSql);
                        $queryresult=mysqli_query($con,$cmdSql);
                        if($queryresult!=false)
                        {
                            $SuccessCount++;
                        }
                    }
                }
                else
                {
                    ITMSWriteLog("Error","resources->iptaskplan->import_ippart","Save ippart Infor Error.");
                }
            }
            mysqli_close($con);
    
            
    
            $Jsonrpc_Status=1;
            $Jsonrpc_Code=$overlap;
            $Jsonrpc_Result=$SuccessCount;
        }
        unlink($excelpath);
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch(exception $err)
    {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
        $Jsonrpc_Result=$err->getMessage();
    
        ITMSWriteLog("Fatal","resources->iptaskplan->import_ippart","Exception:".$err->getMessage());
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}
///////////////////////////////////////////////////////////////////////////////////
function import_ipaddress($formdata)
{
    try {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
        $Jsonrpc_Result="";
    
        $IPAddress="";
        $EquipmentName="";
        $EquipmentMac="";
        $IPAddressNumber="";
        $IPAddressType="";
        $IPAddressDate="";
    
        ITMSWriteLog("Debug","resources->iptaskplan->import_ipaddress","formdata:".$formdata);
        $RelationArray=FormdataToRelationArray($formdata);
    
        $SuccessCount=0;
        $overlap=0;
        $objReader = PHPExcel_IOFactory::createReader('excel2007'); //use Excel5 for 2003 format
        $excelpath='../../style/assets/global/plugins/jquery-file-upload/server/php/files/';
        $excelpath=$excelpath.$RelationArray['FileServerName'];
        ITMSWriteLog("Debug","resources->iptaskplan->import_ipaddress","File Path:".$excelpath);
    
        $objPHPExcel = $objReader->load($excelpath);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn();     //取得总列数
    
        if($highestColumn!="E")
        {
            $Jsonrpc_Status=0;
            $Jsonrpc_Result="Incorrect import file format";
        }
        else
        {
            $con=CreatDatabaseConn();
            for($j=2;$j<=$highestRow;$j++)                        //从第二行开始读取数据
            {
                $IPAddress=$objPHPExcel->getActiveSheet()->getCell("A$j")->getValue();
                $EquipmentName=$objPHPExcel->getActiveSheet()->getCell("B$j")->getValue();
                $EquipmentMac=$objPHPExcel->getActiveSheet()->getCell("C$j")->getValue();
                $IPAddressType=$objPHPExcel->getActiveSheet()->getCell("D$j")->getValue();
                $IPAddressDate=$objPHPExcel->getActiveSheet()->getCell("E$j")->getValue();
                $IPAddressNumber=GetNumberByIpAddress($IPAddress);
    
                $Pkid=GetGUID('IPPart').strval($j);
                $currentdate=date('Y-m-d H:i:s');
                ////////////////////////////////////////////////////////////////////////////////
                //判断是否有重复记录
                $sql="select IPAddr_Pkid from ITMS_IPAddr where IPAddr_IpAddr='".$IPAddress."'";
                ITMSWriteLog("Debug","resources->iptaskplan->import_ipaddress","Select ippart Infor SQL:".$sql);
                $result=mysqli_query($con,$sql);
    
                if($result!=false)
                {
                    if(mysqli_num_rows($result)>0)
                    {
                        $cmdSql="update ITMS_IPAddr set IPAddr_Name='".$EquipmentName."',IPAddr_Type='".$IPAddressType."',IPAddr_LastChangeDate='".$currentdate."'";
                        $cmdSql = $cmdSql."  where IPAddr_IpAddr='".$IPAddress."'";
                        
                        ITMSWriteLog("Debug","resources->iptaskplan->import_ipaddress","Update ipaddress Infor SQL:".$cmdSql);
                        $queryresult=mysqli_query($con,$cmdSql);
                        if($queryresult!=false)
                        {
                            $overlap++;
                        }
                        
                    }
                    else
                    {
                        $cmdSql="insert into ITMS_IPAddr (IPAddr_Pkid,IPAddr_Name,IPAddr_IpAddr,IPAddr_Type,IPAddr_Number,IPAddr_Mac,IPAddr_CreateDate,IPAddr_LastChangeDate) values ";
                        $cmdSql = $cmdSql." ('".$Pkid."','".$EquipmentName."','".$IPAddress."','".$IPAddressType."','".$IPAddressNumber."','".$EquipmentMac."','".$currentdate."','".$currentdate."')";
                        
                        ITMSWriteLog("Debug","resources->iptaskplan->import_ipaddress","Insert ipaddress Infor SQL:".$cmdSql);
                        $queryresult=mysqli_query($con,$cmdSql);
                        if($queryresult!=false)
                        {
                            $SuccessCount++;
                        }
                    }
                }
                else
                {
                    ITMSWriteLog("Error","resources->iptaskplan->import_ipaddress","Save ipaddress Infor Error.");
                }
            }
            mysqli_close($con);
    
            
    
            $Jsonrpc_Status=1;
            $Jsonrpc_Code=$overlap;
            $Jsonrpc_Result=$SuccessCount;
        }
        unlink($excelpath);
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch(exception $err)
    {
        $Jsonrpc_Status="0";
        $Jsonrpc_Code="-1";
        $Jsonrpc_Result=$err->getMessage();
    
        ITMSWriteLog("Fatal","resources->iptaskplan->import_ipaddress","Exception:".$err->getMessage());
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}
////////////////////////////////////////////////////////////////////////////////////
function discovery_iptaskplan($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();

    $pkid = $formdata;
    try {

        $currentdate=date('Y-m-d h:i:s');

        ITMSWriteLog("Debug","resources->iptaskplan->discover_iptaskplan","Begin Discover!");

        $fp = fsockopen("localhost", 80, $errno, $errstr, 30);  
        if (!$fp){  
           echo 'error fsockopen';  
        }  
        else{  
           stream_set_blocking($fp,0);  
           $http = "GET /FormData/resources/handaction_discoveriptaskplan.php HTTP/1.1\r\n";      
           $http .= "Host: localhost\r\n";      
           $http .= "Connection: Close\r\n\r\n";  
           fwrite($fp,$http);  
           fclose($fp);  
       }
        
        $Jsonrpc_Status=1;
        $Jsonrpc_Result="success";
        mysqli_close($con);

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_handaction_discoveryiptaskplan";
        //$Jsonrpc_Result=$err->getMessage();
        ITMSWriteLog("Fatal","resources->iptaskplan->discover_iptaskplan","Exception:".$err->getMessage());
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}
////////////////////////////////////////////////////////////////////////////////////
function rebuild_iptaskplantree($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();

    $pkid = $formdata;
    try {

        $currentdate=date('Y-m-d h:i:s');

        ITMSWriteLog("Debug","resources->iptaskplan->rebuild_iptaskplantree","Begin Discover!");

        $fp = fsockopen("localhost", 80, $errno, $errstr, 30);
        if (!$fp){
            echo 'error fsockopen';
        }
        else{
            stream_set_blocking($fp,0);
            $http = "GET /FormData/resources/handaction_rebuildiptaskplantree.php HTTP/1.1\r\n";
            $http .= "Host: localhost\r\n";
            $http .= "Connection: Close\r\n\r\n";
            fwrite($fp,$http);
            fclose($fp);
        }

        $Jsonrpc_Status=1;
        $Jsonrpc_Result="success";
        mysqli_close($con);

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_handaction_discoveryiptaskplan";
        //$Jsonrpc_Result=$err->getMessage();
        ITMSWriteLog("Fatal","resources->iptaskplan->rebuild_iptaskplantree","Exception:".$err->getMessage());
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}

function emptyaction_discovery($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();
    //error_log($formdata, 3, 'd:\phplog.txt');
    //表单反序列化
    //$RelationArray=FormdataToRelationArray($formdata);
    //error_log("$RelationArray", 3, 'd:\phplog.txt');
    //$pkid = $RelationArray['selectedrowpkid'];
    $pkid = $formdata;
    try {

        $currentdate=date('Y-m-d h:i:s');

        $sql="delete from ITMS_DiscoveryHost".
            " where DiscoveryHost_DiscoveryPkid='".$pkid."'";

        error_log($sql."\n", 3, 'd:\phplog.txt');
        $queryresult=mysqli_query($con,$sql);

        $currentdate=date('Y-m-d h:i:s');
        
        $sql="update ITMS_Discovery set Discovery_StartDate='".$currentdate.
        "',Discovery_ExStatus='1".
        "',Discovery_Exway='1".
        "',Discovery_Progress='0".
        "' where Discovery_Pkid='".$pkid."'";
        
        error_log($sql."\n", 3, 'd:\\phplog.txt');
        $queryresult=mysqli_query($con,$sql);
        //$a="python d:/python/discoveryhost.py ".$pkid;
        //passthru("python d:\python\discoveryhost.py ".$pkid);
        
        $fp = fsockopen("localhost", 80, $errno, $errstr, 30);
        if (!$fp){
            echo 'error fsockopen';
        }
        else{
            stream_set_blocking($fp,0);
            $http = "GET /FormData/mtools/handaction.php?pkid=".$pkid." HTTP/1.1\r\n";
            $http .= "Host: localhost\r\n";
            $http .= "Connection: Close\r\n\r\n";
            fwrite($fp,$http);
            fclose($fp);
        }        
        
        $Jsonrpc_Status=1;
        $Jsonrpc_Result=$pkid;
        mysqli_close($con);

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_emptyaction_discovery";
        //$Jsonrpc_Result=$err->getMessage();
        error_log($err->getMessage(), 3, 'd:\phplog.txt');

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}


function Get_Pregress($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();

    $pkid = $formdata;
    try {

        $currentdate=date('Y-m-d h:i:s');

        $sql="select Discovery_Progress from ITMS_Discovery".
        " where Discovery_Pkid='".$pkid."'";

        error_log($sql."\n", 3, 'd:\\phplog.txt');
        $queryresult=mysqli_query($con,$sql);
        //$a="python d:/python/discoveryhost.py ".$pkid;
        //passthru("python d:\python\discoveryhost.py ".$pkid);
        $rowcount=mysqli_num_rows($queryresult);
        if($rowcount==1)
        {
            $row=mysqli_fetch_array($queryresult);
            $Jsonrpc_Status=1;
            $Jsonrpc_Code=$row["Discovery_Progress"];
        }
        else 
        {

            $Jsonrpc_Status=0;
            $Jsonrpc_Code="0";
            $Jsonrpc_Result=$pkid;
        }
        mysqli_close($con);

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_GetPregress_discovery";
        //$Jsonrpc_Result=$err->getMessage();
        error_log($err->getMessage(), 3, 'd:\phplog.txt');

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}


function cancelaction_discovery($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();

    $pkid = $formdata;
    try {

        $currentdate=date('Y-m-d h:i:s');
        
        $sql="update ITMS_Discovery set Discovery_EndDate='".$currentdate.
        "',Discovery_ExStatus='0".
        "',Discovery_Exway='0".
        "',Discovery_Progress='0".
        "' where Discovery_Pkid='".$pkid."'";

        error_log($sql."\n", 3, 'd:\\phplog.txt');
        $queryresult=mysqli_query($con,$sql);
        //$a="python d:/python/discoveryhost.py ".$pkid;
        //passthru("python d:\python\discoveryhost.py ".$pkid);
        $Jsonrpc_Status=1;
        $Jsonrpc_Code="0";
        $Jsonrpc_Result=$pkid;
        mysqli_close($con);

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_GetPregress_discovery";
        //$Jsonrpc_Result=$err->getMessage();
        error_log($err->getMessage(), 3, 'd:\phplog.txt');

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}


function get_discoveryequipment($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();

    $pkid = $formdata;
    try {

    $sql="select DiscoveryHost_Pkid,DiscoveryHost_Ip,DiscoveryHost_sysName,DiscoveryHost_sysObjectID,DiscoveryHost_sysServices,DiscoveryHost_CreateDate ,DiscoveryHost_sysDescr from ITMS_DiscoveryHost where DiscoveryHost_DiscoveryPkid='".$pkid."'";
    error_log($sql."\r\n", 3, 'd:\\phplog.txt');
    if (!$con)
    {
        die('Could not connect: ' . mysqli_error());
    }
    //echo $sql;
    $result=mysqli_query($con,$sql);
    $rowdata="";
    $tabledata="";

    $ExwayArray['0']="自动";
    $ExwayArray['1']="手动";

    while($row=mysqli_fetch_array($result)) //遍历SQL语句执行结果把值赋给数组
    {
        $rowdata="<tr>";
        $rowdata=$rowdata."<td style='text-align: center'><label class='mt-checkbox mt-checkbox-single mt-checkbox-outline'><input type='checkbox' class='checkboxes' value='".$row["DiscoveryHost_Pkid"]."' /><span></span></label></td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["DiscoveryHost_Ip"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["DiscoveryHost_sysName"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["DiscoveryHost_sysObjectID"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["DiscoveryHost_sysServices"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["DiscoveryHost_CreateDate"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;width:30%'>".$row["DiscoveryHost_sysDescr"]."</td>";
        $rowdata=$rowdata."</tr>";      
        $tabledata=$tabledata.$rowdata;
    }
        //$a="python d:/python/discoveryhost.py ".$pkid;
        //passthru("python d:\python\discoveryhost.py ".$pkid);
        $Jsonrpc_Status=1;
        $Jsonrpc_Code=$tabledata;
        $Jsonrpc_Result=$pkid;
        mysqli_close($con);

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
    catch (Exception $err)
    {
        mysqli_close($con);
        $Jsonrpc_Status=0;
        $Jsonrpc_Code="err_getdiscoveryequipment_discovery";
        //$Jsonrpc_Result=$err->getMessage();
        error_log($err->getMessage(), 3, 'd:\phplog.txt');

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);
    }
}
?>