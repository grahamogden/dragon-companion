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

$breadcrumbs = $this->element('breadcrumbs');
$flashMessages = $this->Flash->render();
$bodyClasses = [];
if ($this->getRequest()->getCookie('darkMode')) {
    $bodyClasses[] = 'dark-mode';
}
?>
<!DOCTYPE html>
<html lang="en">
<?= $this->element('head') ?>
<body class="<?= implode(' ', $bodyClasses); ?>">
    <?= $this->element('header') ?>
    <div class="container-fluid content-container content-shadow content-width-restriction background-colour-primary">
        <?php if ($flashMessages) { ?>
            <div class="container-fluid content-width-restriction p-0">
                <?= $flashMessages ?>
            </div>
        <?php } // endif ?>
        <?php if ($breadcrumbs) { ?>
            <div class="container-fluid content-width-restriction p-0 mb-4">
                <?= $breadcrumbs ?>
            </div>
        <?php } // endif ?>
        <?= $this->fetch('content') ?>
    </div>
<?= $this->element('footer') ?>
</body>
</html>
