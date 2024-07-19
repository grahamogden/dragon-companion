import type ApplicationErrorInterface from './ApplicationErrorInterface'

export default class BadRequestError implements ApplicationErrorInterface {
    status: number = 400
    errors: Record<string, Record<string, string>>
    message: string

    constructor(errors: Record<string, Record<string, string>>, message: string = 'Bad Request') {
        this.errors = errors
        this.message = message
    }
}
