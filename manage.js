$(function () {
  var $addlist = $('form.edit-list div.form-group'); //获取所有的输入框

  $("td>a.edit").click(function () { //获取点击编辑的行为
    var $table = $(this).parent().parent();
    var num = $table.find('td').eq(0).text(); //num就是传入index.php的编辑记录的id,非常关键，否则，不知道更改的是那一条数据
    $addlist.find('#name').val($table.find('td').eq(1).text()); //因为是编辑数据，输入框的值由表格里的内容决定
    $addlist.find('#class').val($table.find('td').eq(2).text()); //因为是编辑数据，输入框的值由表格里的内容决定
    $addlist.find('#param1').val($table.find('td').eq(3).text()); //因为是编辑数据，输入框的值由表格里的内容决定
    $addlist.find('#param2').val($table.find('td').eq(4).text()); //因为是编辑数据，输入框的值由表格里的内容决定
    $addlist.find('#count').val($table.find('td').eq(5).text()); //因为是编辑数据，输入框的值由表格里的内容决定

    $('#confirm-edit').click(function (event) { //获取点击编辑确认按钮的行为
      $table.find('td').eq(1).text($addlist.find('#name').val()); //更改了数据后，表格里的数据就得跟着改变了
      $table.find('td').eq(2).text($addlist.find('#class').val()); //更改了数据后，表格里的数据就得跟着改变了
      $table.find('td').eq(3).text($addlist.find('#param1').val()); //更改了数据后，表格里的数据就得跟着改变了
      $table.find('td').eq(4).text($addlist.find('#param2').val()); //更改了数据后，表格里的数据就得跟着改变了
      $table.find('td').eq(5).text($addlist.find('#count').val()); //更改了数据后，表格里的数据就得跟着改变了
      $.post('index.php', {
        'editNumber': num,
        'name': $addlist.find('#name').val(), //提交的数据
        'class': $addlist.find('#class').val(), //提交的数据
        'param1': $addlist.find('#param1').val(), //提交的数据
        'param2': $addlist.find('#param2').val(), //提交的数据
        'count': $addlist.find('#count').val() //提交的数据
      }, function (data) {
        // alert(data);
      });
    });

  }); //编辑数据

  $("td>a.del").click(function () {
    var res = confirm("确定要删除这条记录吗？"); //友情提醒是否删除
    if (res) { //确实要删除
      $(this).parent().parent().remove(); //删除该条显示的数据，此时并未在数据库中删除，
      $.get('index.php?delNumber=' + $(this).parent().parent().find('td').eq(0).text(), function (data) {
        // alert(data);
      }); //传入index.php待删除的记录的id,此时才开始删除数据库中对应的位置
    } else {} //用户取消操作，啥也不干
  });

  $('button.add-source').click(function () { //捕获点击添加资源的按钮
    $addlist.find('#name').val(""); //由于是新添加资源，清空每个输入框的已有内容
    $addlist.find('#class').val(""); //由于是新添加资源，清空每个输入框的已有内容
    $addlist.find('#param1').val(""); //由于是新添加资源，清空每个输入框的已有内容
    $addlist.find('#param2').val(""); //由于是新添加资源，清空每个输入框的已有内容
    $addlist.find('#count').val(""); //由于是新添加资源，清空每个输入框的已有内容
    $('#confirm-edit').click(function () { //捕捉用户点击确定添加的按钮的行为
      $.post('index.php', {
        'add': 1,
        'name': $addlist.find('#name').val(), //提交的数据
        'class': $addlist.find('#class').val(), //提交的数据
        'param1': $addlist.find('#param1').val(), //提交的数据
        'param2': $addlist.find('#param2').val(), //提交的数据
        'count': $addlist.find('#count').val() //提交的数据
      }, function (data) {
        // alert(data);
      });
    });
  });

});
