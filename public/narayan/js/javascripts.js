$('#internalSearchInput').on('input', performInternalSearch);

$('#internalSearchType').on('change', function () {
    if ($('#internalSearchInput').val().trim().length > 1) {
        performInternalSearch();
    }
});


function performInternalSearch() {
    const keyword = $('#internalSearchInput').val().trim();
    const type = $('#internalSearchType').val();
    const url = $('#internalSearchInput').data('url');
    const selectedText = $('#internalSearchType option:selected').text();
    const heading = `Search Results for ${selectedText}`;
    if (keyword.length > 1 && type !== '') {
        $('#searchspinner')
            .html(`<div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>`)
            .show();

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                keyword: keyword,
                type: type
            },
            success: function (response) {
                let html = '';

                if (response.length > 0) {

                    html += `
                        <div class="mt-3">
                            <p class="fw-semibold text-muted mb-2 fs-13">${heading}</p>
                            <ul class="ps-2 list-unstyled">
                    `;
                    response.forEach(item => {
                        html += `
                            <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                               <a href="${item.url}">
                                    <span><i class="bx ${item.icon} me-2 fs-14 bg-primary-transparent p-2 rounded-circle"></i>${item.name}</span>
                               </a>
                            </li>
                        `;
                    });
                    html += `
                            </ul>
                        </div>
                    `;
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

