<template>
    <v-row class="h-full p-16 w-full">
        <v-card class="h-full bg-white p-4 rounded-md w-full">
            <v-row class="p-4">
                <v-col cols="9" class="text-4xl font-semibold">
                    User Management <span v-if="user.admin" class="text-green-700">Admin</span>
                </v-col>
                <v-col cols="3" class="text-right">
                    <v-btn color="red" :onclick="logout">Logout</v-btn>
                </v-col>
            </v-row>
            <hr/>
            <v-row class="p-4">
                <RouterView/>
            </v-row>
        </v-card>
    </v-row>
</template>

<script setup lang="ts">
import { RouterView, useRouter } from 'vue-router';
import { useSessionStore } from '../stores/SessionStore';
import axios from 'axios';
import { server } from '../config';
import { ref } from 'vue';

const session = useSessionStore();
const user = ref(session.getUser);
const router = useRouter();

const logout = () => {
    axios.delete(`${server}/api/logout`, {
        headers: {
            jwt: session.getJwt
        }
    }).then((response) => {
        session.unsetJwt();
        router.push('/auth/login');
    }).catch((error) => {
        console.log(error);
    })
} 
</script>