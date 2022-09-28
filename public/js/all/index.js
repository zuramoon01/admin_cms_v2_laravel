const deleteItem = (e) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            const item = e.parentElement.parentElement.parentElement;
            const url = {
                ...e.dataset,
            }.url;

            axios
                .delete(url)
                .then(({ data }) => {
                    if (data === "success") {
                        item.remove();
                        // prettier-ignore
                        Swal.fire("Deleted!", "Your item has been deleted.", "success");
                    } else {
                        Swal.fire("Warning!", data, "warning");
                    }
                })
                .catch((err) => console.log(err));
        }
    });
};
