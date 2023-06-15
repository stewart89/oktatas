<script setup>
import { computed, ref, watch, reactive } from "vue";

defineProps({
    departments: Object,
});

const exampleData = [
    {
        "nev": "magyar nyelv és irodalom",
        "tipus": "közép",
        "eredmeny": "70%"
    },
    {
        "nev": "történelem",
        "tipus": "közép",
        "eredmeny": "80%"
    },
    {
        "nev": "matematika",
        "tipus": "emelt",
        "eredmeny": "90%"
    },
    {
        "nev": "angol nyelv",
        "tipus": "közép",
        "eredmeny": "94%"
    },
    {
        "nev": "informatika",
        "tipus": "közép",
        "eredmeny": "95%"
    },
    {
        "nev": "fizika",
        "tipus": "közép",
        "eredmeny": "98%"
    }
];

const szak = ref('');
const eredmenyek = ref(JSON.stringify(exampleData));
const error = ref(false);
const errorSzak = ref(false);
const pontszam = ref(0);

function calculate(){

    if(szak.value == ''){
        errorSzak.value = true;
        setTimeout(function(){
            errorSzak.value = false
        }, 2000)
        return;
    }

    console.log(szak.value);
    console.log(eredmenyek.value);

    axios
    .post(route("calculate.post"), { szak: szak.value, eredmenyek: eredmenyek.value })
    .then((response) => {
        console.log(response);

        if(response.data.valid){
            pontszam.value = response.data.pontszam
            error.value = false;
        }else{
            error.value = response.data.message;
            pontszam.value = 0;
        }
    })
    .catch((error) => {
        console.log(error);
    });
}
</script>

<template>
    <div class="p-8">

        <div>
            <label
                for="countries"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Szak kiválasztása</label
            >
            <select
                id="countries"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                v-model="szak"
            >
                <option value="" selected>Válasszon szakot</option>
                <option
                    v-for="department in departments"
                    :key="department.id"
                    :value="department.name"
                >
                    {{ department.name }}
                </option>
            </select>

            <div v-if="errorSzak" class="flex items-center bg-red-400 text-white text-sm font-bold px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>Szak kiválasztása kötelező</p>
            </div>

        </div>

        <div>
            <label
                for="message"
                class="mt-6 block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Eredmények json formátumban</label
            >
            <textarea
                v-model="eredmenyek"
                id="message"
                rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder=""
            ></textarea>
        </div>

        <div>
            Pontszám: {{pontszam}}
        </div>

        <div v-if="error" class="flex items-center bg-red-400 text-white text-sm font-bold px-4 py-3" role="alert">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
            <p>{{error}}</p>
        </div>

        <button
            class="mt-6 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            @click="calculate"
        >
            Számol
        </button>
    </div>
</template>
