<template>
    <div v-if="field.available">
        <div v-if="field.action && action_handler">
            <div class="flex gap-2">
                <a class="relative flex items-center px-2 space-x-1 text-gray-500 rounded-full dark:text-gray-400 bg-gray-50 hover:bg-gray-100 hover:text-gray-500 active:text-gray-600 dark:hover:bg-gray-900 h-8" href="javascript:;" target="" @click.stop.prevent="action_handler.fireAction()">
                    <span class="absolute top-0 bottom-0 left-0 right-0"></span>
                    <span class="flex mt-1 class">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 inline-block mr-1 text-gray-400 dark:text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                         {{ action_label }}
                    </span>
                </a>
            </div>
            <component
                v-if="action_handler.confirmActionModalOpened"
                v-bind="options"
                class="text-left"
                :is="field.action.component"
                @close="action_handler.closeConfirmationModal"
                @confirm="action_handler.executeAction">
            </component>
        </div>

        <div v-else>
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

    </div>
    <div v-else-if="field.not_available_text">
        {{ field.not_available_text }}
    </div>
</template>

<script>
    import {useHandleAction} from '../mixins/HandlesActions'

    export default {
        props: ["index", "resource", "resourceName", "resourceId", "field"],

        data: () => ({
            action_run_successfully: null,
            buttons: [],
            action_handler: null,
            options: null,
            action_label: null,
        }),

        mounted() {
            let buttons = this.field.use_field_value
                ? this.field.value
                : this.field.button;
            if (typeof buttons !== "object") {
                buttons = { buttons };
            }
            this.buttons = buttons;

            if (this.field.action) {
                this.action_label = this.field.actionLabel ?? 'Run action: ' + this.field.action.name;

                this.action_handler = useHandleAction({
                    queryString: {
                        action: this.field.action.uriKey,
                    },
                    resourceName: this.resourceName,
                    selectedAction: this.field.action,
                    selectedResources: [this.field.resourceId],
                });

                this.options = {
                    show: true,
                    errors: this.action_handler.errors?.value,
                    action: this.field.action,
                    working: this.action_handler.working?.value === true,
                    resourceName: this.resourceName,
                    selectedResources: [this.field.resourceId],
                }
            }
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
