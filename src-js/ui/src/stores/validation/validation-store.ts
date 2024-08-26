import { defineStore } from 'pinia'
// import type ValidationErrorInterface from './validation-error.interface'
// import { v4 as uuidv4 } from 'uuid'
import type ValidationError from '../../services/repository/errors/ValidationError'

interface ValidationStoreInterface {
    errors: Record<string, ValidationError>
}

export const useValidationStore = defineStore('validation', {
    state: (): ValidationStoreInterface => ({
        errors: {},
    }),
    getters: {
        getErrorsForField: (state) => {
            return (field: string) => state.errors[field]
        },
        getErrorMessagesForField: (state) => {
            return (field: string): string[] => {
                const errors: string[] = []
                if (field === undefined || state.errors[field] === undefined) {
                    return errors
                }

                const keys = Object.keys(state.errors[field]) as Array<keyof ValidationError>
                keys.forEach((key: keyof ValidationError) => {
                    const error = state.errors[field][key]
                    if (error) {
                        errors.push(error)
                    }
                })
                return errors
            }
        },
    },
    actions: {
        addError(field: string, error: ValidationError) {
            this.errors[field] = error
        },
        addErrors(errors: Record<string, ValidationError>) {
            const fieldsWithErrors = Object.keys(errors) as Array<keyof ValidationError>

            fieldsWithErrors.forEach((fieldWithError: keyof ValidationError) => {
                const error = errors[fieldWithError]
                if (error) {
                    this.errors[fieldWithError] = error
                }
            })
        },
        removeErrorsForField(field: string) {
            delete this.errors[field]
        },
        removeAllErrors() {
            this.$reset()
        },
    },
})
