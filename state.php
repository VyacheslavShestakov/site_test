<html>
 <head>
  <title>¯\_(ツ)_/¯ <<Stats>></title>
 </head>
<style type="text/css">
.tftable {font-size:12px;color:#333333;width:100%;border-width: 2px;border-color: #a9a9a9;border-collapse: collapse;}
.tftable th {font-size:12px;background-color:#b8b8b8;border-width: 2px;padding: 8px;border-style: solid;border-color: #a9a9a9;text-align:left;}
.tftable tr {background-color:#cdcdcd;}
.tftable td {font-size:12px;border-width: 6px;padding: 8px;border-style: solid;border-color: #a9a9a9;}
.tftable tr:hover {background-color:#ffffff;}
</style>

<?php 
#header('refresh: 10');
?>

<table class="tftable" border="2">

<tr><td><div style="width:auto;height:auto">

<?php
#--------------Список клиентов архива----------------------------------------------------------------------------
$dir = '/home/arch/iptv_archive/clients';
$f = scandir($dir);

$fi = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
$fileCount = iterator_count($fi);

echo '<b>', 'Пользователи архива  (', $fileCount, ')','</b>', '<br/>', '<br/>';

foreach ($f as $file){
    if(preg_match('/\.(txt)/', $file)){
        echo $file.'<br/>';
    }
}
?>
</div>
</td>


<td>
<?php
#-----------------Состояние сервера---------------------------------------------------------------------------------
$load = sys_getloadavg();
echo '<b>','Load Average:   ','</b>'.$load[0].' - '.$load[1].' - '.$load[2].'<br/>';

#----------------------------------------------------------------------
$data = shell_exec('uptime');
$uptime = explode(' up ', $data);
$uptime = explode(',', $uptime[1]);
$uptime = $uptime[0].', '.$uptime[1];
echo '<b>','Server uptime: ', '</b>'.$uptime.'<br/>';
#------------------------------------------------------------------------

  $fh = fopen('/proc/meminfo','r');
  $mem = 0;
  while ($line = fgets($fh)) {
    $pieces = array();
    if (preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $pieces)) {
      $mem = $pieces[1];
      break;
    }
  }
  fclose($fh);

  echo '<b>','RAM free(kb):   ','</b>'.$mem.'<br/>';

echo '--------------------------------------------------------------------------------------------------';
#----------------------------------------------------------------------

$df = shell_exec("df -h | grep '/dev/sda2 \|Filesystem'");
echo "<pre>$df</pre>";
?>
</td></tr>








<tr><td colspan="2"><div style="width:1600px;height:auto;overflow:scroll">
<?php
# ------------Вывод текущих процессов FFmpeg-------------------------------------------------------------------
$psax = shell_exec('ps ax | grep ffmpeg');
echo "<pre>$psax</pre>";
?>
</div></td></tr>




<tr><td colspan="2"><h3 style="text-align: left; color: #2F4F4F;"><span style="border-bottom: 3px solid #000000;">ERROR LOG:</span></h3></td></tr>
<tr><td colspan="2"><div style="width:100%;height:500px;overflow:scroll">
<?php
# ------------Вывод лога ошибок--------------------------------------------------------------------------------
$search = 'елепрограмм';
$datelog = date("Y-m-d");
$file = '/home/arch/iptv_archive/logs/logfile-'.$datelog.'.log';
$arr = array_reverse(file($file));
$count = count($arr);

#echo $date;
#$arr = array_slice($arr, -40);
foreach($arr as $num_line => $arr_value)
{

if(strpos($arr_value, $search) == FALSE)
{
        echo  $arr_value, '<br />';
    }
}

#for ($i = 0; $i < $count; $i++) {
#    echo htmlspecialchars($arr[$i]), '<br />';
#}
?>
</div></td></tr>

</table>
</html>