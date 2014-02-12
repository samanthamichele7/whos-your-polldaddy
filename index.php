<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Who's Your Polldaddy Example</title>
</head>
<body>
  

<?php 

  require_once("WYPD.class.php");

  $WYPD = new WhosYourPolldaddy("YOUR_API_KEY"); ?>

  <script type="text/javascript" charset="utf-8" src="http://static.polldaddy.com/p/<?php echo $WYPD->getLatestPoll(); ?>.js"></script>

</body>
</html>