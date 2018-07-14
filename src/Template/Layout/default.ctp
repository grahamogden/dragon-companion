<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    
    <?= $this->Html->script('http://code.jquery.com/jquery.min.js') ?>

    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('main.css') ?>

    <?= $this->Html->script('main.js') ?>
</head>
<body>
    <header>
        <div id="top-bar">
            <h1><?=$this->Html->link('Dragon Companion', ['controller' => '', 'action' => 'index'])?></h1>
            <div id="nav-menu-button">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
        </div>
        <nav>
            <!-- <ul class="title-area large-3 medium-4 columns"> -->
                <!-- <li class="name"> -->
                <!-- </li> -->
            <!-- </ul> -->
            <ul class="nav-list">
                <li>
                    <?php if ($this->request->session()->read('Auth.User')) { ?>
                        <?=$this->Html->link('Log out', ['controller' => 'Users', 'action' => 'logout'])?>
                    <?php } else { ?>
                        <?=$this->Html->link('Log in', ['controller' => 'Users', 'action' => 'login'])?>
                    <?php } ?>
                </li>
                <li>
                    <?=$this->Html->link('Timeline', ['controller' => 'TimelineSegments', 'action' => 'index'])?>
                </li>
                <li>
                    <?=$this->Html->link('Characters', ['controller' => 'Characters', 'action' => 'index'])?>
                </li>
            </ul>
        </nav>
        <div id="header-background"></div>
    </header>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
        <ul class="nav-list">
            <li><p>&copy; <?=(new DateTime)->format('Y')?></p></li>
            <li><a href="#">Contact Me</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Use</a></li>
            <li><a href="https://github.com/grahamogden/dragon-companion/issues">Feedback/Bug Report</a></li>
        </ul>
    </footer>
</body>
</html>