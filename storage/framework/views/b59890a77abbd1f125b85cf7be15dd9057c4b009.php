<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blush.Digital CRM System">
    <meta name="author" content="Blush.Digital">
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo Config::get('system.name.plain'); ?></title>
    <link href="/css/vendor.css" rel="stylesheet" type="text/css" />
    <link href="/css/app.css" rel="stylesheet" type="text/css" />
    <link href="/css/additional-styles.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="icon" type="image/ico" href="<?php echo e(asset('/img/favicon.ico')); ?>">
    <link rel="shortcut-icon" type="image/ico" href="<?php echo e(asset('/img/favicon.ico')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('/img/touch-icon-iphone.png')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('/img/touch-icon-ipad.png')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('/img/touch-icon-iphone-retina.png')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('/img/touch-icon-ipad-retina.png')); ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Blush.Digital">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        if (navigator.userAgent.match(/(iPad|iPhone|iPod|Android|Silk)/gi))
            document.title = "Blush.Digital";
    </script>
</head>
<body class="fixed-left">
<div id="wrapper">
    <div class="animationload">
        <div class="loader"></div>
    </div>

    <?php echo $__env->yieldContent('body'); ?>
</div>
<script>
    var resizefunc = [];
</script>

<script src="/js/app.js"></script>

<?php echo $__env->yieldContent('footer'); ?>

<script type="application/javascript">
    setupPage();
</script>

</body>
</html>
