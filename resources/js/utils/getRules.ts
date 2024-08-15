import {string} from "yup";

const getRules = new Map([
    ['Phone', string().max(30).label('Phone')],
    ['Website', string().max(200).label('Website').matches(/^(https?:\/\/)?(www\.)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,6}(\/[^\s]*)?$/, { excludeEmptyString: true, message: 'Invalid URL format' })],
    //...
]);

export default getRules;
