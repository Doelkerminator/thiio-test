<template>
    <v-row class="flex h-full m-0">
        <v-col cols="12" class="flex justify-start h-full">
            <v-card width="40%" class="bg-black/35 py-8 px-16 flex flex-col">
                <div class="text-center text-5xl font-bold text-indigo-700 p-2">
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
            </v-card>
        </v-col>
    </v-row>
</template>

<script setup lang="ts">

</script>