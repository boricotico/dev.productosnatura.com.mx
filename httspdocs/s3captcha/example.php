<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>s3Capcha jQuery plugin</title>
<meta name="keywords" content="s3Capcha jQuery plugin" />
<meta name="description" content="s3Capcha jQuery plugin" />

<style type="text/css">
#capcha div {
    float: left;
} 
</style>
<!-- JavaScripts-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/s3Capcha.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#capcha').s3Capcha();
    });
</script>

</head>

<body>
    <form name="demo" action="verify.php" method="post">
	    <div id="capcha"> <?php include("s3Capcha.php"); ?> </div><br /><br /><br />
        <input type="submit" value="Submit" />
    </form>
</body>
</html>