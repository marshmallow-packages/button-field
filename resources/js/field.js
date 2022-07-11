import IndexField from "./components/IndexField";
import DetailField from "./components/DetailField";
import FormField from "./components/FormField";
import ButtonComponent from "./components/ButtonComponent";

Nova.booting((app, store) => {
    app.component("index-button-field", IndexField);
    app.component("detail-button-field", DetailField);
    app.component("form-button-field", FormField);
    app.component("button-component", ButtonComponent);
});
