export class TableHelper {
    protected _tableBodies: HTMLCollectionOf<HTMLTableSectionElement>;

    constructor(protected _table: HTMLTableElement) {
        this._tableBodies = this._table.tBodies;

        this.clearTable();
    }

    public clearTable() {
        for (let i = 0; i < this._tableBodies[0].rows.length; i++) {
            this._tableBodies[0].deleteRow(0);
        }
    }

    public addRowToBottom(tableCellsHtml: string, classes: string[] = []) {
        const tableRow = this._tableBodies[0].insertRow();
        tableRow.classList.add(...classes);
        tableRow.innerHTML = `${tableCellsHtml}`;
    }
}
