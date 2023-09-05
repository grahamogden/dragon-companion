import { CombatEncounter } from './combat-encounter';
import { InitiativeTable } from './table/initiative-table';
import { CombatTable } from './table/combat-table';
import { ParticipantJsonHelper } from './helpers/participant-json-helper';
import { ParticipantAbstract } from './entities/participant-abstract';
import $ from 'jquery';
import { ParticipantTypeEnum } from './enums/enums/participant-type-enum';
import { Monster } from './entities/monster';
import { PlayerCharacter } from './entities/player-character';
import { LocalStorageAdapter } from './adapters/local-storage-adapter';

// const sessionStorageCampaign = 'campaign';
// const sessionStoragePlayerCharacters = 'player-characters';
// const sessionStorageMonsters = 'monsters';
// const sessionStorageParticipants = 'participants';
// const sessionStorageTurns = 'turns';

let combatEncounter: CombatEncounter;
let initiativeTable: InitiativeTable;
let combatTable: CombatTable;
const participantJsonHelper = new ParticipantJsonHelper(
    sessionStorageParticipants,
);

const setParticipantStartingValuesOnCombatEncounter = () => {
    $.each(
        combatEncounter.getParticipants(),
        function (index: number, participant: ParticipantAbstract) {
            const hitPoints = parseInt(
                $(
                    '#participant-starting-hit-points-' +
                        participant.getTemporaryId(),
                ).val(),
            );
            participant.setStartingHitPoints(hitPoints);
            participant.setCurrentHitPoints(hitPoints);

            participant.setInitiative(
                parseInt(
                    $(
                        '#participant-initiative-' +
                            participant.getTemporaryId(),
                    ).val(),
                ),
            );
        },
    );

    combatEncounter.sortParticipants();
};

const randomiser = ($, self, max, modifier) => {
    const rand = Math.ceil(Math.random() * max + modifier);

    $(self).siblings('input').val(rand).change();
};

$(function ($) {
    initiativeTable = new InitiativeTable(
        document.getElementById('initiative-table') as HTMLTableElement,
    );
    combatTable = new CombatTable(
        document.getElementById('combat-table') as HTMLTableElement,
    );
    combatEncounter = new CombatEncounter(
        combatTable,
        participantJsonHelper,
        new LocalStorageAdapter(),
    );

    const restoreInputFromSessionStorage = ($element, storageName) => {
        const value = sessionStorage.getItem(storageName);
        if (value) {
            try {
                const valueJson = JSON.parse(value);
                $($element).val(value);
                return valueJson;
            } catch {
                $($element).val(value);
                return value;
            }
        }

        return null;
    };

    const getParticipantsFromSeparateJson = () => {
        const $playerCharacters = $('#player-characters');
        const $monsters = $('#monsters');
        const playerCharacters = JSON.parse(
            $playerCharacters.val() ? $playerCharacters.val() : '{}',
        );
        const monsters = JSON.parse($monsters.val() ? $monsters.val() : '{}');
        const participantsArray = [];

        $.each(playerCharacters, function (index, playerCharacterObj) {
            const playerCharacter = new PlayerCharacter(
                playerCharacterObj.data.id,
                playerCharacterObj.data.name,
                playerCharacterObj.data.armour_class,
                playerCharacterObj.data.max_hit_points,
                playerCharacterObj.data.dexterity_modifier,
            );

            participantsArray.push(playerCharacter);
        });

        /** @var object - key = monster ID, value = count of that particular monster */
        const monstersCounters = {};

        $.each(monsters, function (index, monsterObj) {
            if (monsterObj.data.monster_instance_type_id === 1) {
                monstersCounters[monsterObj.data.id] =
                    ++monstersCounters[monsterObj.data.id] || 1;
                monsterObj.data.name +=
                    ' ' + monstersCounters[monsterObj.data.id];
            }

            const monster = new Monster(
                monsterObj.data.id,
                monsterObj.data.name,
                monsterObj.data.armour_class,
                monsterObj.data.max_hit_points,
                monsterObj.data.dexterity_modifier,
                monsterObj.data.monster_instance_type_id,
            );

            participantsArray.push(monster);
        });

        return participantsArray;
    };

    const setUpInitiativeTable = (participants) => {
        initiativeTable.clearTable();

        $.each(participants, function (index, participant) {
            initiativeTable.addRowToBottom(index, participant);
            combatEncounter.addParticipant(participant);
        });
    };

    $('#campaign-id').on('change', function () {
        sessionStorage.setItem(sessionStorageCampaign, $(this).val());
    });

    $('#player-characters').on('change', function () {
        sessionStorage.setItem(sessionStoragePlayerCharacters, $(this).val());
    });

    $('#monsters').on('change', function () {
        sessionStorage.setItem(sessionStorageMonsters, $(this).val());
    });

    $('.update-initiative-table').on('click', function (event) {
        event.preventDefault();
        const participantsJson = getParticipantsFromSeparateJson();

        combatEncounter.clearParticipants();
        combatTable.clearTable();
        setUpInitiativeTable(participantsJson);
    });

    $('.update-combat-table').on('click', function (event) {
        event.preventDefault();
        const $tableBody = $('#combat-table tbody');

        combatTable.clearTable();

        setParticipantStartingValuesOnCombatEncounter();
        participantJsonHelper.updateParticipantJson(
            combatEncounter.getParticipants(),
        );
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

        combatEncounter.clearEncounter();
    });

    if (
        null !==
        restoreInputFromSessionStorage(
            $('#campaign-id'),
            sessionStorageCampaign,
        )
    ) {
        const playerCharactersJson = restoreInputFromSessionStorage(
            $('#player-characters'),
            sessionStoragePlayerCharacters,
        );
        const monstersJson = restoreInputFromSessionStorage(
            $('#monsters'),
            sessionStorageMonsters,
        );

        if (null !== playerCharactersJson && null !== monstersJson) {
            $.each(playerCharactersJson, function (index, playerCharacter) {
                const target = 'player-characters';

                $(`#autocomplete-${target}-table tbody`).append(
                    `<tr><td>${playerCharacter.data.name}</td><td><button class="btn btn-danger" onclick="removeAutocompleteItemFromTable(jQuery, this, '${target}', ${playerCharacter.data.id})" type="button">Remove</button></td></tr>`,
                );
            });

            $.each(monstersJson, function (index, monster) {
                const target = 'monsters';

                $(`#autocomplete-${target}-table tbody`).append(
                    `<tr><td>${monster.data.name}</td><td><button class="btn btn-danger" onclick="removeAutocompleteItemFromTable(jQuery, this, '${target}', ${monster.data.id})" type="button">Remove</button></td></tr>`,
                );
            });

            $('#combat-encounters-startup').hide();
            $('#combat-encounters-participants').show();

            const participantsJson = restoreInputFromSessionStorage(
                $('#participants'),
                sessionStorageParticipants,
            );
            if (null !== participantsJson) {
                console.log(
                    'monster and PC json exists, set up initiative table',
                );
                combatEncounter.clearParticipants();
                combatTable.clearTable();
                let participantsStartingValuesSet = true;
                const participants: ParticipantAbstract[] = [];

                $.each(participantsJson, function (index, participantObj) {
                    let participant;
                    if (
                        participantObj.participantType ===
                        ParticipantTypeEnum.PLAYER_CHARACTER
                    ) {
                        participant = new PlayerCharacter(
                            participantObj.id,
                            participantObj.name,
                            participantObj.armourClass,
                            participantObj.maxHitPoints,
                            participantObj.dexterityModifier,
                            participantObj.startingHitPoints || undefined,
                            participantObj.currentHitPoints || undefined,
                            participantObj.initiative || undefined,
                        );
                    } else if (
                        participantObj.participantType ===
                        ParticipantTypeEnum.MONSTER
                    ) {
                        participant = new Monster(
                            participantObj.id,
                            participantObj.name,
                            participantObj.armourClass,
                            participantObj.maxHitPoints,
                            participantObj.dexterityModifier,
                            participantObj.monsterInstanceTypeId,
                            participantObj.startingHitPoints || undefined,
                            participantObj.currentHitPoints || undefined,
                            participantObj.initiative || undefined,
                        );
                    }
                    if (
                        !participant.getStartingHitPoints() ||
                        !participant.getInitiative()
                    ) {
                        participantsStartingValuesSet = false;
                    }
                    participants.push(participant);
                });

                setUpInitiativeTable(participants);
                // setParticipantStartingValuesOnCombatEncounter($);
                combatEncounter.sortParticipants();

                $('#combat-encounters-participants').hide();
                $('#combat-encounters-initiative').show();

                if (participantsStartingValuesSet) {
                    console.log(combatEncounter.getParticipants());
                    combatEncounter.setUpCombat();

                    $('#combat-encounters-initiative').hide();
                    $('#combat-encounters-combat').show();
                    // restoreInputFromSessionStorage($('#turns'), sessionStorageTurns);
                }
            }
        }
    } else {
        $('#campaign-id').change();
        combatEncounter.clearEncounter();
    }
});
