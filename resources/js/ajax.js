$('.attendance-search-form .search-btn').on('click', function() {
    $('.attendance-table').empty(); // もともとある要素を空にする
    $('.search-null').remove(); // 検索結果が0の時のテキストを消す

    let searchMonth = $('#search_month').val();

    if (!searchMonth) {
        return false;
    }


    $.ajax({
        type: 'GET',
        url: 'employee/attendance/index',
        data: {
            'search_month': searchMonth,
        },
        dataType: 'json',
    }).done(function (data) {
        $('.loading').addClass('display-none');
        let html = '';
        if (data.length === 0) {
            html = '<p class="search-null">検索結果がありませんでした。</p>';
        } else {
            $.each(data, function (index, value) {
                let id = value.id;
                let date = value.date;
                let start_time = value.start_time;
                let end_time = value.end_time;
                let break_time = value.break_time;
                html = `
                    <table>
                        <tr class="attendance-list">
                            <td class="col-md-4">${date}</td>
                            <td class="col-md-2">${start_time}</td>
                            <td class="col-md-2">${end_time}</td>
                            <td class="col-md-2">${break_time}</td>
                        </tr>
                    </table>
                    `
            })
        }
        $('.attendance-table').append(html);
    }).fail(function () {
        console.log('通信エラー');
    })
});