<?php
include_once('./includes/dbopen.php');
include_once('./includes/common.php');

$err_num = 0;
$err_msg = "";

$list_param = $_REQUEST["list_param"];
$list_param = str_replace("^^", "&", $list_param);
$BoardContentID = $_REQUEST["boardcontentid"];
$CheckSumRequest = $_COOKIE["BoardCheckSum"];
$CheckSumResult = md5($BoardContentID);
setcookie("BoardCheckSum","");


$sql = "select BoardID from BoardContents where BoardContentID=$BoardContentID";
$rs = mysql_query($sql);
$BoardID = current(mysql_fetch_array($rs));


if ($CheckSumRequest==$CheckSumResult){
	$sql = "update BoardContents set BoardContentState=0 where BoardContentID=$BoardContentID";
	mysql_query($sql);
}else{
	$err_num = 1;
	$err_msg = "잘못된 접근 입니다.";
}



if ($err_num != 0){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo _SITE_TITLE_;?></title>
<link rel="icon" href="uploads/favicons/<?php echo _SITE_FAVICON_;?>">
<link rel="shortcut icon" href="uploads/favicons/<?php echo _SITE_FAVICON_;?>" />
</head>
<body>
<script>
alert("<?=$err_msg?>");
history.go(-1);
</script>
</body>
</html>
<?php
}

include_once('./includes/dbclose.php');


if ($err_num == 0){
	if ($BoardID==13 || $BoardID==14 || $BoardID==15) {// 시설현황, 조사현황, 인증사업자
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo _SITE_TITLE_;?></title>
<link rel="icon" href="uploads/favicons/<?php echo _SITE_FAVICON_;?>">
<link rel="shortcut icon" href="uploads/favicons/<?php echo _SITE_FAVICON_;?>" />
</head>
<body>
<script>
alert("삭제했습니다.");
parent.location.reload();
</script>

<?
include_once('./includes/common_analytics.php');
?>
</body>
</html>
<?
	}else if ($BoardID==12) {// 코칭
		header("Location: mypage.php");
		exit;
	}else{
		header("Location: board_list.php?$list_param");
		exit;
	}
}
?>


