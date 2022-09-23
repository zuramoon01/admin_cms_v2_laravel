const deleteItem = (e) => {
    const productCategory = e.parentElement.parentElement.parentElement;
    const url = {
        ...e.dataset,
    }.url;

    axios
        .delete(url)
        .then((res) => {
            if (res.data === "success") productCategory.remove();
        })
        .catch((err) => console.log(err));
};
