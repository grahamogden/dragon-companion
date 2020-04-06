<?php
$userIsLoggedIn = $this->request->getSession()->read('Auth.User');
?>
    <header class="navbar navbar-dark bg-dark sticky-top navbar-expand-md p-2">
        <?= $this->Html->link($this->Html->image('apple-icon/144.png', ['alt'=>'Dragon Companion']) . ' Dragon Companion', ['controller' => '', 'action' => 'index'], ['class'=>'navbar-brand', 'escape' => false]); ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-1" aria-controls="navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <nav class="collapse navbar-collapse" id="navbar-collapse-1">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?= $this->Html->link('Home', ['controller' => '', 'action' => 'index'], ['class' => 'nav-link text-center']); ?>
                </li>
                <?php if ($userIsLoggedIn) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-center dropdown-toggle" href="#" id="navbarPlayerCharacterDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Players</a>
                        <ul class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="navbarPlayerCharacterDropdownMenuLink">
                            <li class="nav-item">
                                <?= $this->Html->link('Player Characters', ['controller' => 'PlayerCharacters', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                            </li>
                            <?php if (false) { ?>
                                <li class="nav-item">
                                    <?= $this->Html->link('Classes', ['controller' => 'PlayerCharacterClasses', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                                </li>
                                <li class="nav-item">
                                    <?= $this->Html->link('Races', ['controller' => 'PlayerCharacterRaces', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                                </li>
                            <?php } //endif ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-center dropdown-toggle" href="#" id="navbarMonsterDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dungeon Masters</a>
                        <ul class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="navbarMonsterDropdownMenuLink">
                            <li class="nav-item">
                                <?= $this->Html->link('Clans', ['controller' => 'Clans', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('Campaigns', ['controller' => 'TimelineSegments', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('Non Playable Characters', ['controller' => 'NonPlayableCharacters', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('Combat Encounters', ['controller' => 'CombatEncounters', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('Monsters', ['controller' => 'Monsters', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('Named Monsters', ['controller' => 'MonsterInstances', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link('Tags', ['controller' => 'Tags', 'action' => 'index'], ['class' => 'dropdown-link nav-link text-center']); ?>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link text-center dropdown-toggle" href="#" id="navbarAccountDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                    <ul class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="navbarAccountDropdownMenuLink">
                        <!-- <li><label class="dropdown-item text-center nav-link" for="switch-dark-mode"><input type="checkbox" class="switch" id="switch-dark-mode" name="switch-dark-mode"<?= ($this->request->getCookie('darkMode') ? 'checked="checked"' : ''); ?> />Switch Dark Mode</label></li> -->
                        <!-- <li class="nav-item"><a href="#" id="switch-header-slider">Enable Header Slider</a></li> -->
                        <?php if ($userIsLoggedIn) { ?>
                            <li><?= $this->Html->link('Log out', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'dropdown-link text-center nav-link']); ?></li>
                        <?php } else { ?>
                            <li><?= $this->Html->link('Log in', ['controller' => 'Users', 'action' => 'login'], ['class' => 'dropdown-link text-center nav-link']); ?></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container p-0">
        <?= $this->Flash->render() ?>
    </div>
    <div class="container bg-white p-0">
        <?= $this->element('breadcrumbs'); ?>
    </div>