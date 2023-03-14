<?php

use App\Application;
use App\Model\Entity\Campaign;
use App\Model\Entity\User;

/** @var App\View\AppView $this */

$session = $this->request->getSession();
/** @var User|false|null $user */
$user = $session->read('Auth');
/** @var Campaign $selectedCampaign */
$selectedCampaign = $session->read(Application::SESSION_KEY_CAMPAIGN);
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
            <li class="nav-item dropdowdn">
                <a class="nav-link p-4 text-center dropdown-toggle" href="#" id="navbarAccountDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle"></i>Account</a>
                <ul class="dropdown-menu dropdown-menu-right p-0 text-center text-md-left border-colour-primary" aria-labelledby="navbarAccountDropdownMenuLink">
                     <li><label class="dropdown-item text-center nav-link p-4" for="switch-dark-mode"><input type="checkbox" class="switch" id="switch-dark-mode" name="switch-dark-mode"<?= ($this->request->getCookie('darkMode') ? 'checked="checked"' : ''); ?> />Switch Dark Mode</label></li>
                    <!-- <li class="nav-item"><a href="#" id="switch-header-slider">Enable Header Slider</a></li> -->
                    <?php if (null !== $user && $user->id) { ?>
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
