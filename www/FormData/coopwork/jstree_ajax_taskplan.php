<?php
header("content-type:text/html; charset=UTF-8");
//header("content-type:text/html; charset=gb2312");
include("../../DatatableConn.php");
$con=CreatDatabaseConn();

$parent = $_REQUEST["parent"];
error_reporting(0);
//var_dump($parent);
//$parent=Encoding.UTF8.GetString(Encoding.GetEncoding("gb2312").GetBytes($parent));
//var_dump($parent);
//var_dump(Encoding.GetEncoding("gb2312").GetBytes($parent));
$data = array();
$prefixStr="";
$isParent="true";
$sql="";
$states = array(
  	"success",
  	"info",
  	"danger",
  	"warning"
);


if($parent=="#" || $parent=="")
{
    $sql="select Task_Class from ITMS_Task group by Task_Class order by Task_Class asc";
    $prefixStr="root";
}
else 
{
    $typeValueArr=explode("-", $parent);
    if(count($typeValueArr)==2)
    {
        if($typeValueArr[0]=="root")
        {
            $sql="select Task_Pkid,Task_Name from ITMS_Task where Task_Class='".$typeValueArr[1]."' order by Task_Grade asc";
            $prefixStr="sub";
        }
        
        if($typeValueArr[0]=="root")
        {
        
        }
    }

}

if (!$con)
{
    die('Could not connect: ' . mysqli_error());
}
//echo $sql;
$result=mysqli_query($con,$sql);

$rowcount=mysqli_num_rows($result);
$index=0;
$pkid="";
$showname="";
$havesubflag=false;
while($row=mysqli_fetch_array($result)) //遍历SQL语句执行结果把值赋给数组
{
    
    if($prefixStr=="root")
    {
        $ProjectClassArray['1']="日常工作";
        $ProjectClassArray['2']="系统集成";
        $ProjectClassArray['3']="经营项目";
        $ProjectClassArray['4']="科研项目";        
        $ProjectClassArray['5']="前瞻课题";
        $ProjectClassArray['6']="临时任务";    
        $ProjectClassArray['9']="其他";
        $havesubflag=true;
        $pkid=$prefixStr."-".$row[0];
        $showname=$ProjectClassArray[$row[0]];
        $data[] = array(
            "id" => $pkid,
            "text" => $showname,
            //"id" => $prefixStr."-".iconv('gb2312','utf-8',$row[0]),
            //"text" => iconv('gb2312','utf-8',$row[1]),
            //"id" => $prefixStr."_"."bbb",
            //"text" => "aaa",
            "icon" => "fa fa-folder icon-lg icon-state-" . ($states[rand(0, 3)]),
            "children" => $havesubflag,
            "type" => "root"
        );    
    }
    else 
    {
        $pkid=$prefixStr."-".$row[0];
        $showname=$row[1];
        
        $data[] = array(
            "id" => $pkid,
            "text" => $showname,
            "icon" => "fa fa-folder icon-lg icon-state-" . ($states[rand(0, 3)]),
            "children" => $havesubflag
        );
    }

}
mysqli_close($con);

//var_dump($data);

header('Content-type: text/json');
header('Content-type: application/json');
echo json_encode($data);
//echo json_encode(gbk2utf8($data));
function gbk2utf8($data)
{
  if(is_array($data))
    {
        return array_map('gbk2utf8', $data);
    }
  return iconv('gbk','utf-8',$data);
}
?>