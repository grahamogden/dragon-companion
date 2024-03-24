import { getIdToken, type Auth } from 'firebase/auth'

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

        const res = await getIdToken(this.auth.currentUser)
            .then(async (authToken: string) => {
                const res = await fetch(this.baseUrl + path, {
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
        throw new Error('Response not okay')
    }

    public async post(path: string, data: object): Promise<Response> {
        if (!this.auth.currentUser) {
            throw new Error()
        }

        const res = await getIdToken(this.auth.currentUser)
            .then(async (authToken: string) => {
                const res = await fetch(this.baseUrl + path, {
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
        throw new Error('Response not okay')
    }

    public async put(path: string, data: object): Promise<Response> {
        if (!this.auth.currentUser) {
            throw new Error()
        }

        const res = await getIdToken(this.auth.currentUser)
            .then(async (authToken: string) => {
                const res = await fetch(this.baseUrl + path, {
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
        throw new Error('Response not okay')
    }

    public async delete(path: string): Promise<Response> {
        if (!this.auth.currentUser) {
            throw new Error()
        }

        const res = await getIdToken(this.auth.currentUser)
            .then(async (authToken: string) => {
                const res = await fetch(this.baseUrl + path, {
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
        throw new Error('Response not okay')
    }
}

export default RestClientService
