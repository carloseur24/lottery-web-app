<script setup>
import { ref } from 'vue';

const message = ref('Rockss!');
let rocks = 0;
const rockas = () => {
    console.clear()
    console.log(rocks++);
}
</script>

<template>
    <h1 class="text-3xl font-bold underline text-slate-700">
        VueSchool Rocks! 🤘 hooo yea
        {{ message }}
    </h1>

    <button @click="rockas()">common btn</button>
</template>
<script>
// export default {
//     data() {
//         return {
//             message: "Rocks!"
//         };
//     }
// }
</script>
