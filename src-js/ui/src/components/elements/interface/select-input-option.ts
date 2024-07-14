import type SelectInputOptionInterface from './select-input-option.interface'

export default class SelectInputOption implements SelectInputOptionInterface {
    public readonly value: number | string
    public readonly text: string | number

    constructor(value: number | string, text: string | number) {
        this.value = value
        this.text = text
    }
}
