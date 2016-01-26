<?php
include("link.php");
//引入用于连接数据库的文件
 ?>

<!-- html文档，静态页面 -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>电子元件物料管理系统</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css" />
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <!-- 上面三个文件都是网络地址的库文件 -->

    <style type="text/css" media="screen">
        *{
            font-family:'Microsoft Yahei';
        }
        div.page-header {
          text-align: center;
        }
        div.page-header>h1 {
          font-weight: bold;
        }
        div.main-table{
            /*border: 1px solid red;*/
            font-size: 15px;
            /*margin:0 auto;*/
            padding: 40px;
            /*text-align: center;*/
        }
        div.table{
            padding: 20px;
        }
        div.modal div.modal-dialog {
          position: absolute;
          top: 15%;
          left: 25%;
          background: silver;
          -webkit-box-shadow: 15px 15px 15px gray;
          box-shadow: 15px 15px 15px gray;
          /*cursor: move;*/
        }
    </style>
    <!-- CSS样式表代码 -->
</head>
<body>
<div class="container">
  <nav class="navbar navbar-default ">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">logo</a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <form class="navbar-form navbar-left" role="search" method="post" action="index.php">
        <div class="form-group">
          <select class="form-control" name="key1">
              <option>--按分类搜索--</option>
              <option>电阻</option>
              <option>电容</option>
            </select>
            <!-- 下拉列表1 -->
        </div>
        <div class="form-group">
          <select class="form-control" name="key2">
              <option>--按属性搜索--</option>
              <option>名称</option>
              <option>参数1</option>
              <option>参数2</option>
              <option>数量</option>
            </select>
            <!-- 下拉列表2 -->
        </div>
          <div class="form-group">
            <input type="search" name="key" class="form-control" placeholder="输入关键字">
            <!-- 搜索内容 -->
          </div>
          <button type="submit" id="search" name="submit-search" class="btn btn-default">搜索</button>
          <!-- 搜索提交按钮 -->
        </form>
        <ul class="nav navbar-nav navbar-right">
          <button type="button" class="btn btn-primary btn-lg add-source" data-toggle="modal" data-target="#Modal">添加物料</button>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
  </nav>
  <div class="page-header">
    <h1>电子元器件物料管理系统</h1>
    <h4>powered on May 11th</h4>
    <!-- 居中的标题 -->
  </div>
</div>
<div class="main-table">
    <?php
    //PHP代码混编html
    /**
     * Created by PhpStorm.
     * User: ChenLei
     * Date: 2015/5/11
     * Time: 13:47
     */
    $pageSize=15;
    //每一页记录数量
    $pageNumber=1;
    //初始页码

    if(isset($_GET['pageNumber'])){
        $pageNumber=(int)$_GET['pageNumber'];
    }
    //传入点击得到的页码

    /*if(isset($_GET['pageUp']) && ($pageNumber > 1)){

        // $pageNumber--;
        $pageNumber%=$pageSize;
    }*/
    /*if(isset($_GET['pageDown']) && ($pageNumber < 10)){

        // $pageNumber++;
        $pageNumber%=$pageSize;
    }*/
    $pageBegin=$pageSize*($pageNumber-1);
    //分页的起始位置，


    // var_dump($row);
    echo "<table class='table table-striped  table-bordered table-condensed table-hover table-responsive'>";
    echo "<tr>"
        ."<th>序号</th>"
        ."<th>名称</th>"
        ."<th>类别</th>"
        ."<th>参数1</th>"
        ."<th>参数2</th>"
        ."<th>数量</th>"
        ."<th>操作</th>"
    ."</tr>";
    //表头，echo的代码是html
    $clarry=array('active','success','danger');

    if (!isset($_POST['submit-search'])) {
    //没有点击搜索按钮，那么默认分页显示
      $select_query="SELECT * FROM wuliao_list limit $pageBegin,$pageSize";
      //选择分页的记录条数，如从0开始往下10条，那么PageBegin=0,$pageSize=10
      $result=$link->query($select_query) or die(mysqli_error($link));

      while ($row=$result->fetch_row()) {
      //取出每一行的数据
        $className=$clarry[rand(0,count($clarry)-1)];
        echo "<tr class='$className'>
            <td>$row[0]</td>
            <td>$row[1]</td>
            <td>$row[2]</td>
            <td>$row[3]</td>
            <td>$row[4]</td>
            <td>$row[5]</td>
            <td><a href='#' title='编辑' class='edit' data-toggle=\"modal\" data-target=\"#Modal\">编辑</a>&nbsp;/&nbsp;<a href='#' class='del' title='删除'>删除</a></td>
        </tr>";
    }
  }
    else{
    //点击了搜索按钮，显示结果得根据搜索的结果相应变化
      $key1 = $_POST['key1'];
      //搜索项1 【电容，电阻】
      $key2 = $_POST['key2'];
      //搜索项2 【名称，参数1，参数2，数量】
      $key = $_POST['key'];
      //填写的搜索关键字，与搜索项2 要对应，比如，搜索项2如果选择的是数量，搜索框就要求输入数字，

      $search_query = "SELECT * FROM wuliao_list WHERE 类别 = '$key1' AND $key2 LIKE '%$key%';";
      //模糊搜索SQL语句
      $result = $link->query($search_query);
      while (@$rerow=$result->fetch_row() ){
      //得到搜索的每一行结果
        $className=$clarry[rand(0,count($clarry)-1)];
        echo "<tr class='$className'>
            <td>$rerow[0]</td>
            <td>$rerow[1]</td>
            <td>$rerow[2]</td>
            <td>$rerow[3]</td>
            <td>$rerow[4]</td>
            <td>$rerow[5]</td>
            <td><a href='#' title='编辑' class='edit' data-toggle=\"modal\" data-target=\"#Modal\">编辑</a>&nbsp;/&nbsp;<a href='#' class='del' title='删除'>删除</a></td>
        </tr>";
      }
    }
    echo "</table>";

    if (isset($_GET['delNumber'])) {
    //得到待删除记录的id
        $del_num = $_GET['delNumber'];
        $del_query = "DELETE FROM wuliao_list WHERE 序号 = {$del_num};";
        //删除SQL语句
        $link->query($del_query) or die(mysqli_error($link));

        // echo "删除成功";
        $drop_key="ALTER TABLE wuliao_list DROP COLUMN 序号";
        $link->query($drop_key) or die(mysqli_error($link));
        //删除主键列，

        $alter_query="ALTER TABLE wuliao_list ADD COLUMN 序号 INT( 3 ) NOT NULL AUTO_INCREMENT FIRST,ADD PRIMARY KEY(序号) " ;
        $link->query($alter_query) or die(mysqli_error($link));
        //添加自动递增主键列，用于重新排序，防止序号断号；
    }
    //删除记录

    if (isset($_POST['editNumber'])) {
    //得到编辑的记录的id
    $update_num = $_POST['editNumber'];
    $name = $_POST['name'];
    //提交的表单域的值
    $class = $_POST['class'];
    //提交的表单域的值
    $param1 = $_POST['param1'];
    //提交的表单域的值
    $param2 = $_POST['param2'];
    //提交的表单域的值
    $count = $_POST['count'];
    //提交的表单域的值
    $update_query = "UPDATE wuliao_list SET 名称='$name',类别='$class',参数1='$param1',参数2='$param2',数量='$count' WHERE 序号= '$update_num';";
    //更新的SQL语句
    $link->query($update_query) or die(mysqli_error($link));

    // echo "修改成功";
}
//提交的更新数据的页面

    if (isset($_POST['add'])) {
    //获取增加记录的意图

        $name = $_POST['name'];
        //提交的表单域的值
        $class = $_POST['class'];
        //提交的表单域的值
        $param1 = $_POST['param1'];
        //提交的表单域的值
        $param2 = $_POST['param2'];
        //提交的表单域的值
        $count = $_POST['count'];
        //提交的表单域的值

        $insert_query="INSERT INTO wuliao_list VALUES (NULL,'$name','$class','$param1','$param2','$count'); ";
        //添加记录的SQL语句
        $link->query($insert_query) or die(mysqli_error($link));

        // echo "成功";
    }

    ?>
</div>
<nav style="margin: 0 auto;text-align: center">
  <ul class="pagination" >
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li><a href="index.php?pageNumber=1">1</a></li>
    <li><a href="index.php?pageNumber=2">2</a></li>
    <li><a href="index.php?pageNumber=3">3</a></li>
    <li><a href="index.php?pageNumber=4">4</a></li>
    <li><a href="index.php?pageNumber=5">5</a></li>
    <li><a href="index.php?pageNumber=6">6</a></li>
    <li><a href="index.php?pageNumber=7">7</a></li>
    <li><a href="index.php?pageNumber=8">8</a></li>
    <li><a href="index.php?pageNumber=9">9</a></li>
    <li><a href="index.php?pageNumber=10">10</a></li>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
<!-- 分页组件 -->

    <div class="modal fade" id="Modal" tabindex="-1" role="dialog"  aria-hidden="true">
      <div class="modal-dialog ui-widget-content">
        <div class="modal-content">
          <div class="modal-header" style="background: #1372d2;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="exampleModalLabel">修改信息</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal edit-list">
              <div class="form-group">
                <label for="name" class="col-md-2 control-label">名称:</label>
                <div class="col-md-10">
                    <input id="name" type="text" class="form-control" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="class" class="col-md-2 control-label">类别:</label>
                <div class="col-md-10">
                    <input id="class" type="text" class="form-control" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="param1" class="col-md-2 control-label">参数1:</label>
                <div class="col-md-10">
                    <input id="param1" type="text" class="form-control" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="param2" class="col-md-2 control-label">参数2:</label>
                <div class="col-md-10">
                    <input id="param2" type="text" class="form-control" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="count" class="col-md-2 control-label">数量:</label>
                <div class="col-md-10">
                    <input id="count" type="text" class="form-control" placeholder="">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer" style="background:#72D416;">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-undo">取消</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="confirm-edit">确定</button>
          </div>
        </div>
      </div>
    </div>
<!--  模态框，用于弹出编辑记录的输入框和添加数据的输入框-->

    <script src="manage.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>
