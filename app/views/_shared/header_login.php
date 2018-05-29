<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= ROOT_URI ?>img/favicon.png">
    <title>Smart Space</title>
    <!-- Bootstrap core CSS -->

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="<?= ROOT_URI ?>css/animate.min.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/timeline.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/cover.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/forms.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/buttons.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/login_register.css" rel="stylesheet">
    <link href="<?=ROOT_URI?>css/styles.css" rel="stylesheet">
    
    <script>
        <?php
        $current_user=$_SESSION['current_user'];
        $router = \App\lib\App::getRouter();?>
        const ROOT_URI = '<?=ROOT_URI?>'
        const PER_PAGE = '<?=\App\lib\Config::get('per_page')?>'
        const COMMETNS_PER_PAGE = '<?=\App\lib\Config::get('comments_per_page')?>'
        const CURRENT_USER_ID = '<?=$current_user['id']?>'
        const CURRENT_USER_NAME = '<?=$current_user['first_name'] . " " .$current_user['last_name']?>'
        const CURRENT_USER_IMG = '<?=$current_user['path']?>'
        const ROUTER = {
            controller: '<?=strtolower($router->getControllerName())?>',
            action: '<?=$router->getActionName()?>',
            params: JSON.parse('<?=json_encode($router->getParams())?>'),
        }
    </script>
</head>

<body>

<script src="<?= ROOT_URI; ?>js/pages/fblogin.js"></script>






