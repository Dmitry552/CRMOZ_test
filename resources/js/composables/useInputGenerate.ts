import {shallowRef} from "vue";
import getInputs from "../utils/mapInputs";

function useInputGenerate() {
    const fieldsForm = shallowRef({});

    async function getInputFields(fields) {
        const groups = {}
        for (let item in fields) {
            groups[item] = generateInput(fields[item], item)
        }

        fieldsForm.value = groups;
    }

    function generateInput(data, index){
        const inputs = []
        data.forEach((item) => {
            const Component = getInputs.get(item.data_type)
            if (!Component) {
                return;
            }
            inputs.push({
                    component: Component,
                    props: setProps(item, index + ".")
                }
            );
        })
        return inputs;
    }

    function setProps(item, key) {
        const baseProps = {
            type: item.data_type,
            title: item.field_label,
            name: key + item.api_name,
            required: item.system_mandatory
        }

        switch (item.data_type) {
            case 'picklist':
                let values: string[] = [];
                item.pick_list_values.forEach((value) => {
                    values.push(value.display_value)
                })
                baseProps.positions = values;
                break;
            default:
                break;
        }

        return baseProps;
    }

    return {
        getInputFields,
        fieldsForm
    }
}

export default useInputGenerate;
