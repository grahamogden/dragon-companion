import type ApplicationErrorInterface from './ApplicationErrorInterface'

export default class NotFoundError implements ApplicationErrorInterface {
    status: number = 400
    message: string

    constructor(message: string = 'Not Found') {
        this.message = message
    }
}
