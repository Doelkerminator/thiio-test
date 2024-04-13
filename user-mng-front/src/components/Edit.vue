<template>
    <v-row class="w-full">
        <v-form v-model="form" @submit.prevent="edit" class="w-full">
            <v-col cols="6">
                <div class="p-1">
                    <v-alert type="error" v-model="alert" closable :text="errorMsg"/>
                </div>
                <div class="p-1">
                    <v-text-field
                        name="name"
                        label="Name"
                        :rules="[rules.required]"
                        id="name"
                        v-model="editForm.name"
                    />
                </div>
                <div class="p-1">
                    <v-text-field
                        name="email"
                        label="EMail"
                        :rules="[rules.required, rules.email]"
                        id="email"
                        v-model="editForm.email"
                    />
                </div>
                <div class="p-1">
                    <v-text-field
                        name="password"
                        label="Current Password"
                        id="password"
                        :rules="[rules.confirm]"
                        type="password"
                        v-model="editForm.password"
                    />
                </div>
                <div class="p-1">
                    <v-btn class="m-1" color="success" type="submit" :disabled="!form">Accept</v-btn>
                    <v-btn class="m-1" color="error" @click="goBack">Cancel</v-btn>
                </div>
            </v-col>
        </v-form>
    </v-row>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useSessionStore } from '../stores/SessionStore';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { server } from '../config';
import md5 from 'md5';

const session = useSessionStore();
const user = ref(session.getUser);
const router = useRouter();

const form = ref(false);
const alert = ref(false);
const errorMsg = ref("");

const editForm = ref({
    name: user.value.name,
    email: user.value.email,
    password: "",
})

const rules = {
    required: (value) => !!value || "This field is required",
    confirm: (value) => !!value || "Please write your password",
    email: (value) => {
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return pattern.test(value) || 'Invalid e-mail.'
    },
};

const goBack = () => {
    router.push({name: 'Dashboard'});
}

const edit = () => {
    axios.patch(`${server}/api/update`, {
        name: editForm.value.name,
        email: editForm.value.email,
        password: md5(editForm.value.password)
    }, {
        headers: {
            jwt: session.getJwt
        }
    }).then((response) => {
        router.push({name: 'Dashboard'});
    }).catch((error) => {
        alert.value = true;
        errorMsg.value = error.response.data.message;
    })
}

</script>