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
import ButtonComponent from "./ButtonComponent";

export default {
    props: ["resourceName", "field"],
    components: { ButtonComponent },
};
</script>
