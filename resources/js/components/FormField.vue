<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
    >
        <template #field>
            <div>
                <a
                    v-if="field.button_type == 'button'"
                    size="lg"
                    align="center"
                    component="button"
                    dusk="update-button"
                    :href="value"
                    :target="field.button_target"
                    type="submit"
                    class="relative inline-flex items-center justify-center px-3 text-sm font-bold text-white rounded shadow cursor-pointer bg-primary-500 hover:bg-primary-400 dark:text-gray-900 focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 h-9"
                >
                    <span class="">
                        {{ field.button }}
                    </span>
                </a>
                <a
                    v-if="field.button_type == 'download'"
                    class="inline-flex items-center cursor-pointer dim btn btn-link text-primary"
                    :href="value"
                    :target="field.button_target"
                    download="download"
                    ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        aria-labelledby="download"
                        role="presentation"
                        class="mr-2 fill-current"
                    >
                        <path
                            d="M11 14.59V3a1 1 0 0 1 2 0v11.59l3.3-3.3a1 1 0 0 1 1.4 1.42l-5 5a1 1 0 0 1-1.4 0l-5-5a1 1 0 0 1 1.4-1.42l3.3 3.3zM3 17a1 1 0 0 1 2 0v3h14v-3a1 1 0 0 1 2 0v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3z"
                        ></path>
                    </svg>
                    <span class="mt-1 class">
                        {{ field.button }}
                    </span>
                </a>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            console.log(this.field.button);
            this.value = this.field.value || "";
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || "");
        },
    },
};
</script>
