import type RepositoryInterface from '../repository/RepositoryInterface'
import { type NewUserEntityInterface, type UserEntityInterface } from './UserEntityInterface'

export default interface UserRepositoryInterface extends RepositoryInterface {
    // findByExternalUserId(externalUserId: string): Promise<UserEntityInterface | null>
    add(user: NewUserEntityInterface): Promise<UserEntityInterface>
    update(data: UserEntityInterface): Promise<void>
    delete(UserId: number): Promise<void>
}
