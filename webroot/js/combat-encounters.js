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

const participantTypePlayerCharacter = 1;
const participantTypeMonster         = 2;

const updateParticipantData = function ($) {
    $.each(combatEncounter.getParticipants(), function (index, participant) {
        participant.setStartingHitPoints(parseInt(
                $('#participant-starting-hit-points-' + participant.getTempId()).val()
            )
        );

        participant.setInitiative(parseInt(
                $('#participant-initiative-' + participant.getTempId()).val()
            )
        );
    });

    $('#participants').val(JSON.stringify(combatEncounter.getParticipants()));
};

const randomiser = function ($, self, max, modifier) {
    // console.log($(self));
    let rand = Math.floor(Math.random() * max + modifier);
    // console.log(rand);
    $(self).siblings('input').val(rand).change();

    updateParticipantData($);
};

class Participant {

    constructor (
        id,
        name,
        armourClass,
        maxHitPoints,
        dexterityModifier/*,
         startingHitPoints,
         initiative*/
    ) {
        this.id                = id;
        this.name              = name;
        this.armourClass       = armourClass;
        this.maxHitPoints      = maxHitPoints;
        this.dexterityModifier = dexterityModifier;
        // this.startingHitPoints = startingHitPoints;
        // this.initiative        = initiative;
        this._createTempId();
    }

    getId () {
        return this.id;
    }

    getName () {
        return this.name;
    }

    getArmourClass () {
        return this.armourClass;
    }

    getMaxHitPoints () {
        return this.maxHitPoints;
    }

    getDexterityModifier () {
        return this.dexterityModifier;
    }

    getTempId () {
        return this.tempId;
    }

    getStartingHitPoints () {
        return this.startingHitPoints;
    }

    setStartingHitPoints (startingHitPoints) {
        this.startingHitPoints = startingHitPoints;
    }

    getInitiative () {
        return this.initiative;
    }

    setInitiative (initiative) {
        this.initiative = initiative;
    }

    _createTempId () {
        // Create a number between 1 and 100,000,000
        this.tempId = Math.floor(Math.random() * 99999999 + 1);
    }

    /*toString () {
     return {
     name: this.name,
     armourClass: this.armourClass,
     maxHitPoints: this.maxHitPoints,
     dexterityModifier: this.dexterityModifier,
     startingHitPoints: this.startingHitPoints,
     initiative: this.initiative,
     tempId: this.tempId
     }.toString();
     }*/
}

class PlayerCharacter extends Participant {
}

class Monster extends Participant {

    constructor (
        id,
        name,
        armourClass,
        maxHitPoints,
        dexterityModifier,
        // startingHitPoints,
        // initiative,
        monsterInstanceTypeId
        // tempId
    ) {
        super(
            id,
            name,
            armourClass,
            maxHitPoints,
            dexterityModifier/*,
             startingHitPoints,
             initiative*/
        );
        this.monsterInstanceTypeId = monsterInstanceTypeId;
    }

    getMonsterInstanceTypeId () {
        return this.monsterInstanceTypeId;
    }

    /*toString () {
     return {
     name: this.name,
     armourClass: this.armourClass,
     maxHitPoints: this.maxHitPoints,
     dexterityModifier: this.dexterityModifier,
     startingHitPoints: this.startingHitPoints,
     initiative: this.initiative,
     tempId: this.tempId,
     monsterInstanceTypeId: this.monsterInstanceTypeId
     }.toString();
     }*/
}

class TableHelper {
    // var $table;
    // var $tableBody;

    constructor (table) {
        this._table     = table;
        this._tableBody = $(this._table).find('tbody');

        this.clearTable();
    }

    clearTable () {
        $(this._tableBody).html('');
    }

    addRowToBottom (index, participant) {
    }
}

class InitiativeTable extends TableHelper {
    /**
     * Table is made up of 4 columns - Name, Initiative, AC, HP
     *
     * @param index
     * @param participant Participant
     */
    addRowToBottom (index, participant) {
        let randomiserInitiative        = this.getRandomiserInitiativeString(participant.getDexterityModifier());
        let randomiserStartingHitPoints = this.getRandomizerStartingHitPointString(participant.getMaxHitPoints());
        let initiativeInput             = this.getInputInitiative(
            participant.getTempId(),
            participant.getDexterityModifier()
        );
        let startingHitPointInput       = this.getInputStartingHitPoint(
            participant.getTempId(),
            participant.getMaxHitPoints()
        );

        let tableCells =
                `<td>${participant.getName()}</td>` +
                `<td>${initiativeInput}${randomiserInitiative}</td>` +
                `<td>${participant.getArmourClass()}</td>` +
                `<td>${startingHitPointInput}${randomiserStartingHitPoints}</td>`;

        $(this._tableBody).append(`<tr>${tableCells}</tr>`);
    }

    getRandomiserInitiativeString (dexterityModifier) {
        return `<i class="fas fa-dice-d20 link-fa" onclick="randomiser(jQuery, this, 20, ${dexterityModifier})"></i>`;
    }

    getRandomizerStartingHitPointString (maxHitPoints) {
        return `<i class="fas fa-dice-d20 link-fa" onclick="randomiser(jQuery, this, ${maxHitPoints},  0)"></i>`;
    }

    getInputInitiative (tempId, dexterityModifier) {
        return `<input type="text" inputmode="number" id="participant-initiative-${tempId}" class="participant-initiative" name="participant-initiative[]" value="" pattern="\-?[0-9]*"-participant-temp-id="${tempId}" onkeyup="updateParticipantData(jQuery, ${tempId})" placeholder="(${dexterityModifier})" />`;
    }

    getInputStartingHitPoint (tempId, maxHitPoints) {
        return `<input type="text" inputmode="decimal" id="participant-starting-hit-points-${tempId}" class="participant-starting-hit-points" name="participant-starting-hit-points[]" value=""-participant-temp-id="${tempId}" onkeyup="updateParticipantData(jQuery, ${tempId})" placeholder="${maxHitPoints}" />`;
    }
}

class CombatTable extends TableHelper {
    /**
     * Table is made up of 4 columns - Name, Initiative, AC, HP
     *
     * @param index
     * @param participant
     */
    addRowToBottom (index, participant) {
        let tableCells =
                `<td>${participant.getName()}</td>` +
                `<td>${participant.getInitiative()}</td>` +
                `<td>${participant.getArmourClass()}</td>` +
                `<td>${participant.getStartingHitPoints()}</td>`;

        $(this._tableBody).append(`<tr class="combat-participant-${participant.getTempId()}">${tableCells}</tr>`);
    }
}

class CombatEncounter {
    constructor (
        // participantsArg
        sourceParticipantEl,
        targetParticipantEl,
        combatActionsEl,
        combatRollEl,
        combatTotalEl,
        combatMovementEl
    ) {
        this.sourceElement   = sourceParticipantEl;
        this.targetElement   = targetParticipantEl;
        this.actionElement   = combatActionsEl;
        this.rollElement     = combatRollEl;
        this.totalElement    = combatTotalEl;
        this.movementElement = combatMovementEl;
        // participants = participantsArg;

        this.roundCounter = 1;
        this.turnCounter  = 1;
        this.participants = [];

        this.combatActions = [
            'ATTACK',
            'HEAL',
            'SPELL',
            'DASH',
            'DELAY',
            'DISENGAGE',
            'DODGE',
            'HELP',
            'HIDE',
            'PASS',
            'READY',
            'USE',
            'SEARCH',
            'TEMP'
        ];

        $(this.sourceElement).html('').append('<option value="">No source</option>');
        $(this.targetElement).html('').append('<option value="">No target</option>');

        // jQ.each(participants, function (index, participant) {
        //     let sourceSelection = '';
        //     let targetSelection = '';
        //     if (index === 0) {
        //         sourceSelection = ' selected';
        //     }
        //     // if (index === 1) {
        //     //     targetSelection = ' selected';
        //     // }
        //
        //     jQ($sourceElement)
        //         .append('<option value="' + participant.data.tempId + '"' + sourceSelection + '>' + participant.data.name + '</option>');
        //     jQ($targetElement)
        //         .append('<option value="' + participant.data.tempId + '"' + targetSelection + '>' + participant.data.name + '</option>');
        // });

        // jQ('.combat-participant-' + participants[0].data.tempId).addClass('combat-turn-active');
    }

    privateResetRoundCounter () {
        this.roundCounter = 1;
    }

    privateIncrementRoundCounter () {
        ++this.roundCounter;
    }

    privateResetTurnCounter () {
        this.turnCounter = 1;
    }

    privateIncrementTurnCounter () {
        ++this.turnCounter;
    }

    privateSortParticipants () {
        this.participants.sort(function (a, b) {
            return b.getInitiative() - a.getInitiative();
        });
    }

    clearParticipants () {
        this.participants = [];
    }

    getParticipants () {
        return this.participants;
    }

    addParticipant (
        participant
    ) {
        // let participant = {
        //     id: id,
        //     name: name,
        //     armour_class: armourClass,
        //     max_hit_points: maxHitPoints,
        //     dexterity_modifier: dexterityModifier,
        //     tempId: tempId,
        //     starting_hit_points: startingHitPoints,
        //     initiative: initiative,
        // };
        //
        // if (monsterInstanceType !== null) {
        //     participant.monster_instance_type_id = monsterInstanceType;
        // }

        this.participants.push(participant);

        if (this.participants.length > 1) {
            this.privateSortParticipants();
        }
    }

    addPlayerCharacter (
        id,
        name,
        armourClass,
        maxHitPoints,
        dexterityModifier,
        tempId,
        startingHitPoints,
        initiative
    ) {
        this.addParticipant(
            id,
            name,
            armourClass,
            maxHitPoints,
            dexterityModifier,
            tempId,
            startingHitPoints,
            initiative
        );
    }

    addMonster (
        id,
        name,
        armourClass,
        maxHitPoints,
        dexterityModifier,
        tempId,
        startingHitPoints,
        initiative,
        monsterInstanceType
    ) {
        this.addParticipant(
            id,
            name,
            armourClass,
            maxHitPoints,
            dexterityModifier,
            tempId,
            startingHitPoints,
            initiative,
            monsterInstanceType
        );
    }

    getCombatActions () {
        return this.combatActions;
    }

    addTurnOfCombat () {

    }
}

let combatEncounter;
let initiativeTable;
let combatTable;

jQuery(function ($) {
    const getParticipantsJson = function () {
        return {
            playerCharacters: JSON.parse($('#player-characters').val()),
            monsters: JSON.parse($('#monsters').val()),
        };
    };

    $('.update-participants').on('click', function (event) {
        console.time('updateParticipants');

        let participantsJson  = getParticipantsJson();
        let participants      = [];
        let tempParticipantId = 1;

        combatEncounter.clearParticipants();
        combatTable.clearTable();
        initiativeTable.clearTable();

        $.each(participantsJson.playerCharacters, function (index, playerCharacterObj) {
            let playerCharacter = new PlayerCharacter(
                playerCharacterObj.data.id,
                playerCharacterObj.data.name,
                playerCharacterObj.data.armour_class,
                playerCharacterObj.data.max_hit_points,
                playerCharacterObj.data.dexterity_modifier
            );

            initiativeTable.addRowToBottom(index, playerCharacter);
            // participants.push(playerCharacter);
            combatEncounter.addParticipant(playerCharacter);
        });

        /** @var object - key = monster ID, value = count of that particular monster */
        let monstersCounters = {};

        $.each(participantsJson.monsters, function (index, monsterObj) {
            if (monsterObj.data.monster_instance_type_id === 1) {
                monstersCounters[monsterObj.data.id] = ++monstersCounters[monsterObj.data.id] || 1;
                // console.log(monsters);
                monsterObj.data.name += ' ' + monstersCounters[monsterObj.data.id];
            }

            let monster = new Monster(
                monsterObj.data.id,
                monsterObj.data.name,
                monsterObj.data.armour_class,
                monsterObj.data.max_hit_points,
                monsterObj.data.dexterity_modifier,
                monsterObj.data.monster_instance_type_id
            );

            initiativeTable.addRowToBottom(index, monster);
            // participants.push(monster);
            combatEncounter.addParticipant(monster);
        });

        $('#participants').val(JSON.stringify(combatEncounter.getParticipants()));

        console.timeEnd('updateParticipants');
    });

    $('.update-combat-table').on('click', function (event) {
        console.time('updateCombatTable');

        let $tableBody = $('#combat-table tbody');

        combatTable.clearTable();

        $.each(combatEncounter.getParticipants(), function (index, participant) {
            combatTable.addRowToBottom(index, participant);
        });

        console.timeEnd('updateCombatTable');
    });

    initiativeTable = new InitiativeTable(
        $('#initiative-table')
    );

    combatTable = new CombatTable(
        $('#combat-table')
    );

    combatEncounter = new CombatEncounter(
        $('#source-participant'),
        $('#target-participant'),
        $('#combat-actions'),
        $('#combat-roll'),
        $('#combat-total'),
        $('#combat-movement')
    );
});