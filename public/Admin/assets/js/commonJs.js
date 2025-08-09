/** =========================
 * CRUD Operations
 * =========================
 * - dynamicGet(): Fetch & render data with pagination
 * - handleCreate(): POST new record
 * - handleEditModalOpen(): Auto-fill edit form
 * - handleEditSubmit(): PUT/UPDATE record
 * - handleDelete(): DELETE record with SweetAlert
 *
 * Author: heaven lyamuya
 * =========================
 */

function collectFormDataFromContainer(containerSelector) {
    const formData = {};
    const container = $(containerSelector);

    container.find("[name]").each(function () {
        const input = $(this);
        const name = input.attr("name");
        const type = input.attr("type");

        if (type === "file") {
            const file = input[0].files[0];
            if (file) {
                formData[name] = file;
            }
        } else if (name !== "existing_image") {
            // Ensure select elements (like role) are captured correctly
            formData[name] = input.is("select")
                ? input.find("option:selected").val()
                : input.val();
        }
    });

    return formData;
}

function dynamicGet({
    url,
    renderRow,
    tableBodySelector = "#table_body",
    pagination = true,
    totalSelector = "#total_list",
    entryInfoSelector = "#entry-info",
    onSuccess = null,
    onError = null,
}) {
    $("#loader").show();
    $("#table-container").hide();
    $("#pagination-container").hide();
    $("#no-data").hide();

    $.ajax({
        method: "GET",
        url: url,
        dataType: "json",
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem("admin_api_token"),
        },
        success: function (response) {
            const data = response.data.data;
            console.log("Fetch response:", response);
            $("#no-data").hide();
            $("#table-container").hide();
            $("#pagination-container").hide();

            const tbody = $(tableBodySelector).empty();
            if (data.length === 0) {
                $("#no-data").show();
                $("#loader").hide();
            } else {
                data.forEach((item) => tbody.append(renderRow(item)));
                $("#table-container").show();
                $("#pagination-container").show();
                $("#loader").hide();

                if (pagination) {
                    const { current_page, per_page, total } = response.data;
                    const start = (current_page - 1) * per_page + 1;
                    const end = Math.min(total, current_page * per_page);

                    $(totalSelector).text(`( ${total} ) Records`);
                    $(entryInfoSelector).text(
                        `Showing ${start} to ${end} of ${total} entries`
                    );

                    if (typeof renderPagination === "function") {
                        renderPagination(response.data);
                    }
                }
            }

            if (typeof onSuccess === "function") onSuccess(response);
            $("#loader").hide();
        },
        error: function (error) {
            if (typeof onError === "function") onError(error);
            else console.error("Fetch error:", error);
            $("#loader").hide();
            $("#no-data").show();
        },
    });
}

function renderPagination(paginationData) {
    const paginationList = $("#pagination");
    paginationList.empty();

    const currentPage = paginationData.current_page;
    const lastPage = paginationData.last_page;
    const total = paginationData.total;
    const perPage = paginationData.per_page;
    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(total, currentPage * perPage);

    $("#showing-start").text(start);
    $("#showing-end").text(end);
    $("#total-records").text(total);

    paginationList.append(`
        <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
            <a class="page-link" href="#" data-page="${
                currentPage - 1
            }">Previous</a>
        </li>
    `);

    const maxVisible = 5;
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(lastPage, startPage + maxVisible - 1);
    if (endPage - startPage < maxVisible - 1) {
        startPage = Math.max(1, endPage - maxVisible + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
        paginationList.append(`
            <li class="page-item ${i === currentPage ? "active" : ""}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `);
    }

    paginationList.append(`
        <li class="page-item ${currentPage === lastPage ? "disabled" : ""}">
            <a class="page-link" href="#" data-page="${
                currentPage + 1
            }">Next</a>
        </li>
    `);

    $("#pagination-container").show();
}

function handleCreatewithnoimage({
    buttonSelector = "#save",
    containerSelector = "#add",
    url,
    modalSelector = "#add",
}) {
    $(document).on("click", buttonSelector, function (e) {
        e.preventDefault();

        const formData = collectFormDataFromContainer(containerSelector);
        delete formData.existing_image; // Remove if present, as no image is used

        console.log("Create form data:", formData);

        $.ajax({
            method: "POST",
            url,
            dataType: "json",
            contentType: "application/json",
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem("admin_api_token"),
            },
            data: JSON.stringify(formData),
            success: function (response) {
                showSuccess(response.message);
                $(modalSelector).modal("hide");
                setTimeout(() => window.location.reload(), 1000);
            },
            error: function (error) {
                const msg =
                    error.responseJSON?.message ||
                    error.responseText ||
                    "Something went wrong";
                showError(msg);
                $(modalSelector).modal("hide");
            },
        });
    });
}

function handleCreate({
    buttonSelector = "#save",
    containerSelector = "#add",
    url,
    modalSelector = "#add",
    batchSelector = "#batch_code",
    batchType = "broiler",
}) {
    $(modalSelector).on("show.bs.modal", function () {
        getBatch({
            selector: batchSelector,
            selected: null,
            type: batchType,
        });
    });

    $(document).on("click", buttonSelector, function (e) {
        e.preventDefault();

        const formData = collectFormDataFromContainer(containerSelector);
        $.ajax({
            method: "POST",
            url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem("admin_api_token"),
            },
            success: function (response) {
                showSuccess(response.message);
                $(modalSelector).modal("hide");
                setTimeout(() => window.location.reload(), 1000);
            },
            error: function (error) {
                const msg =
                    error.responseJSON?.message ||
                    error.responseText ||
                    "Something went wrong";
                showError(msg);
                $(modalSelector).modal("hide");
            },
        });
    });
}

function getBatchTypeFromCode(batchCode) {
    if (!batchCode) return "broiler"; // default fallback
    batchCode = batchCode.toLowerCase();
    if (batchCode.startsWith("layer")) return "layer";
    if (batchCode.startsWith("broiler")) return "broiler";
    // add more types if needed
    return "broiler"; // default fallback
}

function handleEditModalOpen({ triggerSelector, containerSelector, modalId }) {
    $(document).on("click", triggerSelector, function () {
        const data = $(this).data();
        console.log("Clicked element data:", data);

        const container = $(containerSelector);
       const batchType = getBatchTypeFromCode(data.batch_code);
        // First fetch batches and populate dropdown
        getBatch({
            selector: container.find('[name="batch_code"]'),
            selected: data.batch_code, // existing batch to pre-select
            type: batchType,
          

        }).done(() => {
              console.log("Batch type for editing:", data.batch_type);
            // Now populate other fields
            Object.keys(data).forEach((key) => {
                const element = container.find(`[name="${key}"]`);
                if (!element.length) return;
                if (element.is("select")) {
                    element.val(data[key]).trigger("change");
                } else {
                    element.val(data[key]);
                }
            });

            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        });
    });
}

function getBatch({
    selector = "#batch_code",
    selected = null,
    type = "broiler",
} = {}) {
    return $.ajax({
        url: `/api/chicken-batches?type=${type}`,
        method: "GET",
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem("admin_api_token"),
        },
        success: function (res) {
            if (res.success) {
                const dropdown = $(selector);
                dropdown.empty();

                dropdown.append(
                    $("<option>", {
                        value: "",
                        text: "No Batch / General Expense",
                        selected: !selected,
                    })
                );

                res.data.forEach((batch) => {
                    dropdown.append(
                        $("<option>", {
                            value: batch.batch_code,
                            text: batch.batch_code,
                            selected: batch.batch_code === selected,
                        })
                    );
                });

                dropdown.trigger("change");
            }
        },
        error: function () {
            console.error("Failed to load batches");
        },
    });
}

function handleEditSubmit({
    buttonSelector,
    containerSelector,
    idFieldName = "id",
    urlPrefix,
    modalSelector = "#edit",
}) {
    $(document).on("click", buttonSelector, function (e) {
        e.preventDefault();
        // Debug: Log the role select value before collecting form data
        console.log(
            "Role select value before submit:",
            $(containerSelector).find("#edit_role").val()
        );

        const formData = collectFormDataFromContainer(containerSelector);
        // Ensure role is sent as an integer
        if (formData.role) {
            formData.role = parseInt(formData.role);
        }
        // Remove password if empty
        if (!formData.password) {
            delete formData.password;
            delete formData.password_confirmation;
        }
        console.log("Edit form data:", formData);

        $.ajax({
            url: `${urlPrefix}/${formData[idFieldName]}`,
            type: "PUT",
            data: JSON.stringify(formData),
            contentType: "application/json",
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem("admin_api_token"),
                Accept: "application/json",
            },
            
            success: function (response) {
                showSuccess(response.message);
                $(modalSelector).modal("hide");
                setTimeout(() => window.location.reload(), 1000);
            },
            error: function (xhr) {
                function formatError(obj) {
                    if (typeof obj === "string") return obj;
                    if (typeof obj === "object") {
                        return Object.entries(obj)
                            .map(([key, val]) => `${key}: ${val}`)
                            .join(", ");
                    }
                    return "Unknown error";
                }

                let errorMsg = formatError(xhr.responseJSON);
                showError(errorMsg);

                $(modalSelector).modal("hide");
            },
        });
    });
}

function showSuccess(msg) {
    $("#success-message").text(msg);
    $("#success-alert").show().delay(5000).fadeOut();
}

function showError(msg) {
    $("#error-message").text(msg);
    $("#error-alert").show().delay(5000).fadeOut();
}

function showAlert(alertSelector, messageSelector, message) {
    $(messageSelector).text(message);
    $(alertSelector).show().delay(5000).fadeOut();
}

function handleDelete({
    triggerSelector,
    urlPrefix,
    rowPrefix = "row-",
    reload = true,
}) {
    $(document).on("click", triggerSelector, function () {
        const id = $(this).data("id");

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
                $.ajax({
                    method: "DELETE",
                    url: `${urlPrefix}/${id}`,
                    dataType: "json",
                    headers: {
                        Authorization:
                            'Bearer ' + localStorage.getItem("admin_api_token"),
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success",
                        }).then(() => {
                            if (reload) {
                                location.reload();
                            } else {
                                $(`#${rowPrefix}${id}`).remove();
                            }
                        });
                    },
                    error: function (error) {
                        const msg =
                            error.responseJSON?.message ||
                            "Something went wrong";
                        Swal.fire({
                            title: "Error!",
                            text: msg,
                            icon: "error",
                        });
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Your data is safe",
                    icon: "info",
                });
            }
        });
    });
}
