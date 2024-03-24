import 'pinia'
import type RestClientService from '../services/repository/rest/RestClientService'

declare module 'pinia' {
    export interface PiniaCustomProperties {
        restClient: RestClientService
    }
}
