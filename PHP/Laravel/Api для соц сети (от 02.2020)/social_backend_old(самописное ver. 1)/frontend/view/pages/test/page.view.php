<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$data['site_name']?></title>
    <link rel="stylesheet" href="<?=asset('css/test/app.css')?>" type="text/css"/>
    <script src="<?=asset('js/test/app.js')?>" defer></script>
</head>
<body>
<?echo "<pre>";
print_r($data);
echo "</pre>";
?>
    <h1>Home Page</h1>
    <div id="app"></div>
</body>
</html>