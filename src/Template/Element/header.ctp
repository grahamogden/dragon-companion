<?php
$userIsLoggedIn = $this->request->getSession()->read('Auth.User');
?>
<header class="navbar navbar-dark bg-dark sticky-top navbar-expand-md p-2">
    <?= $this->Html->link(
        $this->Html->image('apple-icon/144.png', ['alt' => 'Dragon Companion']) . ' Dragon Companion',
        ['controller' => '', 'action' => 'index'],
        ['class' => 'navbar-brand', 'escape' => false]
    ); ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-1" aria-controls="navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <nav class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="<?= $this->Url->build(
                    ['controller' => '', 'action' => 'index']
                ) ?>" class="nav-link p-4 text-center"><i class="fa fa-home"></i>Home</a>
            </li>
            <?php if ($userIsLoggedIn) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link p-4 text-center dropdown-toggle" href="#" id="navbarPlayerCharacterDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-alt"></i>Players</a>
                    <ul class="dropdown-menu dropdown-menu-right p-0 text-center text-md-left" aria-labelledby="navbarPlayerCharacterDropdownMenuLink">
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(
                                ['controller' => 'PlayerCharacters', 'action' => 'index']
                            ) ?>" class="dropdown-link nav-link p-4"><i class="fa fa-user-edit"></i>Player
                                Characters</a>
                        </li>
                        <?php if (false) { ?>
                            <li class="nav-item">
                                <?= $this->Html->link(
                                    'Classes',
                                    ['controller' => 'PlayerCharacterClasses', 'action' => 'index'],
                                    ['class' => 'dropdown-link nav-link p-4']
                                ); ?>
                            </li>
                            <li class="nav-item">
                                <?= $this->Html->link(
                                    'Races',
                                    ['controller' => 'PlayerCharacterRaces', 'action' => 'index'],
                                    ['class' => 'dropdown-link nav-link p-4']
                                ); ?>
                            </li>
                        <?php } //endif ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link p-4 text-center dropdown-toggle" href="#" id="navbarMonsterDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-book-reader"></i>Dungeon
                        Masters</a>
                    <ul class="dropdown-menu dropdown-menu-right p-0 text-center text-md-left" aria-labelledby="navbarMonsterDropdownMenuLink">
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(
                                ['controller' => 'Clans', 'action' => 'index']
                            ) ?>" class="dropdown-link nav-link p-4"><i class="fa fa-users"></i>Clans</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(
                                ['controller' => 'Campaigns', 'action' => 'index']
                            ) ?>" class="dropdown-link nav-link p-4"><i class="fa fa-feather-alt"></i>Campaigns</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(
                                ['controller' => 'NonPlayableCharacters', 'action' => 'index']
                            ) ?>" class="dropdown-link nav-link p-4"><i class="fa fa-user-cog"></i>Non Playable
                                Characters</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(
                                ['controller' => 'CombatEncounters', 'action' => 'index']
                            ) ?>" class="dropdown-link nav-link p-4"><i class="fa fa-dice-d20"></i>Combat Tracker</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(
                                ['controller' => 'Monsters', 'action' => 'index']
                            ) ?>" class="dropdown-link nav-link p-4"><i class="fa fa-dragon"></i>Monsters</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(
                                ['controller' => 'Tags', 'action' => 'index']
                            ) ?>" class="dropdown-link nav-link p-4"><i class="fa fa-tags"></i>Tags</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <li class="nav-item dropdown">
                <a class="nav-link p-4 text-center dropdown-toggle" href="#" id="navbarAccountDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle"></i>Account</a>
                <ul class="dropdown-menu dropdown-menu-right p-0 text-center text-md-left" aria-labelledby="navbarAccountDropdownMenuLink">
                    <!-- <li><label class="dropdown-item text-center nav-link p-4" for="switch-dark-mode"><input type="checkbox" class="switch" id="switch-dark-mode" name="switch-dark-mode"<?= ($this->request->getCookie(
                        'darkMode'
                    ) ? 'checked="checked"' : ''); ?> />Switch Dark Mode</label></li> -->
                    <!-- <li class="nav-item"><a href="#" id="switch-header-slider">Enable Header Slider</a></li> -->
                    <?php if ($userIsLoggedIn) { ?>
                        <li><a href="<?= $this->Url->build(
                                ['controller' => 'Users', 'action' => 'logout']
                            ) ?>" class="dropdown-link nav-link p-4"><i class="fa fa-sign-out-alt"></i>Log out</a></li>
                    <?php } else { ?>
                        <li><a href="<?= $this->Url->build(
                                ['controller' => 'Users', 'action' => 'login']
                            ) ?>" class="dropdown-link nav-link p-4"><i class="fa fa-sign-in-alt"></i>Log in</a></li>
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