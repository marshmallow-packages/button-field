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
            ></ButtonComponent>
        </template>
    </DefaultField>
</template>

<script>
    import { FormField } from "laravel-nova";
    import ButtonComponent from "./ButtonComponent";

    export default {
        mixins: [FormField],
        props: ["resourceName", "field"],
        components: { ButtonComponent },
    };
</script>
