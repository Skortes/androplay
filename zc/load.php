<?
include_once '../system/sys.php';
include '../system/funcs.php';
$set = DB::$dbs->queryFetch("SELECT * FROM `set_modul`");
if($set['zc']==0){header('location:../');}
$dir_id = (int)$_GET['id'];
if($func->getCount("id","`zc` where `id` = '$dir_id' and `type` = '2'") == 1){
$dir = DB::$dbs->query("select * from `zc` where `id` = '$dir_id' limit 1")->fetch();

DB::$dbs->query("update `zc` set `loads` = `loads` + '1' where `id` = '$dir_id' and `type` = '2'");

header("location: /zc/downloads/$dir[root_path]$dir[root_name]");
} else {
verh();
echo "Access Denied!";
niz();
}
?>