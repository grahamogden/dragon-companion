    <header>
        <div id="top-bar">
            <h1><?= $this->Html->link('Dragon Companion', ['controller' => '', 'action' => 'index']); ?></h1>
            <div id="nav-menu-button" class="menu-button">
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
                    <?= $this->Html->link('Timeline', ['controller' => 'TimelineSegments', 'action' => 'index']); ?>
                </li>
                <li>
                    <?= $this->Html->link('Tags', ['controller' => 'Tags', 'action' => 'index']); ?>
                </li>
                <li>
                    <?= $this->Html->link('Non Playable Characters', ['controller' => 'NonPlayableCharacters', 'action' => 'index']); ?>
                </li>
                <?php if ($this->request->getSession()->read('Auth.User')) { ?>
                    <li><a class="menu-button">Account</a>
                        <ul class="menu">
                            <li><label for="switch-dark-mode"><input type="checkbox" class="switch" id="switch-dark-mode" name="switch-dark-mode" />Switch Dark Mode</label></li>
                            <li><!-- <label for="switch-header-slider"><input type="checkbox" class="switch" id="switch-header-slider" name="switch-header-slider" /> --><a href="#" id="switch-header-slider">Enable Header Slider</a><!-- </label> --></li>
                            <li><?= $this->Html->link('Log out', ['controller' => 'Users', 'action' => 'logout']); ?></li>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li><?= $this->Html->link('Log in', ['controller' => 'Users', 'action' => 'login']); ?></li>
                <?php } ?>
            </ul>
        </nav>
        <div id="header-background"></div>
    </header>
    <?= $this->Flash->render() ?>
    <?= $this->element('breadcrumbs'); ?>