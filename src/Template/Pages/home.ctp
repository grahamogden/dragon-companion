<?php
$this->layout = false;

$title = 'Dragon Companion - The one and only Companion app for playing Dungeons and Dragons';
?>
<!DOCTYPE html>
<html>
<?= $this->element('head') ?>
<body class="home">

<?= $this->element('header') ?>

    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <!-- <?= $this->fetch('content') ?> -->

        <div class="row">
            <p>
                This is the one and only Dungeons and Dragons companion app to help you and your group play the game! It features all kinds of sweet features (some coming soon):
            </p>
            <ul>
                <li>Timeline - this will help you with writing out your story in chucks split up in ways that I like to call the Cirlce-Arc-Segmeent methodology!</li>
                <li>Character Creation <sup>(TBC)</sup> - create each of the characters from your group and track all of their stats and numbers as you play the game</li>
                <li>Combat Tracker <sup>(TBC)</sup> - use your characters in the combat tracker to keep all of the bits of combat ticking over whilst you focus on the fun of battle!</li>
                <li>Many, many more to come...</li>
            </ul>
        </div>

    </div>

    <?= $this->element('footer') ?>
</body>
</html>
