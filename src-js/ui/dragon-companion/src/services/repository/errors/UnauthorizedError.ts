import type ApplicationErrorInterface from './ApplicationErrorInterface'

export default class UnauthorizedError implements ApplicationErrorInterface {
    status: number = 401
    message: string

    constructor(message: string = 'Unauthorized') {
        this.message = message
    }
}
