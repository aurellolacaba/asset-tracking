<template>
    <h1 class="text-3xl font-bold underline">
        Hello world!
    </h1>
    <ul>
        <li v-for="loan in loans.data">Php {{ loan.amount }} - {{ loan.terms }}  {{ loan.term_unit }} to pay</li>
    </ul>
</template>

<script>

    export default {
        props: {
            loans: Object
        }
    }
</script>