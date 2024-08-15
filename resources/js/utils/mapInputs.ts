import MyInput from '../components/ui/MyInput.vue'
import MySelect from "../components/ui/MySelect.vue";

const getInputs = new Map([
    ['text', MyInput],
    ['picklist', MySelect],
    ['phone', MyInput],
    ['website', MyInput]
    //...
]);

export default getInputs;
