<template>
    <v-row class="w-full h-full p-2">
        <div class="p-1">
            <v-alert type="error" v-model="alert"  :text="errorMsg" closable/>
        </div>
        <v-data-table theme="light" :headers="headers" :items="users">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Users</v-toolbar-title>
                    <v-spacer/>
                    <v-btn @click="goBack"><v-icon>mdi-arrow-left</v-icon>Go back</v-btn>
                </v-toolbar>
            </template>
            <template v-slot:item.admin="{ item }">
                <v-icon v-if="item.isAdmin">mdi-check</v-icon>
                <v-icon v-else>mdi-close</v-icon>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn  class="hover:text-red-600" flat :disabled="item.isAdmin" icon @click="deleteDialog(item)">
                    <v-icon>mdi-delete</v-icon>
                </v-btn>
            </template>
            <template v-slot:no-data>
                <div>No data found!</div>
            </template>
        </v-data-table>
        <v-dialog v-model="delDialog" width="auto">
            <v-card
                max-width="400"
                prepend-icon="mdi-delete"
                text="Are you sure you want to delete this account? (There's no coming back from this one!)."
                title="Delete Account"
            >
            <template v-slot:actions>
                <v-btn class="ms-auto" text="I'd rather not" @click="delDialog = false"></v-btn>
                <v-btn class="ms-auto" text="I'm sure!" @click="deleteUser"></v-btn>
            </template>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script setup lang="ts">
import axios from 'axios';
import { Ref, ref } from 'vue';
import { onMounted } from 'vue';
import { server } from '../config';
import { useSessionStore } from '../stores/SessionStore';
import { useRouter } from 'vue-router';
import { User } from '../interfaces/User';

const session = useSessionStore();
const router = useRouter();

const users = ref([]);

const goBack = () => {
    router.push({name: 'Dashboard'});
}

const delDialog = ref(false);
const edDialog = ref(false);

const alert = ref(false);
const errorMsg = ref("");

const issuedUser: Ref<User|null> = ref(null);

const deleteDialog = (item) => {
    issuedUser.value = {
        id: item.id,
        name: item.name,
        email: item.email,
        admin: item.isAdmin
    }

    delDialog.value = true;
}

const deleteUser = () => {
    axios.delete(`${server}/api/admin/drop/${issuedUser.value?.id}`, {
        headers: {
            jwt: session.getJwt
        }
    }).then((response) => {
        getData();
        delDialog.value = false;
    }).catch((error) => {

    })
}

const headers = [
    {
        title: "Id",
        align: "center",
        sortable: true,
        key: 'id'
    },
    {
        title: "Name",
        align: "center",
        sortable: true,
        key: 'name'
    }, 
    {
        title: "Email",
        align: "center",
        sortable: true,
        key: 'email'
    },
    {
        title: "Admin",
        align: "center",
        sortable: false,
        key: 'admin'
    },
    {
        title: "Actions",
        align: "center",
        sortable: false,
        key: "actions"
    }
];

const getData = () => {
    axios.get(`${server}/api/admin/users`, {
        headers: {
            jwt: session.getJwt
        }
    }).then((response) => {
        users.value = response.data.users;
    }).catch((error) => {
        errorMsg.value = error.response.data.message;
        alert.value = true;
        console.log(error);
    });
}

onMounted(() => getData());

</script>