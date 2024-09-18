import 'pinia'
import type RestClientService from '../services/repository/rest/RestClientService.ts'

declare module 'pinia' {
    export interface PiniaCustomProperties {
        restClient: RestClientService
    }
}
