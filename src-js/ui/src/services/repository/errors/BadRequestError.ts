import type ApplicationErrorInterface from './ApplicationErrorInterface'

export default class BadRequestError implements ApplicationErrorInterface {
    status: number = 400
    message: string

    constructor(message: string = 'Bad Request') {
        this.message = message
    }
}
