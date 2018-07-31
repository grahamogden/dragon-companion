<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <link rel="apple-touch-icon" href="/img/icons/HTML5_Badge_64.png" />
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    
    <?= $this->Html->script('libs/jquery-3.3.1.min.js') ?>
    <?= $this->Html->script('libs/jquery-ui.min.js') ?>

    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('main.css?'.filemtime('css/main.css')) ?>

    <?= $this->Html->script('main.js') ?>
</head>