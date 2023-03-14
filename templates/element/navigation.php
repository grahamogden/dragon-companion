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
            <nav class="background-colour-secondary sidebar side-nav col-2 col-md-4 col-lg-2 d-lg-flex d-md-flex d-none">
                <ul class="nav nav-sidebar">
                    <?php if (null !== $user && $user->id) { ?>
<!--                        <li class="nav-item col-12">-->
                            <li class="nav-item p-0 pt-4 pb-4 col-12" href="#"><i class="fa fa-user-alt"></i>For Players</li>
<!--                            <ul class="p-0 text-center text-md-left border-colour-primary nav">-->
                                <li class="nav-item col-12">
                                    <a href="<?= $this->Url->build(
                                        ['controller' => 'PlayerCharacters', 'action' => 'index']
                                    ) ?>" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-user-edit"></i>Player
                                        Characters</a>
                                </li>
                                <?php if (false) { ?>
                                    <li class="nav-item">
                                        <?= $this->Html->link(
                                            'Classes',
                                            ['controller' => 'PlayerCharacterClasses', 'action' => 'index'],
                                            ['class' => 'dropdown-link nav-link p-0 pt-4 pb-4']
                                        ); ?>
                                    </li>
                                    <li class="nav-item">
                                        <?= $this->Html->link(
                                            'Races',
                                            ['controller' => 'PlayerCharacterRaces', 'action' => 'index'],
                                            ['class' => 'dropdown-link nav-link p-0 pt-4 pb-4']
                                        ); ?>
                                    </li>
                                <?php } //endif ?>
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li class="nav-item col-12">-->
                            <li class="nav-item p-0 pt-4 pb-4 col-12" href="#"><i class="fa fa-book-reader"></i>For Dungeon Masters</li>
<!--                            <ul class="p-0 text-center text-md-left border-colour-primary nav">-->
                                <?php if ($selectedCampaign && $selectedCampaign->id) { ?>
                                    <li class="nav-item col-12">
                                        <a href="<?= $this->Url->build(
                                            ['controller' => 'Campaigns', 'action' => 'edit', 'id' => $selectedCampaign['id']]
                                        ) ?>" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-feather-alt"></i>Edit <?= $selectedCampaign['name'] ?></a>
                                    </li>
                                    <li class="nav-item col-12">
                                        <a href="<?= $this->Url->build(
                                            ['controller' => 'Campaigns', 'action' => 'index']
                                        ) ?>" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-exchange-alt"></i>Switch Campaigns</a>
                                    </li>
                                    <li class="nav-item col-12">
                                        <a href="<?= $this->Url->build(
                                            ['controller' => 'TimelineSegments', 'action' => 'index']
                                        ) ?>" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-hourglass"></i>Timeline</a>
                                    </li>
        <!--                            <li class="nav-item">-->
        <!--                                <a href="--><?//= $this->Url->build(
        //                                     ['controller' => 'Clans', 'action' => 'index']
        //                                 ) ?><!--" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-users"></i>Clans</a>-->
        <!--                            </li>-->
                                    <li class="nav-item col-12">
                                        <a href="<?= $this->Url->build(
                                            ['controller' => 'NonPlayableCharacters', 'action' => 'index']
                                        ) ?>" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-user-cog"></i>Non Playable
                                            Characters</a>
                                    </li>
                                    <li class="nav-item col-12">
                                        <a href="<?= $this->Url->build(
                                            ['controller' => 'CombatEncounters', 'action' => 'index']
                                        ) ?>" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-dice-d20"></i>Combat Tracker</a>
                                    </li>
                                    <li class="nav-item col-12">
                                        <a href="<?= $this->Url->build(
                                            ['controller' => 'Monsters', 'action' => 'index']
                                        ) ?>" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-dragon"></i>Monsters</a>
                                    </li>
                                    <li class="nav-item col-12">
                                        <a href="<?= $this->Url->build(
                                            ['controller' => 'Tags', 'action' => 'index']
                                        ) ?>" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-tags"></i>Tags</a>
                                    </li>
                                <?php } else { ?>
                                    <li class="nav-item col-12">
                                        <a href="<?= $this->Url->build(
                                            ['controller' => 'Campaigns', 'action' => 'index']
                                        ) ?>" class="dropdown-link nav-link p-0 pt-4 pb-4"><i class="fa fa-feather-alt"></i>Campaigns</a>
                                    </li>
                                <?php } ?>
<!--                            </ul>-->
<!--                        </li>-->
                    <?php } ?>
                </ul>
            </nav>
