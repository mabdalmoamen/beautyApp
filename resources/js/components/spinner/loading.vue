<template>
    <div class="preload flex-column justify-content-center align-items-center">
        <div class="load"></div>
    </div>
</template>

<script>
export default {
    props: ["title"],
    name: "Spinner",
};
</script>

<style scoped>
.preload {
    display: -ms-flexbox;
    display: flex;
    background-color: #f4f6f9;
    height: 100vh;
    width: 100%;
    transition: height 200ms linear;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 9999;
}
</style>
