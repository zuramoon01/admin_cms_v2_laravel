document.addEventListener("DOMContentLoaded", () => {
    const saveBtn = document.querySelector("#save");

    saveBtn.addEventListener("click", () => {
        const role = document.querySelector("#role").selectedOptions[0].value;
        const singleMenus = document.querySelectorAll(".single-menu");

        const menus = [];
        const types = [];

        singleMenus.forEach((e) => {
            const menu = e.children[0];
            const viewType = e.children[1].children[0].children[0];
            const addType = e.children[2].children[0].children[0];
            const editType = e.children[3].children[0].children[0];
            const deleteType = e.children[4].children[0].children[0];

            menus.push(menu.innerText.toLowerCase());
            types.push([
                viewType.checked ? viewType.value : 0,
                addType.checked ? addType.value : 0,
                editType.checked ? editType.value : 0,
                deleteType.checked ? deleteType.value : 0,
            ]);
        });

        const data = JSON.stringify({
            role,
            menus,
            types,
        });

        console.log(data);

        axios
            .post("authorizations/save", {
                data,
            })
            .then((res) => console.log(res.data))
            .catch((err) => console.log(err));
    });
});
