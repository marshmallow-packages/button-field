<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
    >
        <template #field>
            <ButtonComponent
                :field="field"
                :resourceName="resourceName"
                :resource="resource"
                :resourceId="resourceId"
            ></ButtonComponent>
        </template>
    </DefaultField>
</template>

<script>
    import { FormField } from "laravel-nova";
    import ButtonComponent from "./ButtonComponent";

    export default {
        mixins: [FormField],
        props: ["resourceName", "field", "resource", "resourceId"],
        components: { ButtonComponent },
    };
</script>
