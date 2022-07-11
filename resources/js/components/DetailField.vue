<template>
    <div
        class="flex flex-col px-6 py-2 -mx-6 space-y-2 border-t border-gray-100 md:flex-row md:py-0 md:space-y-0 dark:border-gray-700"
    >
        <div class="md:w-1/4 md:py-3">
            <h4 class="font-bold md:font-normal">
                <span v-text="field.name"></span>
            </h4>
        </div>
        <div class="break-all md:w-3/4 md:py-3 lg:break-words">
            <ButtonComponent
                :field="field"
                :resourceName="resourceName"
            ></ButtonComponent>
        </div>
    </div>
</template>

<script>
    import ButtonComponent from "./ButtonComponent";

    export default {
        props: ["resourceName", "field"],

        components: { ButtonComponent },
    };
</script>
