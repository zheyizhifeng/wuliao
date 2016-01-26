<?php
header("Content-type:text/html;charset=utf-8");
//设置文档类型编码UTF8

// $link = new mysqli('localhost', 'root', '', 'wuliao') or die(mysqli_error($link));
//连接本地数据库，用于测试


$link = new mysqli('db_addr', 'user', 'password', 'database') or die(mysqli_error($link));//连接远程网络数据库


$charset = "SET NAMES UTF8;";//定义数据库客户端编码
$link->query($charset);//执行设置字符集代码

/*$query="SELECT * FROM wuliao_list";
$result=$link->query($query) or die(mysqli_error($link));
while ($row=$result->fetch_row() ){
	echo $row[0]."<br>";
}*/ //测试代码，测试查询功能

/*$arr1= array('瓷片电容','涤纶电容','电解电容','云母电容','纸介电容','碳膜电阻','金属膜电阻','线绕电阻');
$name =$arr1[rand(0,count($arr1)-1)];
$class=stripos($name,'电容')?'电容':'电阻';
$votage=array('1V','2V','3V','4V','5V','10V','15V','30V','50V','100V');
$C=array('0.1','0.2','0.5','0.7','1.2','1.5','2.7','5','7.3');
$R=array('1','2','3.6','4.7','5','8.2','10','15','47','100');
$param1="耐压值: ".$votage[rand(0,count($votage)-1)];
$param2=$class=='电容'?'容量: '.$C[rand(0,count($C)-1)]."pF":'阻值: '.$R[rand(0,count($R)-1)]."欧姆";
$count=rand(1,50);
$insert_query="INSERT INTO wuliao_list VALUES (NULL,'$name','$class','$param1','$param2','$count'); ";
$link->query($insert_query) or die(mysqli_error($link));*/ //测试代码，完成数据的随机插入


/*$del_query="ALTER TABLE wuliao_list DROP COLUMN 序号";
$link->query($del_query);*/ //测试代码，删除主键列

/*
$alter_query="ALTER TABLE wuliao_list ADD COLUMN 序号 INT( 3 ) NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY(序号) " ;
$link->query($alter_query) or die(mysqli_error($link));*/ //测试代码，重新添加主键列，自动递增

/*$name='瓷片电容';
$class='电容';
$param1='1V';
$param2='5pF';
$count=10;
$update_num=1;
$update_query = "UPDATE wuliao_list SET 名称='$name',类别='$class',参数1='$param1',参数2='$param2',数量='$count' WHERE 序号= '$update_num';";
$link->query($update_query) or die(mysqli_error($link));
echo $update_query;*/ //测试代码，测试更新数据库记录功能

      /*$key1 = '电容';
			$key2 = '名称';
      $key ="云母" ;
      // echo "$key1 $key2 $key";
      $search_query = "SELECT * FROM wuliao_list WHERE 类别 = '$key1' AND $key2 LIKE '%$key%'; ";//模糊搜索SQL语句
      echo "$search_query";
      $result = $link->query($search_query);
      while ($rerow=$result->fetch_row() ){
        var_dump($rerow);
      }*/ //测试代码，测试模糊匹配
?>
