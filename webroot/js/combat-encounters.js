const participantTypePlayerCharacter = 'PlayerCharacter';
const participantTypeMonster         = 'Monster';

let combatEncounter;
let initiativeTable;
let combatTable;

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
    let rand = Math.ceil(Math.random() * (max) + modifier);

    $(self).siblings('input').val(rand).change();
};

class Participant {

    constructor (
        id,
        name,
        armourClass,
        maxHitPoints,
        dexterityModifier
    ) {
        this.id                = id;
        this.name              = name;
        this.armourClass       = armourClass;
        this.maxHitPoints      = maxHitPoints;
        this.dexterityModifier = dexterityModifier;
        this.startingHitPoints = this.maxHitPoints;
        this.currentHitPoints  = this.maxHitPoints;
        this.participantType   = null;
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
        this.currentHitPoints  = startingHitPoints;
    }

    getCurrentHitPoints () {
        return this.currentHitPoints;
    }

    setCurrentHitPoints (newHitPoints) {
        this.currentHitPoints = newHitPoints;
    }

    getInitiative () {
        return this.initiative;
    }

    setInitiative (initiative) {
        this.initiative = initiative;
    }

    /*
     * Create a number that is 10 characters long and assign it to tempId
     */
    _createTempId () {
        let milliseconds = (Date.now()).toString();
        milliseconds = milliseconds.substr(-4);

        let randomNumber = Math.floor(
            1000 + Math.random() * 9999
        ).toString();

        this.tempId = parseInt(
            (randomNumber + milliseconds)
        );

        console.log(this.tempId);
    }
}

class PlayerCharacter extends Participant {

    constructor (
        id,
        name,
        armourClass,
        maxHitPoints,
        dexterityModifier
    ) {
        super(
            id,
            name,
            armourClass,
            maxHitPoints,
            dexterityModifier
        );
        this.participantType = participantTypePlayerCharacter;
    }
}

class Monster extends Participant {

    constructor (
        id,
        name,
        armourClass,
        maxHitPoints,
        dexterityModifier,
        monsterInstanceTypeId
    ) {
        super(
            id,
            name,
            armourClass,
            maxHitPoints,
            dexterityModifier
        );
        this.participantType       = participantTypeMonster;
        this.monsterInstanceTypeId = monsterInstanceTypeId;
    }

    getMonsterInstanceTypeId () {
        return this.monsterInstanceTypeId;
    }
}

class TableHelper {
    constructor (table) {
        this._table     = table;
        this._tableBody = $(this._table).find('tbody');

        this.clearTable();
    }

    clearTable () {
        $(this._tableBody).html('');
    }

    addRowToBottom (index, participant) {
        console.warn('Method not implemented');
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
    }

    getInputStartingHitPoint (tempId, maxHitPoints) {
        return `<input type="text" inputmode="decimal" id="participant-starting-hit-points-${tempId}" class="participant-starting-hit-points" name="participant-starting-hit-points[]" value="" placeholder="${maxHitPoints}" />`;
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
                `<td><span class="hit-points">${participant.getCurrentHitPoints()}</span> <span class="text-secondary">(${participant.getMaxHitPoints()})</span></td>`;

        $(this._tableBody).append(`<tr class="combat-participant-${participant.getTempId()}">${tableCells}</tr>`);
    }

    getHitPointText (currentHitPoints, startingHitPoints) {
        return `${currentHitPoints} `;
    }

    selectTableRowForParticipantTempId (tempId) {
        let activeRowClass = 'combat-turn-active';
        $(this._tableBody).find('tr').removeClass(activeRowClass);
        $(this._tableBody).find('.combat-participant-' + tempId).addClass(activeRowClass);
    }

    updateHitPointsForParticipantTempId (participant) {
        $('.combat-participant-' + participant.getTempId() + ' .hit-points')
            .text(this.getHitPointText(participant.getCurrentHitPoints()));
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
            $(sourceParticipant)
                .append(`<option value="${participant.getTempId()}">${participant.getName()}</option>`);
            $(targetParticipant)
                .append(`<option value="${participant.getTempId()}">${participant.getName()}</option>`);
        });

        this.sourceElement = sourceParticipant;
        this.targetElement = targetParticipant;

        this.setUpNextTurn(participants[0].getTempId());
    }

    getCombatTurnEntity (roundNumber, turnNumber) {
        let combatTurn = new CombatTurnEntity(
            parseInt($(this.sourceElement).val() || 0),
            parseInt($(this.targetElement).val() || 0),
            $(this.actionElement).val(),
            parseInt($(this.rollElement).val() || 0),
            parseInt($(this.totalElement).val() || 0),
            parseInt($(this.movementElement).val() || 0),
            roundNumber,
            turnNumber
        );
        return combatTurn;
    }

    setUpNextTurn (sourceTempId) {
        this.resetValues();
        $(this.sourceElement).val(sourceTempId);
    }

    resetValues () {
        $(this.sourceElement).val('');
        $(this.targetElement).val('');
        $(this.actionElement).val('ATTACK');
        $(this.rollElement).val('');
        $(this.totalElement).val('');
        $(this.movementElement).val('');
    }
}

class CombatTurnEntity {
    constructor (
        sourceTempId,
        targetTempId,
        action,
        roll,
        total,
        movement,
        roundNumber,
        turnNumber
    ) {
        this.sourceTempId = sourceTempId;
        this.targetTempId = targetTempId;
        this.action       = action;
        this.roll         = roll;
        this.total        = total;
        this.movement     = movement;
        this.roundNumber  = roundNumber;
        this.turnNumber   = turnNumber;
    }
}

class CombatEncounter {
    constructor (combatTable) {
        this.participants = [];
        this.combatTable  = combatTable;
        this.combatTurns  = [];
    }

    incrementRoundCounter () {
        ++this.roundCounter;
    }

    incrementTurnCounter () {
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

    getParticipantByTempId (tempId) {
        return this.getParticipants().find(participant => participant.getTempId() === tempId);
    }

    getParticipantArrayKeyByTempId (tempId) {
        return this.getParticipants().findIndex(participant => participant.getTempId() === tempId);
    }

    selectNextParticipantKeyByCurrentTempId (tempId) {
        let nextKey = this.getParticipantArrayKeyByTempId(tempId) + 1;

        if (nextKey >= this.getParticipants().length) {
            nextKey = 0;
        }

        this.currentParticipantKey = nextKey;
    }

    addParticipant (participant) {
        this.participants.push(participant);
    }

    setUpCombat () {
        this.currentParticipantKey = 0;
        this.roundCounter          = 0;
        this.turnCounter           = 0;

        this.combatTable.selectTableRowForParticipantTempId(this.getParticipants()[this.currentParticipantKey].getTempId());

        this.combatTurnHelper = new CombatTurnFormHelper(
            $('#source-participant'),
            $('#target-participant'),
            $('#combat-actions'),
            $('#combat-roll'),
            $('#combat-total'),
            $('#combat-movement'),
            this.getParticipants()
        );

        this.startNewRound();
    }

    startNewRound () {
        this.incrementRoundCounter();
        this.currentParticipantKey = 0;
        let participantKey         = this.getParticipants()[this.currentParticipantKey].getTempId();
        this.combatTable.selectTableRowForParticipantTempId(participantKey);
        this.combatTurnHelper.setUpNextTurn(participantKey);
    }

    addTurnOfCombat () {
        this.incrementTurnCounter();
        let combatTurn        = this.combatTurnHelper.getCombatTurnEntity(
            this.roundCounter,
            this.turnCounter
        );
        let targetParticipant = this.getParticipantByTempId(combatTurn.targetTempId);

        switch (combatTurn.action) {
            case 'ATTACK':
                if (targetParticipant.getArmourClass() < combatTurn.roll) {
                    let newHitPoints = targetParticipant.getCurrentHitPoints() - combatTurn.total;

                    if (newHitPoints < 0) {
                        newHitPoints = 0;
                    }

                    targetParticipant.setCurrentHitPoints(newHitPoints);
                } else {
                    combatTurn.total = 0;
                }
                break;
            case 'HEAL':
                let newHitPoints = targetParticipant.getCurrentHitPoints() + combatTurn.total;

                if (newHitPoints > targetParticipant.getMaxHitPoints()) {
                    newHitPoints     = targetParticipant.getMaxHitPoints();
                    combatTurn.total = targetParticipant.getMaxHitPoints() - targetParticipant.getCurrentHitPoints();
                }


                targetParticipant.setCurrentHitPoints(newHitPoints);
                break;
            case 'PASS':
                combatTurn.total        = 0;
                combatTurn.roll         = 0;
                combatTurn.targetTempId = '';
                break;
            default:
                console.error('Could not determine action, please select a valid action option');
                return false;
        }

        this.combatTurns.push(combatTurn);
        if (typeof targetParticipant !== 'undefined') {
            this.combatTable.updateHitPointsForParticipantTempId(targetParticipant);
        }

        let sourceParticipantArrayKey = this.getParticipantArrayKeyByTempId(combatTurn.sourceTempId);
        // If the currently selected source participant is the participant who's turn it should be, then increment the key
        if (sourceParticipantArrayKey === this.currentParticipantKey) {
            // Set the "current" participant to the next array key index
            this.selectNextParticipantKeyByCurrentTempId(combatTurn.sourceTempId);
        }

        // Set up the form for the next participant's turn (could be the same participant or the next one, depending on
        // whether this combatTurn's source was the currently selected participant or not - yes, its confusing!
        this.setUpNextTurnOfCombat(this.getParticipants()[this.currentParticipantKey]);

        // Don't actually end the combat, just want to update the JSON in the #turns field
        this.endCombat();
    }

    setUpNextTurnOfCombat (participant) {
        this.combatTurnHelper.setUpNextTurn(participant.getTempId());
        this.combatTable.selectTableRowForParticipantTempId(participant.getTempId());
    }

    endCombat () {
        $('#turns').val(JSON.stringify(this.combatTurns));
    }
}

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
        initiativeTable.clearTable();

        $.each(participants, function (index, participant) {
            initiativeTable.addRowToBottom(index, participant);
            combatEncounter.addParticipant(participant);
        });
    };

    $('.update-initiative-table').on('click', function (event) {
        let participantsJson = getParticipantsFromSeparateJson();

        combatEncounter.clearParticipants();
        combatTable.clearTable();
        setUpInitiativeTable(participantsJson);
    });

    $('.update-combat-table').on('click', function (event) {
        let $tableBody = $('#combat-table tbody');

        combatTable.clearTable();

        updateParticipantData($);

        $.each(combatEncounter.getParticipants(), function (index, participant) {
            combatTable.addRowToBottom(index, participant);
        });

        combatEncounter.setUpCombat();
    });

    $('#end-of-turn').on('click', function () {
        combatEncounter.addTurnOfCombat();
    });

    $('#end-of-round').on('click', function () {
        combatEncounter.startNewRound();
    });

    $('form').on('submit', function (event) {
        if (!confirm('Has the battle finished?!')) {
            return false;
        }
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

    /*if (combatEncounter.getParticipants().length > 0) {
     setUpInitiativeTable(combatEncounter.getParticipants());
     } else
     if (JSON.parse($('#participants').val()).length > 0) {
     console.log('participant json exists, set up initiative table');
     console.log(JSON.parse($('#participants').val()));
     setUpInitiativeTable(JSON.parse($('#participants').val()))
     } else */
    if (getParticipantsFromSeparateJson().length > 0) {
        // console.log('monster and PC json exists, set up initiative table');
        setUpInitiativeTable(getParticipantsFromSeparateJson());
    }
});