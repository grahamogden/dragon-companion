import { defineStore } from 'pinia'
import { type NewUserEntityInterface } from '../services/user'

import { useLocalStorage, type RemovableRef } from '@vueuse/core'
import type { User } from 'firebase/auth'
import type UserRepositoryInterface from '../services/user/UserRepositoryInterface'
import UserRestRepository from '../services/user/rest/UserRestRepository'

export interface UserStoreInterface {
    user: User | null
    tempUserIsLoggedIn: RemovableRef<boolean>
}

export const useUserAuthStore = defineStore('userAuth', {
    state: (): UserStoreInterface => ({
        user: null, // useLocalStorage<User | null>('userAuth', null),
        tempUserIsLoggedIn: useLocalStorage<boolean>('tempUserIsLoggedIn', false),
    }),
    getters: {
        getUser: (state) => state.user,
        isLoggedIn: (state) => state.user !== null || state.tempUserIsLoggedIn,
    },
    actions: {
        setUser(user: User | null): void {
            this.tempUserIsLoggedIn = user !== null
            this.user = user
        },
        _getUserRepository(): UserRepositoryInterface {
            return new UserRestRepository(this.restClient)
        },
        async addUser(userData: NewUserEntityInterface, user: User): Promise<void> {
            await this._getUserRepository().add(userData)
            this.setUser(user)
        },
    },
})
