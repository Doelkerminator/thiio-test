<template>
    <div class="text-center text-5xl font-bold text-white p-2">
        Login
    </div>
    <v-form @submit.prevent="login" v-model="form">
        <div class="p-2">
            <v-alert type="error" closable :text="errorMsg" v-model="alert"/>
        </div>
        <div class="p-2">
            <v-text-field
                v-model="loginForm.email"
                clearable
                name="email"
                label="E-Mail"
                :rules="[rules.email, rules.emailP]"
                id="email"/>
        </div>
        <div class="p-2">
            <v-text-field
                v-model="loginForm.password"
                clearable
                name="password"
                label="Password"
                :rules="[rules.password]"
                id="password"
                type="password"
            ></v-text-field>
        </div>
        <div class="p-4 flex justify-center">
            <v-btn
                :disabled="!form"
                :loading="loading"
                color="success"
                size="large"
                type="submit"
                variant="elevated"
                block
            > Log In </v-btn>
        </div>
    </v-form>
    <div class="text-center">
        Or <router-link class="text-indigo-400 underline" :to="{name: 'Signup'}">Sign Up</router-link>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import { server } from '../config';
import { useRouter } from 'vue-router';
import { useSessionStore } from '../stores/SessionStore';
import md5 from 'md5';

const session = useSessionStore();
const router = useRouter();

const loginForm = ref({
    email: "",
    password: "",
});

const errorMsg = ref(null);
const loading = ref(false);
const form = ref(false);
const alert = ref(false);

const rules = {
    email: (value: string) => !!value || 'Please write your emal!',
    emailP: (value) => {
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return pattern.test(value) || 'Invalid e-mail.'
    },
    password: (value: string) => !!value || 'Please write your password!',
}

const login = () => {
    loading.value = true;
    setTimeout(() => {
        axios.post(`${server}/api/login`, {
            email: loginForm.value.email,
            password: md5(loginForm.value.password)
        }).then((response) => {
            if(response.status == 200) {
                session.setJwt(response.data.jwt);
                router.push('/');
            }
        }).catch((response) => {
            errorMsg.value = response.response.data.message;
            alert.value = true;
            loading.value = false;
        });
    }, 2000);
}

</script>