<?php

$dir =  "C:/DesCordPhoto";

$picdirs = getDirContent($dir);

$picdirs = array_diff($picdirs, ["biu"]);

// var_dump($picdirs);

$datas = [];
$i = 0;
$y = 0;
foreach ($picdirs as $picdir) {

  $file = fopen("../" . $picdir . '/TrainInfo.txt', "r");
  $names = array();
  $datas[$y]['title'] = $picdir;
  while (!feof($file)) {
    $txt = fgets($file);
    if (strpos($txt, '00') !== false) {
      // $arrr['children']=['pic_url'=>sprintf("%04d",substr($txt,0,4)+1),'title' => substr(strrchr($txt,' '),0,7)];
      $datas[$y]['children'][] = ['title' => substr(strrchr($txt, ' '), 0, 8), 'pic_url' => sprintf("%03d", substr($txt, 0, 4) + 1), 'dir' => $picdir];
      $i++;
    };
  }
  $y++;
  fclose($file);
}

// $datas=array_values($datas);

// echo(json_encode($datas));
// echo json_last_error();

function getDirContent($path)
{
  if (!is_dir($path)) {
    return false;
  }
  $arr = array();
  $data = scandir($path);
  foreach ($data as $value) {
    if ($value != '.' && $value != '..') {
      $arr[] = $value;
    }
  }
  return $arr;
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>中铁管理系统</title>
  <link rel="stylesheet" href="layui/css/layui.css">
</head>

<body class="layui-layout-body">
  <div class="layui-layout layui-layout-admin">
    <div class="layui-header">
      <div class="layui-logo">中铁管理系统</div>
    </div>

    <div class="layui-side layui-bg-black">
      <div class="layui-side-scroll">
        <div id="test1"></div>
      </div>
    </div>

    <div class="layui-body">
      <!-- 内容主体区域 -->
      <div class="img">
        <img id='image1' src="" width="50%" />
      </div>
      <div class="img">
        <img id='image2' src="" width="50%" />
      </div>
      <div class="img">
        <img id='image3' src="" width="50%" />
      </div>
    </div>

    <div class="layui-footer">
      页面信息
    </div>
  </div>
  <script src="layui/layui.js"></script>
  <script>
    //JavaScript代码区域
    layui.use('element', function() {
      var element = layui.element;

    });

    layui.use('tree', function() {
      var $ = layui.$ //重点处
      var tree = layui.tree;

      //渲染
      var inst1 = tree.render({
        elem: '#test1' //绑定元素
          ,
        data: <?php echo (json_encode($datas)) ?>,
        click: function(obj) {
          if (obj.data.pic_url) {
            console.log(obj.data); //得到当前点击的节点数据
            $('#image1').attr('src','../'+obj.data.dir+'/10001/'+obj.data.dir+'_'+obj.data.pic_url+'.jpg');
            $('#image2').attr('src','../'+obj.data.dir+'/10002/'+obj.data.dir+'_'+obj.data.pic_url+'.png');
            $('#image3').attr('src','../'+obj.data.dir+'/10003/'+obj.data.dir+'_'+obj.data.pic_url+'.jpg');
          }
        }
      });
    });
  </script>
  <style>
    html,
    body {
      height: 100%;
    }

    .layui-body {}

    .img {
      text-align: center;
      margin: 20px;
    }

    .layui-tree-txt {
      color: #fff;
    }
  </style>
</body>

</html>