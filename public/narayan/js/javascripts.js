const script = document.createElement('script');
script.src = "https://unpkg.com/feather-icons";
document.head.appendChild(script);
script.onload = function() {
    feather.replace();
};

  

$(document).ready(function () {
    
    $('#internalSearchInput').on('input', performInternalSearch);

    $('#internalSearchType').on('change', function () {
        if ($('#internalSearchInput').val().trim().length > 1) {
            performInternalSearch();
        }
    });

    $(document).on('click', function (e) {
        var searchBox = $('#internalSearchInput');
        var searchResults = $('#searchResults');

        if (!searchBox.is(e.target) && !searchResults.is(e.target) && searchResults.has(e.target).length === 0) {
            searchResults.empty().removeClass('active-search');
            searchBox.val('');
        }
    });

    function performInternalSearch() {
        const keyword = $('#internalSearchInput').val().trim();
        const type = $('#internalSearchType').val();
        const url = $('#internalSearchInput').data('url');
        const selectedText = $('#internalSearchType option:selected').text();
        const heading = `Search Results for ${selectedText}`;
    
        if (keyword.length > 1 && type !== '') {
            $('#searchResults').empty().removeClass('active-search');
            $('#searchspinner').html(`<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>`).show();
    
            $.ajax({
                url: url,
                method: 'GET',
                data: { keyword, type },
                success: function (response) {
                    let html = '';
    
                    if (response.length > 0) {
                        html += `<div class="mt-3"><p class="fw-semibold text-muted mb-2 fs-13">${heading}</p><ul class="ps-2 list-unstyled">`;
                    
                        response.forEach(item => {
                            html += `
                                <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                   <a href="${item.url}">
                                        <span><i class="bx ${item.icon} me-2 fs-14 bg-primary-transparent p-2 rounded-circle"></i>${item.name}</span>
                                   </a>
                                </li>`;
                        });
                    
                        html += `</ul>`;
                    
                        if (type !== 'business_models') {
                            const encodedKeyword = encodeURIComponent(keyword);
                            const encodedType = encodeURIComponent(type);
                    
                            html += `
                                <div class="text-end mt-2">
                                    <a href="/websites/search/result?keyword=${encodedKeyword}&type=${encodedType}" class="btn btn-sm btn-outline-primary" target="_blank">View All</a>
                                </div>`;
                        }
                    
                        html += `</div>`;
                    } else {
                        html = '<p class="text-muted">No results found.</p>';
                    }
    
                    $('#searchResults').html(html).addClass('active-search');
                },
                error: function () {
                    $('#searchResults').html('<p class="text-danger">Something went wrong. Please try again.</p>');
                },
                complete: function () {
                    $('#searchspinner').hide().empty();
                }
            });

        } else {
            $('#searchResults').empty().removeClass('active-search');
            $('#searchspinner').hide().empty();
        }
    }
    


});

 $('#copyInvoicenumber').on('click', function () {
        const invoiceInput = document.getElementById('invoice_number');
        if (invoiceInput.value.trim() === '') {
            toastr.warning('Invoice number has not been generated yet.');
            return;
        }
        const invoiceValue = invoiceInput.value;
        const tempTextArea = document.createElement('textarea');
        tempTextArea.value = invoiceValue;
        document.body.appendChild(tempTextArea);
        tempTextArea.select();
        tempTextArea.setSelectionRange(0, 99999); 
        document.execCommand('copy');
        document.body.removeChild(tempTextArea);
        toastr.success('Invoice number copied to clipboard!');
    });

function replaceFeatherIconsTemporarily() {
        const fields = [
            { input: '#current_amount', postfixSelector: '#current_amount' },
            { input: '#discount_amount', postfixSelector: '#discount_amount' },
            { input: '#invoice_amount', postfixSelector: '#update_invoice_amount' } 
        ];
    
        fields.forEach(function(fieldObj) {
            const $input = $(fieldObj.input);

            const $postfix = $(fieldObj.postfixSelector).closest('.input-group').find('.input-group-text').last();
    
            if ($postfix.length === 0) {
                console.warn(`Postfix not found for ${fieldObj.input}`);
                return;
            }
    
            const originalHTML = $postfix.html();
    
            $postfix.html('<i data-feather="check" class="text-white" style="width: 17px;"></i>')
                    .addClass('bg-success');
            $input.addClass('text-success');
            feather.replace();
    
            setTimeout(() => {
                $postfix.html(originalHTML).removeClass('bg-success');
                feather.replace();
            }, 5000);
        });
    }
    


function getLoaderRowHTML(colspan = 6) {
    return `
        <tr id="loaderRow">
            <td colspan="${colspan}" class="text-center py-4">
                <svg class="pl" width="240" height="240" viewBox="0 0 240 240">
                    <circle class="pl__ring pl__ring--a" cx="120" cy="120" r="105" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round"></circle>
                    <circle class="pl__ring pl__ring--b" cx="120" cy="120" r="35" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round"></circle>
                    <circle class="pl__ring pl__ring--c" cx="85" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                    <circle class="pl__ring pl__ring--d" cx="155" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                </svg>
            </td>
        </tr>
    `;
}

function getPrinterLoaderRowHTML(colspan = 6) {
    return `
        <tr id="loaderRow">
            <td colspan="${colspan}" style="padding: 0.5rem;">
                <div style="height: 100px; display: flex; align-items: center; justify-content: center;">
                    <div class="typewriter">
                        <div class="slide"><i></i></div>
                        <div class="paper"></div>
                        <div class="keyboard"></div>
                    </div>
                </div>
            </td>
        </tr>
    `;
}



function getProductsSearchRowHTML(colspan = 6) {
    return `
        <tr id="loaderRow">
            <td colspan="${colspan}" class="text-center py-4" style="position: relative; height: 180px;">
                <div id="wifi-loader" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: flex; justify-content: center; align-items: center;">
                    <svg class="circle-outer" viewBox="0 0 86 86">
                        <circle class="back" cx="43" cy="43" r="40"></circle>
                        <circle class="front" cx="43" cy="43" r="40"></circle>
                        <circle class="new" cx="43" cy="43" r="40"></circle>
                    </svg>
                    <svg class="circle-middle" viewBox="0 0 60 60">
                        <circle class="back" cx="30" cy="30" r="27"></circle>
                        <circle class="front" cx="30" cy="30" r="27"></circle>
                    </svg>
                    <svg class="circle-inner" viewBox="0 0 34 34">
                        <circle class="back" cx="17" cy="17" r="14"></circle>
                        <circle class="front" cx="17" cy="17" r="14"></circle>
                    </svg>
                   
                </div>
            </td>
        </tr>
    `;
}


function getErrorRowHTML(message,colspan=7) {
    return `
        <tr id="error-row">
            <td colspan="${colspan}" class="text-center text-muted">
                <div class="alert alert-danger" role="alert">
                    ${message}
                </div>
            </td>
        </tr>
    `;
}

