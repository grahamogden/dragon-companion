<head>
    <?= $this->Html->charset() ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no,shrink-to-fit=no" />
    <!-- <link rel="apple-touch-icon" href="/img/icons/HTML5_Badge_64.png" /> -->
    <title>
        <?= trim('Dragon Companion - ' . ($title ?? $this->fetch('title'))) ?>
    </title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <script src="https://kit.fontawesome.com/c68e483c7b.js" crossorigin="anonymous"></script>

    <link rel="apple-touch-icon" sizes="57x57" href="/img/apple-icon/57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/img/apple-icon/72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/img/apple-icon/114.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/img/apple-icon/144.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/img/apple-icon/144.png" />

    <link rel="shortcut icon" href="/img/apple-icon/favicon.png" type="image/x-icon">
    <link rel="icon" href="/img/apple-icon/favicon.png" type="image/x-icon">

    <!-- <?= $this->Html->meta('icon') ?> -->

    <?= $this->fetch('meta') ?>

    <?= $this->fetch('css') ?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- <?= $this->Html->css('base.css') ?> -->
    <?= $this->Html->css('main.css') ?>
    
    <?= $this->Html->script('libs/jquery-3.3.1.min.js') ?>
    <?= $this->Html->script('libs/jquery-ui.min.js') ?>
    <?= $this->Html->script('libs/tinymce/tinymce.min.js') ?>
    <?= $this->fetch('script') ?>
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <?= $this->Html->script('main.js') ?>
    <?= $this->Html->script('textarea-editor.js') ?>

</head>