<template>
    <v-col>
        <v-row>
            <v-col>
                <v-row class="p-2">
                    <v-col cols="1" class="p-2 font-bold text-indigo-900">
                        ID:
                    </v-col>
                    <v-col class="p-2">
                        {{ user.id }}
                    </v-col>
                </v-row>
                <v-row class="p-2">
                    <v-col cols="1" class="p-2 font-bold text-indigo-900">
                        Name:
                    </v-col>
                    <v-col class="p-2">
                        {{ user.name }}
                    </v-col>
                </v-row>
                <v-row class="p-2">
                    <v-col cols="1" class="p-2 font-bold text-indigo-900">
                        E-Mail:
                    </v-col>
                    <v-col class="p-2">
                        {{ user.email }}
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row class="p-2">
            <v-col cols="1">
                <v-btn color="warning" @click="goEdit">Edit</v-btn>
            </v-col>
            <v-col>
                <v-btn v-if="user.admin" color="primary" @click="goAdmin">Manage user accounts</v-btn>
                <v-btn v-else color="error" @click="dialog = true">Delete account</v-btn>
            </v-col>
        </v-row>
    </v-col>
    <v-dialog v-model="dialog" width="auto">
        <v-card
            max-width="400"
            prepend-icon="mdi-delete"
            text="Are you sure you want to delete your account? (There's no coming back from this one!)."
            title="Delete Account"
        >
        <template v-slot:actions>
            <v-btn class="ms-auto" text="I'd rather not" @click="dialog = false"></v-btn>
            <v-btn class="ms-auto" text="I'm sure!" @click="deleteAccount"></v-btn>
        </template>
        </v-card>
    </v-dialog>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useSessionStore } from '../stores/SessionStore';
import axios from 'axios';
import { server } from '../config';
import { useRouter } from 'vue-router';

const session = useSessionStore();
const user = ref(session.getUser);

const router = useRouter();

const dialog = ref(false);

const goEdit = () => {
    router.push({name: 'Edit'});
}

const goAdmin = () => {
    router.push({name: 'Admin'});
}

const deleteAccount = () => {
    dialog.value = false;
    axios.delete(`${server}/api/delete`, {
        headers: {
            jwt: session.getJwt
        }
    }).then((response) => {
        session.unsetJwt();
        router.push({name: 'Login'});
    }).catch((error) => {
        console.log(error);
    })
}


</script>