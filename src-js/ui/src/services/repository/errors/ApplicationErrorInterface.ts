import type ValidationError from './ValidationError'

export default interface ApplicationErrorInterface {
    status: number
    errors?: Record<string, ValidationError>
    message: string
}
