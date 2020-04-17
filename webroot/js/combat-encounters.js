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
        participant.setStartingHitPoints(
            parseInt(
                $('#participant-starting-hit-points-' + participant.getTempId()).val()
            )
        );

        participant.setInitiative(
            parseInt(
                $('#participant-initiative-' + participant.getTempId()).val()
            )
        );
    });

    combatEncounter.sortParticipants();

    $('#participants').val(JSON.stringify(combatEncounter.getParticipants()));
};

const randomiser = function ($, self, max, modifier) {
    // console.log($(self));
    let rand = Math.floor(Math.random() * max + modifier);
    // console.log(rand);
    $(self).siblings('input').val(rand).change();
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

    get className () {
        return 'PlayerCharacter';
    }
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

    get className () {
        return 'Monster';
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
        return `<input type="text" inputmode="number" id="participant-initiative-${tempId}" class="participant-initiative" name="participant-initiative[]" value="" pattern="\-?[0-9]*" placeholder="(${dexterityModifier})" />`;
    }// onkeyup="updateParticipantData(jQuery, ${tempId})"

    getInputStartingHitPoint (tempId, maxHitPoints) {
        return `<input type="text" inputmode="decimal" id="participant-starting-hit-points-${tempId}" class="participant-starting-hit-points" name="participant-starting-hit-points[]" value="" placeholder="${maxHitPoints}" />`;
    }// onkeyup="updateParticipantData(jQuery, ${tempId})"
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

    selectTableRowForParticipantTempId (tempId) {
        let activeRowClass = 'combat-turn-active';
        $(this._tableBody).find('tr').removeClass(activeRowClass);
        $(this._tableBody).find('.combat-participant-' + tempId).addClass(activeRowClass);
    }
}

class CombatTurnFormHelper {
    constructor (
        sourceParticipant,
        targetParticipant,
        combatActions,
        combatRoll,
        combatTotal,
        combatMovement,
        participants
    ) {
        this.rollElement     = combatRoll;
        this.totalElement    = combatTotal;
        this.movementElement = combatMovement;
        this.actionElement   = combatActions;
        $(this.actionElement).val('ATTACK'); // Set the default action to "ATTACK"

        $(sourceParticipant).html('').append('<option value="">No source</option>');
        $(targetParticipant).html('').append('<option value="">No target</option>');

        $.each(participants, function (index, participant) {
            let sourceSelection = '';

            if (index === 0) {
                sourceSelection = 'selected';
            }

            $(sourceParticipant)
                .append(`<option value="${participant.getTempId()}" ${sourceSelection}>${participant.getName()}</option>`);
            $(targetParticipant)
                .append(`<option value="${participant.getTempId()}">${participant.getName()}</option>`);
        });

        this.sourceElement   = sourceParticipant;
        this.targetElement   = targetParticipant;
    }
}

class CombatTurnEntity {
    constructor (
        sourceTempId,
        targetTempId,
        action,
        roll,
        total,
        movement
    ) {
        this.sourceTempId = sourceTempId;
        this.targetTempId = targetTempId;
        this.action       = action;
        this.roll         = roll;
        this.total        = total;
        this.movement     = movement;
    }
}

class CombatEncounter {
    constructor (combatTable) {
        this.participants  = [];
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
        this.combatTable   = combatTable;
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

    sortParticipants () {
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

    addParticipant (participant) {
        this.participants.push(participant);
    }

    getCombatActions () {
        return this.combatActions;
    }

    setUpCombat () {
        this.currentParticipant = this.getParticipants()[0];
        this.roundCounter       = 1;
        this.turnCounter        = 1;

        this.combatTable.selectTableRowForParticipantTempId(this.currentParticipant.getTempId());

        this.combatTurnHelper = new CombatTurnFormHelper(
            $('#source-participant'),
            $('#target-participant'),
            $('#combat-actions'),
            $('#combat-roll'),
            $('#combat-total'),
            $('#combat-movement'),
            this.getParticipants()
        );
    }

    addTurnOfCombat () {

    }
}

let combatEncounter;
let initiativeTable;
let combatTable;

jQuery(function ($) {

    const getParticipantsFromSeparateJson = function () {
        let playerCharacters  = JSON.parse($('#player-characters').val());
        let monsters          = JSON.parse($('#monsters').val());
        let participantsArray = [];

        $.each(playerCharacters, function (index, playerCharacterObj) {
            let playerCharacter = new PlayerCharacter(
                playerCharacterObj.data.id,
                playerCharacterObj.data.name,
                playerCharacterObj.data.armour_class,
                playerCharacterObj.data.max_hit_points,
                playerCharacterObj.data.dexterity_modifier
            );

            participantsArray.push(playerCharacter);
        });

        /** @var object - key = monster ID, value = count of that particular monster */
        let monstersCounters = {};

        $.each(monsters, function (index, monsterObj) {
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

            participantsArray.push(monster);
        });

        return participantsArray;
    };

    const setUpInitiativeTable = function (participants) {
        console.log('set up initiative table');
        initiativeTable.clearTable();

        $.each(participants, function (index, participant) {
            initiativeTable.addRowToBottom(index, participant);
            combatEncounter.addParticipant(participant);
        });
    };

    $('.update-initiative-table').on('click', function (event) {
        console.time('updateParticipants');

        let participantsJson = getParticipantsFromSeparateJson();

        combatEncounter.clearParticipants();
        combatTable.clearTable();
        setUpInitiativeTable(participantsJson);

        console.timeEnd('updateParticipants');
    });

    $('.update-combat-table').on('click', function (event) {
        console.time('updateCombatTable');

        let $tableBody = $('#combat-table tbody');

        combatTable.clearTable();

        updateParticipantData($);

        $.each(combatEncounter.getParticipants(), function (index, participant) {
            combatTable.addRowToBottom(index, participant);
        });

        combatEncounter.setUpCombat();

        console.timeEnd('updateCombatTable');
    });

    initiativeTable = new InitiativeTable(
        $('#initiative-table')
    );

    combatTable = new CombatTable(
        $('#combat-table')
    );

    combatEncounter = new CombatEncounter(
        combatTable
    );

    console.log(getParticipantsFromSeparateJson());
    /*if (combatEncounter.getParticipants().length > 0) {
     setUpInitiativeTable(combatEncounter.getParticipants());
     } else
    if (JSON.parse($('#participants').val()).length > 0) {
        console.log('participant json exists, set up initiative table');
        console.log(JSON.parse($('#participants').val()));
        setUpInitiativeTable(JSON.parse($('#participants').val()))
    } else */if (getParticipantsFromSeparateJson().length > 0) {
        console.log('monster and PC json exists, set up initiative table');
        setUpInitiativeTable(getParticipantsFromSeparateJson());
    }
});