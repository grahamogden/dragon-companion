/*
 * COMBAT ENCOUNTERS
 * 
 * Combat is made up of two parts:
 * - Initiative
 * - Looping rounds of combat
 * 
 * Initiative
 * All playable characters and monsters roll and include their speed to provide them with a
 * number that represents their _order in combat_, known as initiative.
 *
 * Combat
 * This is a loop of rounds, each round being comprised of each character having the opportunity
 * for combat - meaning a character could wait until later in the round or completely skip the round entirely
 *
 * Turns Combat
 * A turn in combat is made up of a few different components, here are a few of them:
 * - Action
 *   = Attack - one source attacks a single or multiple targets
 *   = Heal - one source replenishes the health of a single or multiple targets
 *   = Opportunity Attacks - when one source attacks a target or moves away from a target,
 *   the target may have the opportunity to attack the source
 * - Movement
 * - Bonus action
 * - Reaction (although not necessarily during your turn) - such as opportunity attacks
 *
 * There are plenty of additional things that can be done during a turn of combat, but let us
 * focus on delivering specific things, one at a time!
 * - 
 */

const updateParticipantJson = function($) {
    let participantsJson = JSON.parse($('#participants').val());
    // let $element = $(this);
console.log(participantsJson);
    $.each(participantsJson.playerCharacters, function(index, playerCharacter) {
        playerCharacter.data.starting_hit_points = $('#participant-starting-hit-points-' + playerCharacter.data.tempId).val();
        playerCharacter.data.initiative = $('#participant-initiative-' + playerCharacter.data.tempId).val();
    });

    $.each(participantsJson.monsters, function(index, monster) {
        monster.data.starting_hit_points = $('#participant-starting-hit-points-' + monster.data.tempId).val();
        monster.data.initiative = $('#participant-initiative-' + monster.data.tempId).val();
    });

    $('#participants').val(JSON.stringify(participantsJson));
};

jQuery(function ($) {
    const addTableRow = function (index, participant, $tableBody) {
        let randomiserIcon        = '<i class="fas fa-dice-d20 link-fa">';
        let initiativeInput       = '<input type="text" inputmode="number" id="participant-initiative-' + participant.data.tempId + '" class="participant-initiative" name="participant-initiative[]" value="" pattern="[0-9]*" data-participant-temp-id="' + participant.data.tempId + '" onkeyup="updateParticipantJson(jQuery, ' + participant.data.tempId + ')" placeholder="(' + participant.data.dexterity_modifier + ')" />';
        let startingHitPointInput = '<input type="text" inputmode="decimal" id="participant-starting-hit-points-' + participant.data.tempId + '" class="participant-starting-hit-points" name="participant-starting-hit-points[]" value="" data-participant-temp-id="' + participant.data.tempId + '" onkeyup="updateParticipantJson(jQuery, ' + participant.data.tempId + ')" placeholder="' + participant.data.max_hit_points + '" />';

        let tableCells =
                '<td>' + participant.data.name + '</td>' +
                '<td>' + initiativeInput + randomiserIcon + '</i></td>' +
                '<td>' + participant.data.armour_class + '</td>' +
                '<td>' + startingHitPointInput + randomiserIcon + '</td>';

        $($tableBody).append('<tr>' + tableCells + '</tr>');
    };

    const setTempId = function (entity, tempId) {
        entity.data.tempId = tempId;
        return ++tempId;
    };

    $('.update-participants').on('click', function (event) {
        console.time('updateParticipants');
        let participants      = {
            playerCharacters: JSON.parse($('#player-characters').val()),
            monsters: JSON.parse($('#monsters').val()),
        };
        let tempParticipantId = 1;
        console.log(participants);

        let $tableBody = $('#initiative-table tbody');
        $($tableBody).html('');
        // Table is made up of 4 columns - Name, Initiative, AC, HP
        $.each(participants.playerCharacters, function (index, playerCharacter) {
            tempParticipantId = setTempId(playerCharacter, tempParticipantId);
            addTableRow(index, playerCharacter, $tableBody)
        });

        let monsters = {};

        $.each(participants.monsters, function (index, monster) {
            if (monster.data.monster_instance_type_id === 1) {
                monsters[monster.data.id] = ++monsters[monster.data.id] || 1;
                console.log(monsters);
                monster.data.name += ' ' + monsters[monster.data.id];
            }

            tempParticipantId = setTempId(monster, tempParticipantId);
            console.log(monster.data);
            addTableRow(index, monster, $tableBody)
        });

        $('#participants').val(JSON.stringify(participants));
        console.timeEnd('updateParticipants');
    });
});