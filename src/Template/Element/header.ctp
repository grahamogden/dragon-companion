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
                    <?php if ($this->request->getSession()->read('Auth.User')) { ?>
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