<?php
$this->layout = false;
$title = 'Dragon Companion - The one and only Companion app for playing role playing games!';
?>
<!DOCTYPE html>
<html>
<?= $this->element('head') ?>
<body class="home bg-light">
<?= $this->element('header') ?>
    <div class="container bg-white content-container">
        <?= $this->Flash->render() ?>
        <h1>Welcome to Dragon Companion!</h1>
        <div>
            <p>This is the one and only companion app to help you and your group play role playing games! Currently, it features:</p>
            <ul>
                <li>Timeline - this will help you with planning out and writing your story by splitting everything into chucks!</li>
                <li>NPC archive - an area for you to write up details for your NPCs</li>
                <li>Dungeon Maps - create a tile-by-tile map of your dungeon and let your players walk around</li>
            </ul>
            <p>I have plenty of other ideas for things to add in the future:</p>
            <ul>
                <li>Character Creation - create each of the characters from your group and track all of their stats and numbers as you play the game</li>
                <li>Combat Tracker - use your characters in the combat tracker to keep all of the bits of combat ticking over whilst you focus on the fun of battle!</li>
                <li>Mini game mode - as the name implies, making a mini game available so that you can play it in the same room or across the globe powered by Phaser!</li>
                <li>Session Diary - to keep all of your session notes in a public area that your group can read without them finding juicy secrets that you might have put into the timeline segments!</li>
                <li>Many, many more to come...</li>
            </ul>
            <p>To access these amazing features, you will need to register/log in - we wouldn&apos;t want your players coming here and seeing all of the juicy things your working on, would we!</p>
        </div>
    </div>
    <?= $this->element('footer') ?>
</body>
</html>
