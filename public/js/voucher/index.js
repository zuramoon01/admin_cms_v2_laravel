const discValueInput = document.querySelector("#disc_value");
const type2 = document.querySelector("#type1");

// prettier-ignore
const changeDiscType = ({value}) => {
    if (value === '1') {
        discValueInput.removeAttribute('max')
    } else if (value === '2') {
        discValueInput.max = "100"
    }
}

changeDiscType(type2);
