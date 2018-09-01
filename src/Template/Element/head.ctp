<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <link rel="apple-touch-icon" href="/img/icons/HTML5_Badge_64.png" />
    <title>
        <?= $this->fetch('title') ?>
    </title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="/img/apple-icon/57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/img/apple-icon/72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/img/apple-icon/114.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/img/apple-icon/144.png" />

    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    
    <?= $this->Html->script('libs/jquery-3.3.1.min.js') ?>
    <?= $this->Html->script('libs/jquery-ui.min.js') ?>

    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('main.css') ?>

    <?= $this->Html->script('main.js') ?>
</head>