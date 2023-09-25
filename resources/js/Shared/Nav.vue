<template>
    <nav>
        <ul>
            <li><Link href="/">Home</Link></li>
            <li><Link href="/user">User</Link></li>
            <li><Link href="/logout" method="post" as="button">Log Out</Link></li>
        </ul>
    </nav>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'

    export default {
        components: { Link }
    }
</script>