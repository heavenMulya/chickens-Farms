/** =========================
 * 📦 CRUD Utility Toolkit
 * =========================
 * - dynamicGet(): Fetch & render data with pagination
 * - handleCreate(): POST new record
 * - handleEditModalOpen(): Auto-fill edit form
 * - handleEditSubmit(): PUT/UPDATE record
 * - handleDelete(): DELETE record with SweetAlert
 * 
 * Author: heaven lyamuya ✨
 * =========================
 */

  function collectFormDataFromContainer(containerSelector) {
    const formData = new FormData();
    const container = $(containerSelector);

    container.find('[name]').each(function () {
      const input = $(this);
      const name = input.attr('name');
      const type = input.attr('type');

      if (type === 'file') {
        const file = input[0].files[0];
        if (file) {
          formData.append(name, file);
        } else {
          const existingImage = container.find('[name="existing_image"]').val();
          if (existingImage) {
            formData.append('image', existingImage);
          }
        }
      } else if (name !== 'existing_image') {
        formData.append(name, input.val());
      }
    });

    return formData;
  }


function dynamicGet({
    url,
    renderRow,
    tableBodySelector = '#table_body',
    pagination = true,
    totalSelector = '#total_list',
    entryInfoSelector = '#entry-info',
    onSuccess = null,
    onError = null
}) {
    // 🟡 Show loader before request
    $('#loader').show();
    $('#table-container').hide();
    $('#pagination-container').hide();
    $('#no-data').hide();

    $.ajax({
        method: 'GET',
        url: url,
        dataType: 'json',
        success: function (response) {
         
            const data = response.data.data;
            console.log(response)
        $('#no-data').hide();
    $('#table-container').hide();
    $('#pagination-container').hide();
    
            const tbody = $(tableBodySelector).empty();
            if (data.length === 0) {
                $('#no-data').show();
                  $('#loader').hide();
            } else {
                data.forEach(item => tbody.append(renderRow(item)));
                $('#table-container').show();
                $('#pagination-container').show();
                 $('#loader').hide();

                if (pagination) {
                    const { current_page, per_page, total } = response.data;
                    const start = (current_page - 1) * per_page + 1;
                    const end = Math.min(total, current_page * per_page);

                    $(totalSelector).text(`( ${total} ) Records`);
                    $(entryInfoSelector).text(`Showing ${start} to ${end} of ${total} entries`);

                    if (typeof renderPagination === 'function') {
                        renderPagination(response.data);
                    }
                }
            }

            if (typeof onSuccess === 'function') onSuccess(response);

            // ✅ Hide loader when data is ready
            $('#loader').hide();
        },
        error: function (error) {
            if (typeof onError === 'function') onError(error);
            else console.error('Fetch error:', error);
console.log(error)
            $('#loader').hide();
            $('#no-data').show();
        }
    });
}

function renderPagination(paginationData) {
  const paginationList = $('#pagination'); // ul
  paginationList.empty(); // Clear old buttons

  const currentPage = paginationData.current_page;
  const lastPage = paginationData.last_page;
  const total = paginationData.total;
  const perPage = paginationData.per_page;
  const start = (currentPage - 1) * perPage + 1;
  const end = Math.min(total, currentPage * perPage);

  // Update info text
  $('#showing-start').text(start);
  $('#showing-end').text(end);
  $('#total-records').text(total);

  // Previous button
  paginationList.append(`
    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
    </li>
  `);

  // Page number buttons (max 5 visible)
  const maxVisible = 5;
  let startPage = Math.max(1, currentPage - 2);
  let endPage = Math.min(lastPage, startPage + maxVisible - 1);
  if (endPage - startPage < maxVisible - 1) {
    startPage = Math.max(1, endPage - maxVisible + 1);
  }

  for (let i = startPage; i <= endPage; i++) {
    paginationList.append(`
      <li class="page-item ${i === currentPage ? 'active' : ''}">
        <a class="page-link" href="#" data-page="${i}">${i}</a>
      </li>
    `);
  }

  // Next button
  paginationList.append(`
    <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
    </li>
  `);

  // Show the container
  $('#pagination-container').show();
}


/** 🆕 Create New Record (POST) */
function handleCreatewithnoimage({
  buttonSelector = '#save',
  containerSelector = '#add', // <--- modal ID here
  url,
  modalSelector = '#add',
     batchSelector = '#batch_code' ,
     batchType = 'broiler'
  //successAlertSelector = '#success-alert',
  //errorAlertSelector = '#error-alert',
  //successMessageSelector = '#success-message',
  //errorMessageSelector = '#error-message'

 
}) {
     $(modalSelector).on('show.bs.modal', function () {
       getBatch({
         selector: batchSelector,
         selected: null,
         type: batchType   // default to "No Batch"
       });
     });

  $(document).on('click', buttonSelector, function (e) {
    e.preventDefault();

    const formData = {};
$(containerSelector).find('[name]').each(function () {
  const name = $(this).attr('name');
  const value = $(this).val();
  if (name) {
    formData[name] = value;
  }
});

// Debug log:
for (let key in formData) {
  console.log(`hello${key}:`, formData[key]);
}

    $.ajax({
      method:'POST',
      url,
       dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(formData),
      success: function (response) {
         showSuccess(response.message);
        $(modalSelector).modal('hide');
       setTimeout(() => window.location.reload(), 10000);
      },
      error: function (error) {
        const msg = error.responseJSON?.message || error.responseText || 'Something went wrong';
 showError(msg);
        $(modalSelector).modal('hide');
      }
    });
  });
}


/** 🆕 Create New Record (POST) */
function handleCreate({
  buttonSelector = '#save',
  containerSelector = '#add', // <--- modal ID here
  url,
  modalSelector = '#add',
     batchSelector = '#batch_code',
     batchType = 'broiler' 
 // successAlertSelector = '#success-alert',
 // errorAlertSelector = '#error-alert',
 // successMessageSelector = '#success-message',
 // errorMessageSelector = '#error-message'

 
}) {
     $(modalSelector).on('show.bs.modal', function () {
       getBatch({
         selector: batchSelector,
         selected: null ,
         type: batchType  // default to "No Batch"
       });
     });

  $(document).on('click', buttonSelector, function (e) {
    e.preventDefault();

    const formData = collectFormDataFromContainer(containerSelector);
    $.ajax({
      method:'POST',
      url,
      data:formData,
      processData: false,
      contentType: false,
       dataType: 'json',
      success: function (response) {
         showSuccess(response.message);
        $(modalSelector).modal('hide');
       setTimeout(() => window.location.reload(), 10000);
        console.log(response.message)
        //window.location.reload();
      },
      error: function (error) {
        const msg = error.responseJSON?.message || error.responseText || 'Something went wrong';
        showError(msg);
        $(modalSelector).modal('hide');
      }
    });
  });
}


/** ✏️ Fill Edit Form with Data */
function handleEditModalOpen({
  triggerSelector,
  containerSelector,
  modalId
}) {
  $(document).on('click', triggerSelector, function () {
    const data = $(this).data();
    console.log('Clicked element data:', data);
    const container = $(containerSelector);

    // Call getBatch, then fill the form once it's ready
  getBatch({
  selector: '#edit_batch_code',        // Edit form selector
  selected: data.batch_code            // Value from clicked element
}).then(() => {
      Object.keys(data).forEach(key => {
        const element = container.find(`[name="${key}"]`);
        if (element.length) {
          if (element.attr('type') === 'file') return;
          if (element.is('img')) {
            element.attr('src', data[key]).show();
          } else {
            element.val(data[key]);
          }
        }
      });

      if (data.image) {
        const imgPreview = container.find('#edit_image_preview');
        imgPreview.attr('src', data.image).show();
        container.find('#edit_existing_image').val(data.image);
      } else {
        container.find('#edit_image_preview').hide();
        container.find('#edit_existing_image').val('');
      }

      const modal = new bootstrap.Modal(document.getElementById(modalId));
      modal.show();
    });
  });
}


function getBatch({ selector = '#batch_code', selected = null, type = 'broiler' } = {}) {
  return $.ajax({
    url: `https://chickens-farms-production-6aa9.up.railway.app/api/chicken-batches?type=${type}`,
    method: 'GET',
    success: function (res) {
      if (res.success) {
        const dropdown = $(selector);
        dropdown.empty();

        dropdown.append(
          $('<option>', {
            value: '',
            text: 'No Batch / General Expense',
            selected: !selected
          })
        );

        res.data.forEach(batch => {
          dropdown.append(
            $('<option>', {
              value: batch.batch_code,
              text: batch.batch_code,
              selected: batch.batch_code === selected
            })
          );
        });

        dropdown.trigger('change');
      }
    },
    error: function () {
      console.error('Failed to load batches');
    }
  });
}



/** 💾 Submit Edited Data (PUT) */
// 🚀 Enhanced Dynamic Form Handler
function handleEditSubmit({
  buttonSelector,
  containerSelector,
  idFieldName = 'id',
  urlPrefix,
  modalSelector = '#edit'
}) {
  $(document).on('click', buttonSelector, function(e) {
    e.preventDefault();

    // 1. Get form data with proper file handling
    const userId = $(this).data('user_id');
    const formData = new FormData();
    const container = $(containerSelector);
    
    // Append all fields except files
    container.find('[name]:not([type="file"])').each(function() {
      if ($(this).attr('name') !== idFieldName) {
        formData.append($(this).attr('name'), $(this).val());
      }
    });

    // Handle file uploads
    container.find('input[type="file"]').each(function() {
      if (this.files[0]) {
        formData.append($(this).attr('name'), this.files[0]);
      }
    });

  if (userId) {
      formData.append('user_id', userId);
    }
    // For Laravel's method spoofing
    formData.append('_method', 'PUT');

    // 2. Debug output
    console.group('FormData Contents');
    for (let [key, value] of formData.entries()) {
      console.log(key + ':', value instanceof File ? value.name : value);
    }
    console.groupEnd();

    // 3. Make the AJAX call
    $.ajax({
      url: `${urlPrefix}/${container.find(`[name="${idFieldName}"]`).val()}`,
      type: 'POST', // Required for FormData
      data: formData,
      processData: false, // Crucial for files
      contentType: false, // Let browser set boundar
       headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
      success: function(response) {
       showSuccess(response.message);
        $(modalSelector).modal('hide');
       setTimeout(() => window.location.reload(), 10000);
      
      },
      error: function(xhr) {
        let errorMsg = 'Error updating record';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMsg = xhr.responseJSON.message;
        } else if (xhr.status === 302) {
          errorMsg = 'Unexpected redirect occurred';
        }
        showError(errorMsg);
        $(modalSelector).modal('hide');
      }
    });
  });
}

// Helper functions
function showSuccess(msg) {
  $('#success-message').text(msg);
  $('#success-alert').show().delay(10000).fadeOut();
}

function showError(msg) {
  $('#error-message').text(msg);
  $('#error-alert').show().delay(10000).fadeOut();
}

// 🔍 Helper function to show alerts
function showAlert(alertSelector, messageSelector, message) {
  $(messageSelector).text(message);
  $(alertSelector).show().delay(10000).fadeOut();
}

/** ❌ Delete Record with Confirmation */
function handleDelete({
    triggerSelector,
    urlPrefix,
    rowPrefix = "row-",
    reload = true
}) {
    $(document).on('click', triggerSelector, function () {
        const id = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: `${urlPrefix}/${id}`,
                    dataType: 'json',
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        }).then(() => {
                            if (reload) {
                                location.reload();
                            } else {
                                $(`#${rowPrefix}${id}`).remove();
                            }
                        });
                    },
                    error: function (error) {
                        const msg = error.responseJSON?.message || "Something went wrong";
                        Swal.fire({ title: "Error!", text: msg, icon: "error" });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Your data is safe 🙂",
                    icon: "info"
                });
            }
        });
    });
}
