const deleteItem = (e) => {
    const item = e.parentElement.parentElement.parentElement;
    const url = {
        ...e.dataset,
    }.url;

    axios
        .delete(url)
        .then((res) => {
            if (res.data === "success") item.remove();
        })
        .catch((err) => console.log(err));
};
