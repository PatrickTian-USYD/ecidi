<?php
header("content-type:text/html; charset=utf-8");
include("../../DatatableConn.php");
include("../../PubApi.php");
include("../ITMSTools.php");
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
switch ($method)
{
    case "save_plan":
        echo save_plan($formdata);
        break;  
    case "del_plan":
        echo del_plan($formdata);
        break;
    
    default:
        echo "default";
        break;
}

function save_plan($formdata)
{
    $Jsonrpc_Status="0";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();
    //error_log($formdata, 3, 'd:\phplog.txt');
    //表单反序列化
    $RelationArray=FormdataToRelationArray($formdata);
    //error_log("$RelationArray", 3, 'd:\phplog.txt');
    
    try {
        $pkid=$RelationArray['pkid'];
        $currentdate=date('Y-m-d H:i:s');
        $sql="select Plan_Pkid from ITMS_Plan where Plan_Pkid='".$pkid."'";
        ITMSWriteLog("Debug","coopwork->planinfor->save_plan","Select plan Infor SQL:".$sql);
        $result=mysqli_query($con,$sql);
        
        $sql="";
        
        if($RelationArray['acompletedate']=="")
            $RelationArray['acompletedate']=$RelationArray['pcompletedate'];
        
        if($result!=false && mysqli_num_rows($result)==0)
        {
            $pkid=GetGUID('Plan');
            $Jsonrpc_Result=$pkid;
            $sql="insert into ITMS_Plan (Plan_Pkid,Plan_TaskPkid,Plan_Name,Plan_Executor,Plan_PCompleteDate,Plan_ACompleteDate,Plan_Status,Plan_Progress,Plan_CreateDate,Plan_LastChangeDate) values ";
            $sql = $sql." ('".$pkid."','".$RelationArray['taskpkid']."','".$RelationArray['name']."','".$RelationArray['dutya']."','".$RelationArray['pcompletedate']."','".$RelationArray['acompletedate']."','".$RelationArray['status']."','".$RelationArray['progress']."','".$currentdate."','".$currentdate."')";
        }
        
        if($result!=false && mysqli_num_rows($result)==1)
        {
            $Jsonrpc_Result=$RelationArray['pkid'];
            $sql="update ITMS_Plan set Plan_ACompleteDate='".$RelationArray['acompletedate'].
            "',Plan_Status='".$RelationArray['status'].
            "',Plan_Progress='".$RelationArray['progress'].
            "',Plan_LastChangeDate='".$currentdate.
            "' where Plan_Pkid='".$Jsonrpc_Result."'";
        }
            
        ITMSWriteLog("Debug","coopwork->planinfor->save_plan","Save Plan Infor SQL:".$sql);
        $queryresult=mysqli_query($con,$sql);
        if($queryresult!=false)
        {
            $Jsonrpc_Status=1;
        }
        else
        {
            $Jsonrpc_Status=0;
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
        $Jsonrpc_Code="err_save_planinfor";
        //$Jsonrpc_Result=$err->getMessage();
       ITMSWriteLog("Fatal","coopwork->planinfor->save_plan","Exception:".$err->getMessage());

        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);

    }

}

function del_plan($formdata)
{
    $Jsonrpc_Status="";
    $Jsonrpc_Code="";
    $Jsonrpc_Result="";
    $con=CreatDatabaseConn();

    $PlanPkid = $formdata;
    try {

        $currentdate=date('Y-m-d h:i:s');
    
        $sql="delete from ITMS_Plan".
        " where Plan_Pkid='".$PlanPkid."'";
    
        ITMSWriteLog("Debug","coopwork->planinfor->del_plan","Del plan Infor SQL:".$sql);
        $queryresult=mysqli_query($con,$sql);
        if($queryresult!=false)
            $Jsonrpc_Status=1;
        else 
            $Jsonrpc_Status=0;
        
        $Jsonrpc_Result=$PlanPkid;
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
        $Jsonrpc_Code="err_del_plan";
        //$Jsonrpc_Result=$err->getMessage();
        ITMSWriteLog("Fatal","coopwork->planinfor->del_plan","Exception:".$err->getMessage());
    
        $resultarray=array("status" => $Jsonrpc_Status,
            "code" => $Jsonrpc_Code,
            "result" => $Jsonrpc_Result
        );
        return json_encode($resultarray);    
    }
}

?>