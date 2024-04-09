<template>
    <v-row id="login" class="flex h-full m-0">
        <v-col cols="12" class="flex justify-start h-full">
            <v-card width="40%" class="bg-black/35 py-8 px-16 flex flex-col items-center">
                <div class="w-5/6 h-full flex flex-col justify-center">
                    <div class="text-center text-5xl font-bold text-white p-2">
                        Login
                    </div>
                    <div class="p-2">
                        <v-text-field
                            name="email"
                            label="E-Mail"
                            id="email"/>
                    </div>
                    <div class="p-2">
                        <v-text-field
                            name="password"
                            label="Password"
                            id="password"
                            type="password"
                        ></v-text-field>
                    </div>
                    <div class="p-4 flex justify-center">
                        <v-btn color="success">Login</v-btn>
                    </div>
                    <div class="text-center">
                        Or
                    </div>
                    <div class="p-4 flex justify-center">
                        <v-btn color="primary">Sign up</v-btn>
                    </div>
                </div>
            </v-card>
        </v-col>
    </v-row>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router';


</script>