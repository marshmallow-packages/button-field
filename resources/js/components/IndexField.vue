<template>
    <ButtonComponent
        :field="field"
        :resourceName="resourceName"
        :resource="resource"
        :resourceId="resourceId"
    ></ButtonComponent>
</template>

<script>
    import ButtonComponent from "./ButtonComponent";
    export default {
        props: ["resourceName", "field", "resource", "resourceId"],
        components: { ButtonComponent },
    };
</script>
