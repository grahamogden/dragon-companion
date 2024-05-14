import RestClientService from '../../repository/rest/RestClientService'
import { type UserEntityInterface, type NewUserEntityInterface } from '../UserEntityInterface'
import type UserRepositoryInterface from '../UserRepositoryInterface'

export default class UserRestRepository implements UserRepositoryInterface {
    private restClient: RestClientService
    private readonly route: string = 'api/v1/users'

    public constructor(restClient: RestClientService) {
        this.restClient = restClient
    }

    // public async findByExternalUserId(externalUserId: string): Promise<UserEntityInterface | null> {
    //     const res = await this.restClient.get(this.route)
    //     let UserResponse: UserEntityInterface = await res.json()
    //     return UserResponse
    // }

    public async add(user: NewUserEntityInterface): Promise<UserEntityInterface> {
        const res = await this.restClient.post(this.route, user)
        if (res.ok) {
            const UserResponse = await res.json()
            return UserResponse.id
        }
        throw new Error()
    }

    public async update(user: UserEntityInterface): Promise<void> {
        const res = await this.restClient.put(this.route + '/' + user.id, user)
        if (res.ok) {
            return
        }
        throw new Error()
    }

    public async delete(UserId: number): Promise<void> {
        const res = await this.restClient.delete(this.route + '/' + UserId)
        if (res.ok) {
            return
        }
        throw new Error()
    }
}
