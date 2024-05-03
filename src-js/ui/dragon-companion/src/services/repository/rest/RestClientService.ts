import { getIdToken, type Auth } from 'firebase/auth'
import UnauthorizedError from '../errors/UnauthorizedError'
import BadRequestError from '../errors/BadRequestError'

class RestClientService {
    private baseUrl: string
    private auth: Auth
    private defaultHeaders: object = {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    }

    public constructor(baseUrl: string, auth: Auth) {
        this.baseUrl = baseUrl
        this.auth = auth
    }

    public async get(path: string): Promise<Response> {
        if (!this.auth.currentUser) {
            throw new Error()
        }
        const url = this.baseUrl + path

        const res = await getIdToken(this.auth.currentUser)
            .then(async (authToken: string) => {
                const res = await fetch(url, {
                    method: 'GET',
                    credentials: 'omit',
                    mode: 'cors',
                    headers: {
                        ...this.defaultHeaders,
                        Authorization: 'Bearer ' + authToken,
                    },
                })
                return res
            })
            .catch((error) => {
                throw new Error(error)
            })

        if (res.ok) {
            return res
        }
        this.handleError(url, 'GET', res)
    }

    public async post(path: string, data: object): Promise<Response> {
        if (!this.auth.currentUser) {
            throw new Error()
        }
        const url = this.baseUrl + path

        const res = await getIdToken(this.auth.currentUser)
            .then(async (authToken: string) => {
                const res = await fetch(url, {
                    method: 'POST',
                    credentials: 'omit',
                    mode: 'cors',
                    headers: {
                        ...this.defaultHeaders,
                        Authorization: 'Bearer ' + authToken,
                    },
                    body: JSON.stringify(data),
                })
                return res
            })
            .catch((error) => {
                throw new Error(error)
            })

        if (res.ok) {
            return res
        }
        this.handleError(url, 'POST', res)
    }

    public async put(path: string, data: object): Promise<Response> {
        if (!this.auth.currentUser) {
            throw new Error()
        }
        const url = this.baseUrl + path

        const res = await getIdToken(this.auth.currentUser)
            .then(async (authToken: string) => {
                const res = await fetch(url, {
                    method: 'PUT',
                    credentials: 'omit',
                    mode: 'cors',
                    headers: {
                        ...this.defaultHeaders,
                        Authorization: 'Bearer ' + authToken,
                    },
                    body: JSON.stringify(data),
                })
                return res
            })
            .catch((error) => {
                throw new Error(error)
            })

        if (res.ok) {
            return res
        }
        this.handleError(url, 'PUT', res)
    }

    public async delete(path: string): Promise<Response> {
        if (!this.auth.currentUser) {
            throw new Error()
        }
        const url = this.baseUrl + path

        const res = await getIdToken(this.auth.currentUser)
            .then(async (authToken: string) => {
                const res = await fetch(url, {
                    method: 'DELETE',
                    credentials: 'omit',
                    mode: 'cors',
                    headers: {
                        ...this.defaultHeaders,
                        Authorization: 'Bearer ' + authToken,
                    },
                })
                return res
            })
            .catch((error) => {
                throw new Error(error)
            })

        if (res.ok) {
            return res
        }
        this.handleError(url, 'DELETE', res)
    }

    private handleError(url: string, method: string, res: Response): never {
        console.error('(' + res.status + ') ' + method + ':' + url)
        switch (res.status) {
            case 401:
                throw new UnauthorizedError()
            case 400:
                throw new BadRequestError()
            default:
                throw new Error('Response not okay')
        }
    }
}

export default RestClientService
