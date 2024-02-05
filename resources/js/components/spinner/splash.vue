<template>
    <div :class="{ loader: true, fadeout: !isLoading }">Loading ...</div>
</template>
<script>
export default {
    props: ["isLoading"],
};
</script>

