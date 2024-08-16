import {computed, ref} from "vue";
import {string, object} from 'yup';
import getRules from "../utils/getRules";

function useDataForForm() {
    const dataForForm = ref({})

    function getDataForForm(fields) {
        const rules = {};
        const initialValues = {};
        for (let item in fields) {
            rules[item] = generateRule(fields[item])
            initialValues[item] = generateInitialValues(fields[item])
        }

        initialValues['link'] = false;

        dataForForm.value = {
            validationSchema: rules,
            initialValues: initialValues
        }
    }

    function generateRule(data){
        const rules = {}
        data.forEach((item) => {
            let baseRules = {};
            if (getRules.has(item.api_name) && item.system_mandatory) {
                baseRules = getRules.get(item.api_name).required()
            } else if (getRules.has(item.api_name)) {
                baseRules = getRules.get(item.api_name)
            } else if (item.system_mandatory) {
                baseRules = string().label(item.api_name).required()
            } else {
                baseRules = string().label(item.api_name)
            }
            rules[item.api_name] = baseRules
        })

        return object(rules);
    }

    function generateInitialValues(data){
        const values = {}
        data.forEach((item) => {
            values[item.api_name] = ''
        })

        return values;
    }

    return {
        getDataForForm,
        dataForForm
    }
}

export default useDataForForm;
