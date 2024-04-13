import { defineStore } from 'pinia';
import { RemovableRef, useStorage } from '@vueuse/core';
import { User } from '../interfaces/User';

export const useSessionStore = defineStore('session', {
    state: (): {jwt: RemovableRef<string|null>, user: User} => ({
        jwt: useStorage('jwt', null),
        user: {id:0,name:"",email:"",admin:false}
    }),
    getters: {
        getJwt: (state) => state.jwt,
        getUser: (state) => state.user
    },
    actions: {
        setJwt(jwt: string) {
            this.jwt = jwt
        },
        unsetJwt() {
            this.jwt = null
        },
        setUser(user: User) {
            this.user = user
        }
    }
});