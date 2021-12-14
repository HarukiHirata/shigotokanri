$('.attendance-search-form .search-btn').on('click', function() {
    $('.attendance-table tbody').empty(); // もともとある要素を空にする
    $('.search-null').remove(); // 検索結果が0の時のテキストを消す

    let searchMonth = $('#search_month').val();

    if (!searchMonth) {
        return false;
    }


    $.ajax({
        type: 'GET',
        url: 'employee/attendance/index/' + searchMonth,
        data: {
            'search_month': searchMonth,
        },
        dataType: 'json',
    }).done(function (data) {

    });
});