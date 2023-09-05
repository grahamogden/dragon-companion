import * as $ from 'jquery';
import { ParticipantAbstract } from '../entities/participant-abstract';
import { CombatTable } from './combat-table';

export class TableHelper {
    protected _tableBodies: HTMLCollectionOf<HTMLTableSectionElement>;

    constructor(protected table: HTMLTableElement) {
        this._tableBodies = this.table.tBodies; //.find('tbody');

        this.clearTable();
    }

    clearTable() {
        for (let i = 0; i < this.table.rows.length; i++) {
            this.table.deleteRow(0);
        }
    }

    addRowToBottom(participant: ParticipantAbstract) {
        console.warn('Method not implemented');
    }
}
