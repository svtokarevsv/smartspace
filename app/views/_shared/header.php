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
    <title><?php echo $data['headTitle'] ?> | Smart Space</title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="<?= ROOT_URI ?>css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
    <link href="<?= ROOT_URI ?>css/timeline.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/cover.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/friends.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/forms.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/buttons.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/profile_wall.css" rel="stylesheet">
    <link href="<?= ROOT_URI ?>css/styles.css" rel="stylesheet">

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
    <script src="<?= ROOT_URI ?>js/helpers.js" defer></script>
    <script src="<?= ROOT_URI; ?>js/_shared/header.js" defer></script>

</head>

<body class="animated fadeIn" style="">

<!-- Fixed navbar -->
<header id="header" class="ss-header">
    <nav class="navbar navbar-default navbar-fixed-top menu">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= ROOT_URI ?>"><img src="<?= ROOT_URI ?>img/logo.svg" alt="logo"/></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse ss-header__navbar" id="bs-example-navbar-collapse-1">
                <form class="navbar-form navbar-left" action="<?=ROOT_URI?>search" method="get">
                    <div class="form-group">
                        <i class="fa fa-search"></i>
                        <input type="text" class="form-control ss-header__search"
                               placeholder="Search friends, groups, events" name="search">
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right main-menu">
                    <li class="dropdown">
                        <a href="<?= ROOT_URI ?>">Newsfeed</a>
                    </li>
                    <li class="dropdown">
                        <a href="<?= ROOT_URI ?>messages">Messages
                            <span class="label label-info pull-right r-activity new-message-notification"></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="<?= ROOT_URI ?>friends">Friends</a>
                    </li>
                   <!-- <li class="dropdown">
                        <a href="<?/*= ROOT_URI */?>posts">My posts</a>
                    </li>
                    <li class="dropdown">
                        <a href="<?/*= ROOT_URI */?>groups">My groups</a>
                    </li>-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle pages" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <img class="ss-header__avatar" src="<?= ROOT_URI . $_SESSION['current_user']['path']
                            ?>"
                                    alt="<?= ROOT_URI . $_SESSION['current_user']['first_name'] ?>">
                            <span>
                                <img src="<?= ROOT_URI ?>img/down-arrow.png" alt=""/>
                            </span>
                        </a>
                        <ul class="dropdown-menu page-list">
                            <?php if ($_SESSION['current_user']['role_id'] == 1){?>
                                <li><a href="<?= ROOT_URI ?>profile">My profile</a></li>
                            <?php } else if ($_SESSION['current_user']['role_id'] == 2){ ?>
                                <li><a href="<?= ROOT_URI ?>BusinessProfile">My profile</a></li>
                            <?php
                            }?>
                            <li><a href="<?= ROOT_URI ?>logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
    </nav>
</header>
<div class="container page-content ">
    <div class="row">



