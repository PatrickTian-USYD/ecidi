<?php
include("Smarty/SmartyConfig.php");
include("DatatableConn.php");
$con=CreatDatabaseConn();
include("CheckSessionRight.php");

//$con = mysqli_connect("172.29.16.36","zabbix","zabbix","zabbix");
//mysqli_query($con,"SET character_set_client = 'utf8'");
//mysqli_query($con,"SET character_set_results = 'utf8'");
//mysqli_query($con,"SET character_set_connection = 'utf8'");
/////////////////////////////////////////////////////////////////////////////////////////////////
$userlist="";
$UserArray=array();
$sql="select User_UserName as username,User_FullName as fullname from ITMS_User";
$queryresult=mysqli_query($con,$sql);
if(mysqli_num_rows($queryresult) >0)
{
    while($row=mysqli_fetch_array($queryresult)) //遍历SQL语句执行结果把值赋给数组
    {
        $UserArray[$row["username"]]=$row["fullname"];
        $userlist=$userlist."<option value='".$row["username"]."'>".$row["fullname"]."</option>";
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////
//$sql="select Task_Pkid,Task_Name,Task_Class,Task_Type,Task_Grade,Task_Stage,Task_StartDate,User_FullName,Task_DutyUserB,Task_Remark from ITMS_Task,ITMS_User where ITMS_Task.Task_DutyUserA=ITMS_User.User_UserName order by Task_Class asc,Task_Grade asc";
$sql="select Task_Pkid,Task_Name,Task_Class,Task_Type,Task_Grade,Task_Stage,Task_StartDate,Task_DutyUserA,Task_DutyUserB,Task_Remark from ITMS_Task order by Task_Class asc,Task_Grade asc";

if (!$con)
{
    die('Could not connect: ' . mysqli_error());
}
//echo $sql;
$result=mysqli_query($con,$sql);
$rowdata="";
$tabledata="";
$discoveryrules="";
$ruleshowflag="";
$equipmentshowflag="";
$rowcount=mysqli_num_rows($result);
$index=0;


$TaskClass['1']="日常工作";
$TaskClass['2']="系统集成";
$TaskClass['3']="经营项目";
$TaskClass['4']="科研项目";
$TaskClass['5']="前瞻课题";
$TaskClass['6']="临时任务";
$TaskClass['9']="其他";


$TaskGrade['1']="重点";
$TaskGrade['2']="常规";
$TaskGrade['3']="其他";

$TaskStage['1']="立项";
$TaskStage['2']="可研";
$TaskStage['3']="建设";
$TaskStage['4']="完成";
$TaskStage['5']="运维";
$TaskStage['6']="下线";

while($row=mysqli_fetch_array($result)) //遍历SQL语句执行结果把值赋给数组
{
    
    //$discoveryrules=$discoveryrules."<option value='".$row["Discovery_Pkid"]."'>".$row["Discovery_Name"]."</option>";

    $rowdata="<tr>";
    $rowdata=$rowdata."<td style='text-align: center'><label class='mt-checkbox mt-checkbox-single mt-checkbox-outline'><input type='checkbox' class='checkboxes' value='".$row["Task_Pkid"]."' /><span></span></label></td>";
    $rowdata=$rowdata."<td style='text-align: left;word-wrap:break-word;'>".$row["Task_Name"]."</td>";
    $rowdata=$rowdata."<td style='text-align: center;table-layout:fixed;WORD-BREAK:break-all;WORD-WRAP:break-word'>".$TaskClass[$row["Task_Class"]]."</td>";
    $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$TaskGrade[$row["Task_Grade"]]."</td>";
    $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$TaskStage[$row["Task_Stage"]]."</td>";
    $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["Task_StartDate"]."</td>";
    $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$UserArray[$row["Task_DutyUserA"]]."</td>";
    $rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$UserArray[$row["Task_DutyUserB"]]."</td>";
    //$rowdata=$rowdata."<td style='text-align: center;word-wrap:break-word;'>".$row["nextcheck"]."</td>";
    $rowdata=$rowdata."</tr>";      

    $tabledata=$tabledata.$rowdata;

}



mysqli_close($con);
$tpl->assign("tabledata", $tabledata);
$tpl->assign("userlist", $userlist);
//$tpl->assign("ipsegmentlist", $ipsegmentlist);
$tpl->display("coopwork/taskplan.html");
?>