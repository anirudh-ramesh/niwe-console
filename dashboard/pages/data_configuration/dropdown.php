<!DOCTY8PE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<form name="form" method="POST" action="<?=$PHP_SELF?>">
  <select name="number" onchange="this.form.submit();" method="post">
    <option value="">Select Staion</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
  </select>
</form>
<?PHP
  $num = $_POST['number'];
  $number = trim($num);
  if(!isset($num)){
print "Please select from the menu";
} else{
print $number;


}
?>
</body>
</html>