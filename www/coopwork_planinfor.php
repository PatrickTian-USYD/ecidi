<?php
include("Smarty/SmartyConfig.php");
include("DatatableConn.php");
include("CheckSessionRight.php");
include("PubApi.php");
include("FormData/ITMSTools.php");
$con=CreatDatabaseConn();
$QueryType="";
$taskpkid="";

$status="";
$startdate="";
$enddate="";
$name="";
$dutya="";
$QueryStr="1=1";


$StatusArray['0']="未开始";
$StatusArray['1']="执行中";
$StatusArray['2']="延期执行中";
$StatusArray['3']="按期完成";
$StatusArray['4']="延期完成";
$StatusArray['5']="未完成";
$StatusArray['6']="新增";
$StatusArray['7']="新增问题";
$StatusArray['8']="新增完成";


if(isset($_REQUEST["taskpkid"]))// && !empty($_REQUEST["ipsegmentpkid"])
{
    $QueryType="Default";
    $taskpkid=$_REQUEST["taskpkid"];
    //echo "default";
}

if(isset($_REQUEST["task"]))// && !empty($_REQUEST["ipsegment"])
{
    $QueryType="Query";
    $taskpkid=$_REQUEST["task"];
    
    $status=$_REQUEST["status"];
    $startdate=$_REQUEST["startdate"];
    $enddate=$_REQUEST["enddate"];
    $name=$_REQUEST["name"];
    $dutya=$_REQUEST["userlist"];
    //echo "query";
}
/////////////////////////////////////////////////////////////////////////////////////
if($taskpkid!="")
{
    
$QueryStr = $QueryStr." and Plan_TaskPkid='".$taskpkid."'";
}

if($status!="")
{
    $QueryStr = $QueryStr." and Plan_Status='".$status."'";
}
if($startdate!="" && $enddate=="")
{
    $QueryStr = $QueryStr." and (Plan_PCompleteDate>='".$startdate."' or Plan_ACompleteDate>='".$startdate."')";
}
if($startdate=="" && $enddate!="")
{
    $QueryStr = $QueryStr." and (Plan_PCompleteDate<='".$enddate."' or Plan_ACompleteDate<='".$enddate."')";
}
if($startdate!="" && $enddate!="")
{
    $QueryStr = $QueryStr." and ((Plan_PCompleteDate>='".$startdate."' and Plan_PCompleteDate<='".$enddate."') or (Plan_ACompleteDate>='".$startdate."' and Plan_ACompleteDate<='".$enddate."'))";
}
if($startdate=="" && $enddate=="")
{
    $MonthBeginDay = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")));
    $QueryStr = $QueryStr." and (Plan_PCompleteDate>'".$MonthBeginDay."' or Plan_Status not in (3,4,8))";
}
if($name!="")
{
    $QueryStr = $QueryStr." and Plan_Name like '%".$name."%'";
}
if($dutya!="")
{
    $QueryStr = $QueryStr." and Plan_Executor = '".$dutya."'";
}


/////////////////////////////////////////////////////////////////////////////////////

//ITMSWriteLog("Debug","resources->ipaddressinfor","Segment information is not found!");
if($QueryStr=="1=1")
{
     $MonthBeginDay = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")));
     $sql="select Plan_Pkid,Plan_TaskPkid,Plan_Name,Plan_Executor,Plan_Participant,Plan_PCompleteDate,Plan_ACompleteDate,Plan_Status,Plan_Progress,Plan_LastChangeDate from ITMS_Plan where Plan_PCompleteDate>'".$MonthBeginDay."' or Plan_Status not in (3,4,8)  order by Plan_LastChangeDate desc limit 50";
}
else 
{
    $sql="select Plan_Pkid,Plan_TaskPkid,Plan_Name,Plan_Executor,Plan_Participant,Plan_PCompleteDate,Plan_ACompleteDate,Plan_Status,Plan_Progress,Plan_LastChangeDate from ITMS_Plan where ".$QueryStr." order by Plan_LastChangeDate desc";

}
$newSql="";
$newSql = "select Plan_Pkid,Plan_TaskPkid,Plan_Name,Plan_Executor,Plan_Participant,Plan_PCompleteDate,Plan_ACompleteDate,Plan_Status,Plan_Progress,Plan_LastChangeDate,Task_Name,User_FullName from (".$sql.") as PlanInfor,ITMS_Task,ITMS_User where ";
$newSql = $newSql."PlanInfor.Plan_TaskPkid = ITMS_Task.Task_Pkid ";
$newSql = $newSql."and PlanInfor.Plan_Executor = ITMS_User.User_UserName";


$tabledata="";
$rowdata="";
ITMSWriteLog("Debug","coopword->planinfor","Select plan Infor SQL:".$newSql);
$result=mysqli_query($con,$newSql);
if($result!=false && mysqli_num_rows($result)>0)
{
    ITMSWriteLog("Debug","resources->ipaddressinfor","Select Ipaddress Infor,RecordCount:".mysqli_num_rows($result));
    $TypeFlagArray['0']="固定分配";
    $TypeFlagArray['1']="DHCP分配";
    while($row=mysqli_fetch_array($result)) //遍历SQL语句执行结果把值赋给数组
    {
    
        //$discoveryrules=$discoveryrules."<option value='".$row["Discovery_Pkid"]."'>".$row["Discovery_Name"]."</option>";
        $rowdata="";
        $rowdata = "<tr>";
        $rowdata=$rowdata."<td style='text-align: center'><label class='mt-checkbox mt-checkbox-single mt-checkbox-outline'><input type='checkbox' class='checkboxes' value='".$row["Plan_Pkid"]."' /><span></span></label></td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["Task_Name"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["Plan_Name"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["User_FullName"]."</td>";
        
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["Plan_PCompleteDate"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["Plan_ACompleteDate"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$StatusArray[$row["Plan_Status"]]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["Plan_Progress"]."</td>";
        $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["Plan_LastChangeDate"]."</td>";
        $rowdata = $rowdata."<td style='text-align: center;word-wrap:break-word;'><a class='edit' href='javascript:;'  data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a></td>";
        $rowdata = $rowdata."<td style='text-align: center;word-wrap:break-word;'><a class='delete' href='javascript:;' data-toggle='tooltip' title='Delete'><i class='fa fa-remove'></i></a></td>";
        $rowdata = $rowdata."</tr>";

    
        $tabledata=$tabledata.$rowdata;
    
    }
}
else 
{
    ITMSWriteLog("Debug","coopwork->planinfor","Select Plan Infor,No Record.");

}
//ITMSWriteLog("Debug","resources->ipaddressinfor","tabledata:".$tabledata);

/////////////////////////////////////////////////////////////////////////////////////
$sql="select Task_Pkid,Task_Name from ITMS_Task order by Task_Class asc,Task_Grade asc,Task_Name asc";
$result=mysqli_query($con,$sql);
$tasklist="";
while($row=mysqli_fetch_array($result)) //遍历SQL语句执行结果把值赋给数组
{
    $selectedFlag="";
    if($row["Task_Pkid"]==$taskpkid)
        $selectedFlag="selected='true'";

    $tasklist=$tasklist."<option value='".$row["Task_Pkid"]."' ".$selectedFlag.">".$row["Task_Name"]."</option>";

}
/////////////////////////////////////////////////////////////////////////////////////////////////
$userlist="";
$sql="select User_UserName as username,User_FullName as fullname from ITMS_User";
$queryresult=mysqli_query($con,$sql);
if(mysqli_num_rows($queryresult) >0)
{
    while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
    {
        $selectedFlag="";
        if($row["username"]==$dutya)
            $selectedFlag="selected='true'";
        
        $userlist=$userlist."<option value='".$row["username"]."' ".$selectedFlag.">".$row["fullname"]."</option>";
    }
}
mysqli_close($con);
$tpl->assign("tabledata", $tabledata);
$tpl->assign("tasklist", $tasklist);
$tpl->assign("userlist", $userlist);
$tpl->assign("taskpkid", $taskpkid);

$tpl->assign("status", $status);

$tpl->assign("startdate", $startdate);
$tpl->assign("enddate", $enddate);
$tpl->assign("name", $name);
$tpl->display("coopwork/planinfor.html");
?>