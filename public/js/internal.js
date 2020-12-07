String.prototype.replaceAt = function (index, replacement) {
    return this.substr(0, index) + replacement + this.substr(index + replacement.length);
};

String.prototype.splice = function (start, delCount, newSubStr) {
    return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
};

function showErrors(data) {
    $('.error').remove();
    for (let i = 0; i < Object.keys(data.responseJSON.errors).length; i++) {
        if (Object.keys(data.responseJSON.errors)[i] !== undefined) {
            let key = Object.keys(data.responseJSON.errors)[i];
            if (key.indexOf('.') > -1) {
                key += ']';
                for (let j = key.length - 3; j >= 0; j--) {
                    if (key[j] == '.') {
                        if (key.indexOf('.') < j) {
                            key = key.splice(j, 1, '][');
                        } else {
                            key = key.replaceAt(j, '[');
                        }
                    }
                }
            }

            $(`[name="${key}"]`).closest('.error-div').append(`<span class="error">${data.responseJSON.errors[Object.keys(data.responseJSON.errors)[i]].join('<br>')}</span>`);
            $('#' + key + '-error').html(data.responseJSON.errors[key]);
        }
    }
    Lobibox.notify('error', {
        showClass: 'rollIn',
        hideClass: 'rollOut',
        msg: 'Възникна грешка при опита за запис на данните!'
    });
}

function showError(data) {
    for (let i = 0; i < Object.keys(data.responseJSON.errors).length; i++) {
        if (Object.keys(data.responseJSON.errors)[i] !== undefined) {
            let key = Object.keys(data.responseJSON.errors)[i];
            Lobibox.notify('error', {
                showClass: 'rollIn',
                hideClass: 'rollOut',
                msg: `${data.responseJSON.errors[key]}`
            });
        }
    }
}

function showErrorMessage(message) {
    Lobibox.notify('error', {
        showClass: 'rollIn',
        hideClass: 'rollOut',
        msg: `${message}`
    });
}

function showSuccessMessage(message) {
    $('.error').remove();
    Lobibox.notify('success', {
        showClass: 'rollIn',
        hideClass: 'rollOut',
        msg: `${message}`,
    });
}

