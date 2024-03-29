<template>
    <div v-if="field.available">
        <div v-if="field.button_type == 'button'">
            <a
                v-for="(button_value, button_key) in buttons"
                v-bind:key="button_key"
                size="lg"
                align="center"
                component="button"
                :href="!field.action_class_name ? field.value : 'javascript:;'"
                :target="field.button_target"
                type="submit"
                class="relative inline-flex items-center justify-center px-3 text-sm font-bold text-white rounded shadow cursor-pointer bg-primary-500 hover:bg-primary-400 dark:text-gray-900 focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 h-9"
            >
                <span class="">
                    {{ button_value }}
                </span>
            </a>
        </div>
        <div v-if="field.button_type == 'download'">
            <a
                v-for="(button_value, button_key) in buttons"
                v-bind:key="button_key"
                class="inline-flex items-center cursor-pointer dim btn btn-link text-primary"
                :href="!field.action_class_name ? field.value : 'javascript:;'"
                :target="field.button_target"
                :download="field.download_name"
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
                    {{ button_value }}
                </span>
            </a>
        </div>
        <div v-if="field.button_type == 'text'" class="flex gap-2">
            <a
                v-for="(button_value, button_key) in buttons"
                v-bind:key="button_key"
                class="relative flex items-center px-1 space-x-1 text-gray-500 rounded-full dark:text-gray-400 bg-gray-50 hover:bg-gray-100 hover:text-gray-500 active:text-gray-600 dark:hover:bg-gray-900"
                :href="!field.action_class_name ? field.value : 'javascript:;'"
                :target="!field.action_class_name ? field.button_target : ''"
                :download="field.download_name"
            >
                <span
                    v-if="field.action_class_name"
                    @click="callActionClass(button_value, button_key)"
                    class="absolute top-0 bottom-0 left-0 right-0"
                ></span>
                <span class="flex mt-1 class">
                    {{ button_value }}
                    <span
                        v-if="
                            field.icon &&
                            !(
                                field.action_class_name &&
                                action_run_successfully &&
                                action_run_for == button_key
                            )
                        "
                        v-html="field.icon"
                    ></span>
                    <svg
                        v-if="
                            field.action_class_name && action_run_successfully && action_run_for == button_key
                        "
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        width="14"
                        height="20"
                        class="inline-block ml-1 text-green-500"
                        role="presentation"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </span>
            </a>
        </div>
    </div>
    <div v-else-if="field.not_available_text">
        {{ field.not_available_text }}
    </div>
</template>

<script>
    export default {
        props: ["index", "resource", "resourceName", "resourceId", "field"],

        data: () => ({
            action_run_successfully: null,
            buttons: [],
        }),

        mounted() {
            let buttons = this.field.use_field_value
                ? this.field.value
                : this.field.button;
            if (typeof buttons !== "object") {
                buttons = { buttons };
            }
            this.buttons = buttons;
        },

        methods: {
            callActionClass: function (button_value, button_key) {
                let self = this;
                let formData = new FormData();

                formData.append("action_class", this.field.action_class_name);
                formData.append("button_value", button_value);
                formData.append("button_key", button_key);

                let resourceId = this.resourceId;

                if (!resourceId && this.$parent.$parent.resource) {
                    resourceId = this.$parent.$parent.resource.id.value;
                }

                if (!resourceId && this.$parent.$parent.$parent.resource) {
                    resourceId = this.$parent.$parent.$parent.resource.id.value;
                }

                return Nova.request()
                    .post(
                        `/nova-vendor/button-field/${this.resourceName}/${resourceId}`,
                        formData
                    )
                    .then(
                        (response) => {
                            if (response.data.success) {
                                Nova.success(response.data.message);
                                self.action_run_for = button_key;
                                self.action_run_successfully = true;
                            } else {
                                Nova.error(response.data.message);
                            }
                        },
                        (response) => {
                            Nova.error(response);
                        }
                    )
                    .finally(() => {
                        setTimeout(() => {
                            self.action_run_successfully = false;
                        }, 2500);
                    });
            },
        },
    };
</script>
