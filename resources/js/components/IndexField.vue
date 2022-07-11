<template>
    <ButtonComponent
        :field="field"
        :resourceName="resourceName"
    ></ButtonComponent>
</template>

<script>
    import ButtonComponent from "./ButtonComponent";
    export default {
        props: ["resourceName", "field"],

        components: { ButtonComponent },
    };
</script>
