<template>
    <div class="text-center text-5xl font-bold text-white p-4">
        Create Account
    </div>
    <v-form v-model="form" @submit.prevent="signup">
        <div v-if="alert" class="p-1">
            <v-alert type="error" closable v-model="alert" :text="errorMsg"/>
        </div>
        <div class="p-1">
            <v-text-field
                v-model="signupForm.name"
                name="name"
                label="Name"
                :rules="[rules.required]"
                id="name"/>
        </div>
        <div class="p-1">
            <v-text-field
                v-model="signupForm.email"
                name="email"
                label="E-Mail"
                :rules="[rules.required,rules.email]"
                id="email"/>
        </div>
        <div class="p-1">
            <v-text-field
                v-model="signupForm.password"
                name="password"
                label="Password"
                :rules="[rules.required]"
                id="password"
                type="password"
            ></v-text-field>
        </div>
        <div class="p-1">
            <v-text-field
                v-model="signupForm.rPassword"
                name="rPassword"
                label="Repeat password"
                :rules="[rules.password]"
                id="rPassword"
                type="password"
            ></v-text-field>
        </div>
        <div class="p-4 flex justify-center">
            <v-btn color="success" type="submit" :loading="loading" :disabled="!form">Create Account</v-btn>
        </div>
    </v-form>
    <div class="text-center">
        Already have an account?
        <router-link class="text-indigo-400 underline" :to="{name: 'Login'}"> Login!</router-link>
    </div>
</template>

<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import md5 from 'md5';
import { server } from '../config';

const router = useRouter();

const form = ref(false);
const loading = ref(false);
const alert = ref(false);
const errorMsg = ref("");

const signupForm = ref({
    name: "",
    email: "",
    password: "",
    rPassword: "",
});

const rules = {
    required: (value) => !!value || "This field is required!",
    password: (value) => value === signupForm.value.password || "Password doesn't match!",
    email: (value) => {
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return pattern.test(value) || 'Invalid e-mail.'
    },
};

const signup = () => {
    loading.value = true;
    setTimeout(() => {
        axios.post(`${server}/api/signup`, {
            name: signupForm.value.name,
            email: signupForm.value.email,
            password: md5(signupForm.value.password)
        }).then((response) => {
            router.push({name: 'Login'});
        }).catch((error) => {
            alert.value = true;
            errorMsg.value = error.response.data.message;
        })
        loading.value = false;
    }, 2000);
}

</script>