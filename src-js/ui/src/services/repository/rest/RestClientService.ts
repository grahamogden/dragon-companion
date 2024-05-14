import { getIdToken, type Auth } from 'firebase/auth'
import UnauthorizedError from '../errors/UnauthorizedError'
import BadRequestError from '../errors/BadRequestError'

class RestClientService {
    private baseUrl: string
    private auth: Auth
    private csrfToken: string

    public constructor(baseUrl: string, auth: Auth, csrfToken: string) {
        this.baseUrl = baseUrl
        this.auth = auth
        this.csrfToken = csrfToken
    }

    private getDefaultHeaders(): object {
        return {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': this.csrfToken,
        }
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
                    credentials: 'include',
                    mode: 'cors',
                    headers: {
                        ...this.getDefaultHeaders(),
                        Authorization: 'Bearer ' + authToken,
                    },
                })
                return res
            })
            .catch((error: Error) => {
                console.debug(error.message)
                throw error
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
                    credentials: 'include',
                    mode: 'cors',
                    headers: {
                        ...this.getDefaultHeaders(),
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
                    credentials: 'include',
                    mode: 'cors',
                    headers: {
                        ...this.getDefaultHeaders(),
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
                    credentials: 'include',
                    mode: 'cors',
                    headers: {
                        ...this.getDefaultHeaders(),
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
