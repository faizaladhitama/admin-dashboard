<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import AddButton from '@/Components/Button/AddButton.vue';
import EditButton from '@/Components/Button/EditButton.vue';
import SearchButton from '@/Components/Button/SearchButton.vue';
import DeleteButton from '@/Components/Button/DeleteButton.vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

let perPage = ref(5);

let headers = ref([
  {
    title: 'ID',
    align: 'start',
    sortable: false,
    key: 'id',
  },
  {
    title: 'Name',
    align: 'start',
    sortable: false,
    key: 'name',
  },
  { title: 'Actions', key: 'actions', sortable: false },
]);

let serverItems = ref([]);
let loading = ref(false);
let totalItems = ref(10);
let search = ref(null);
let options = ref({});

async function loadItems({ page, itemsPerPage, sortBy }) {
  loading.value = true;
  try {
    console.log(sortBy);
    console.log(search.value);
    let orderBy = sortBy.length ? (sortBy[0]?.order == 'asc' ? '+' : '-') + sortBy[0]?.key : null;

    let response = await axios.get('/api/genre', {
      params:{
        page: page,
        perPage: itemsPerPage,
        orderBy: orderBy,
        search: search.value
      }
    });
    let axiosData = response.data;
    
    serverItems = axiosData.data;
    totalItems = axiosData.total;
    loading.value = false;
  } catch (error){
    console.error(error);
  }
};

</script>

<template>
    <AppLayout title="Genre">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Genre
            </h2>
        </template>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div dir="rtl">
                    <div class="relative h-12">
                      <Link :href="route('genre.create')">
                        <add-button/>
                      </Link>
                    </div>
                </div>
                <v-data-table-server
                  :headers="headers"
                  :items-length="totalItems"
                  :items-per-page="perPage"
                  :items="serverItems"
                  :loading="loading"
                  :items-per-page-options="[
                    {value: 5, title: '5'},
                    {value: 25, title: '25'},
                    {value: 50, title: '50'},
                    {value: 100, title: '100'},
                    {value: -1, title: '$vuetify.dataFooter.itemsPerPageAll'}
                  ]"
                  class="elevation-1 p-4"
                  item-value="name"
                  @update:options="loadItems"
                  @update:options.page="(args) => options = args"
                >
                  <template v-slot:top>
                    <v-text-field
                      class="p-4"
                      density="compact"
                      v-model="search"
                      label="Search"
                      append-inner-icon="fas fa-search"
                      variant="solo"
                      @click:append-inner="console.log(options)"
                    ></v-text-field>
                  </template>
                  <template v-slot:item.actions="{ item }">
                    <div class="flex lg:space-x-2 ...">
                      <edit-button @click="editItem(item.raw)"/>
                      <delete-button @click="deleteItem(item.raw)"/>
                    </div>
                  </template>
                </v-data-table-server>
            </div>
        </div>
    </AppLayout>
</template>
