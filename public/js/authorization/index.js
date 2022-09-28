document.addEventListener("DOMContentLoaded", () => {
    // Vars
    const selectRole = document.querySelector("#role");
    const tbody = document.querySelector("tbody");
    const saveBtn = document.querySelector("#save");

    let menus = [];
    let authorizationTypes = [];
    let authorizationsByRole = [];

    // Events
    // Get All Menu
    const getMenus = () => {
        axios
            .get("/api/menu/all")
            .then(({ data }) => {
                menus = data;
            })
            .catch((err) => console.log(err));
    };
    getMenus();

    // Get All AuthorizationType
    const getAuthorizationTypes = () => {
        axios
            .get("/api/authorization-type/all")
            .then(({ data }) => {
                authorizationTypes = data;
            })
            .catch((err) => console.log(err));
    };
    getAuthorizationTypes();

    // Get Authorizations By Role
    const getAuthorizations = () => {
        const roleId = selectRole.selectedOptions[0].value;

        axios
            .get(`/api/authorization/role/${roleId}`)
            .then(({ data }) => {
                authorizationsByRole = data;
                let allMenus = "";

                menus.map((menu) => {
                    if (menu.name !== "authorization") {
                        // prettier-ignore
                        menu.name = menu.name .split(" ") .map((name) => {
                            return name.charAt(0).toUpperCase() + name.slice(1);
                            }).join(" ");

                        let singleMenu = `
                            <tr class='single-menu'>
                                <td>${menu.name}</td>
                        `;

                        authorizationTypes.map((type) => {
                            // prettier-ignore
                            const newAuthorizations = authorizationsByRole.find((authorization) =>
                                authorization.menus_id === menu.id &&
                                authorization.authorization_types_id === type.id
                            );

                            // prettier-ignore
                            singleMenu += `
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="${type.id}" id="${menu.name + type.name}"
                                        ${newAuthorizations.has_access ? "checked" : ""}>
                                    </div>
                                </td>
                            `;
                        });

                        singleMenu += `
                            </tr>
                        `;

                        allMenus += singleMenu;
                    }
                });

                tbody.innerHTML = allMenus;
            })
            .catch((err) => console.log(err));
    };
    getAuthorizations();

    // Updata Authorizations By Role
    const updateAuthorizations = () => {
        const roleId = selectRole.selectedOptions[0].value;

        axios
            .get(`/api/authorization/role/${roleId}`)
            .then(({ data }) => {
                authorizationsByRole = data;
                menus.map((menu, i) => {
                    if (menu.name !== "authorization") {
                        const trMenu = tbody.children[i];

                        authorizationTypes.map((type, j) => {
                            const tdType = trMenu.children[j + 1];

                            // prettier-ignore
                            const newAuthorizations = authorizationsByRole.find((authorization) =>
                                authorization.menus_id === menu.id &&
                                authorization.authorization_types_id === type.id
                            );

                            // prettier-ignore
                            tdType.innerHTML = `
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="${type.id}" id="${menu.name + type.name}"
                                    ${newAuthorizations.has_access ? "checked" : ""}>
                                </div>
                            `;
                        });
                    }
                });
            })
            .catch((err) => console.log(err));
    };

    // Call Update Authorizations Everytime Role Change
    selectRole.addEventListener("change", () => updateAuthorizations());

    // Update & Save Authorization
    saveBtn.addEventListener("click", () => {
        Swal.fire({
            titleText: "Do you want to save the changes?",
            showDenyButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire("Saved!", "", "success");

                const role =
                    document.querySelector("#role").selectedOptions[0].value;
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

                axios
                    .post("authorizations/save", {
                        data,
                    })
                    .then((res) => console.log(res.data))
                    .catch((err) => console.log(err));
            }
        });
    });
});
