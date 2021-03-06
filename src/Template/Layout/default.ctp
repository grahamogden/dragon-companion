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
$bodyClasses = ['bg-secondary'];
if ($this->request->getCookie('darkMode')) {
    $bodyClasses[] = 'dark-mode';
}
?>
<!DOCTYPE html>
<html lang="en">
<?= $this->element('head') ?>
<body class="<?= implode(' ', $bodyClasses); ?>">
    <?= $this->element('header') ?>
    <?= $this->Flash->render() ?>
    <div class="container-fluid bg-white content-container content-shadow content-width-restriction">
        <?= $this->fetch('content') ?>
    </div>
<?= $this->element('footer') ?>
</body>
</html>