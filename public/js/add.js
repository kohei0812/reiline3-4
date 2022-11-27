// トップページ予約

$(function(){

    $('#next').on('click',function(){
        let name = $('input[name="name"]').val();
    let furigana = $('input[name="furigana"]').val();
    let email = $('input[name="email"]').val();
    let password = $('input[name="password"]').val();

        if(!( name == null ||
            name == "" ||
            furigana == null ||
            furigana == "" ||
            email == null ||
            email == "" ||
            password == null ||
            password == ""  )){
       $('.register-wrapper').addClass('animate');
            }else{
                alert('フォームを記入してください');
            }

    });

    $('#previous').on('click',function(){

       $('.register-wrapper').removeClass('animate');
    });
});
// Notice
$(function(){
$('.modal.fade').addClass('show');

});

// モーダル
$(function(){

    $('.modal-close').on('click',function(){

       $('.reserve-modal').removeClass('active');
       $('.reserve1').addClass('active');
       $('.reserve2').removeClass('active');
       $('.reserve-confirm').removeClass('active');
       $('.driver-list__item.plan_1').removeClass('not-ava');
       $('.driver-list__item.plan_2').removeClass('not-ava');
       $('.driver-list__item.disabled').find('input').prop('disabled', false)
       .next().removeClass('disabled').parents('.driver-list__item').removeClass('disabled');
       $('.addship').remove();
       $('#confirm-date').find('td').text("");
       $('#confirm-plan').find('td').text("");
       $('#confirm-bort_num').find('td').text("");
       $('#confirm-place').find('td').text("");
       $('#confirm-price').find('td').text("");
       $('#confirm-memo').find('td').text("");
       $('#confirm-ships').find('td .inner').remove();
       $('#pre-reserve').show();
       $('#wait-reserve').show();
    });
});
// 次へ
$(function(){

    $('#reserve-next').on('click',function(){
    let date = $('input[name="date"]').val();
    let plan = $('#plan').val();
    let boat_num = $('#boat_num').val();
    let place = $('#place').val();
    let price = $('#price').val();

        if(!( date == null ||
            date == "" ||
            plan == null ||
            plan == "" ||
            boat_num == null ||
            boat_num == "" ||
            place == null ||
            place == ""   ||
            price == null ||
            price == ""

            )){


       if(plan == "一部"){
        $('.driver-list__item.plan_2').addClass('not-ava');
        var driver_total = $('.driver-list__item.plan_1').length;
       }else if(plan == "二部"){
        $('.driver-list__item.plan_1').addClass('not-ava');
        var driver_total = $('.driver-list__item.plan_2').length;
       }

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          //POST通信
          type: "post",
          //ここでデータの送信先URLを指定します。
          url: "/driver/search",
          dataType: "json",
          data: {
            reserve_date: date,
            reserve_plan: plan,
          },

        })
          //通信が成功したとき
          .then((res) => {

              for (let i = 0; i < res.length; i++) {
                if(res[i] == true){
                $('.reserve2 .driver-list__item').eq(i).addClass('disabled').find('input').prop('disabled', true).next().addClass('disabled');

                }
              }

              var ava_driver_num =  $('.reserve2 .driver-list__item').not('.disabled, .not-ava').length;


              if(boat_num > driver_total){
                alert('予約できる船数を超えています');
                $('.driver-list__item.plan_1').removeClass('not-ava');
                $('.driver-list__item.plan_2').removeClass('not-ava');
              }else{


              if(boat_num > ava_driver_num ){
                if(!confirm('船数が足りないためキャンセル待ちとなりますがよろしいですか？')){
                    $('.driver-list__item.plan_1').removeClass('not-ava');
                    $('.driver-list__item.plan_2').removeClass('not-ava');
                    return false;

                }else{


                // 以下キャンセル待ち
                $('#pre-reserve').hide();
                for (let i = 0; i < boat_num; i++) {
                    $('.reserve-wrapper').append('<div class="addship addship' + i +'">\
                    <div class="text-right"><span class="current_num">'+ (i+1) +'</span>/<span class="total_num">' + boat_num + '</span>\
                    </div></div>');
                    $('.reserve2 .pattern_form').clone().appendTo('.addship' + i);
                    $('.addship' + i).append('<div class="row mb-3"><div class="col-md-2"></div><div class="col-md-10 d-flex">\
                    <span class="previous previous' + i +' btn btn-success px-5">戻る</span>\
                    <span class="next_ship next_ship' + i +' btn btn-primary px-5 mx-5">次の船へ</span>\
                    </div></div>');
                    $('.addship' + i).find('.pattern').attr('name', 'pattern'+ i);
                  }
                  $('.reserve1').removeClass('active');
                  $('.addship0').addClass('active');
                  $('.next_ship').last().addClass('confirm').text('Confirm').removeClass('next_ship');
                  // キャンセル待ち船追化

                    $('.next_ship').each( function( i, e ){
                        $(this).click(function() {
                            var pattern = $(this).parents('.addship').find('.pattern').val();
                            if(!(
                                pattern == null ||
                                pattern == "" )){

                            $('.addship' + i).removeClass('active');
                            $('.addship' + (i+1)).addClass('active');

                        } else{
                            alert('フォームを記入してください');
                        }
                        });

                    });

                  //キャンセル待ち戻る
                  $('.previous').each( function( i, e ){
                    $(this).click(function() {
                        if($(this).parents('.addship').hasClass('addship0')){
                            $('.driver-list__item.plan_1').removeClass('not-ava');
                            $('.driver-list__item.plan_2').removeClass('not-ava');
                        }
                        $('.addship' + i).removeClass('active');
                        if($(this).parents('.addship').hasClass('addship0')){
                            $('.reserve1').addClass('active');
                            $('.addship').remove();
                        }else{
                        $('.addship' + (i-1)).addClass('active');

                        }
                    });

                     });
                // キャンセル待ち確認

                    $('.confirm').on('click',function(){
                        let confirm_date = $('input[name="date"]').val();
                        let confirm_plan = $('#plan').val();
                        let confirm_boat_num = $('#boat_num').val();
                        let confirm_place = $('#place').val();
                        let confirm_price = $('#price').val();
                        let confirm_memo = $('#memo').val();
                        let confirm_patterns = $(this).parents('.addship').find('.pattern').val();


                        if(!(
                            confirm_patterns == null ||
                            confirm_patterns == ""
                            )){
                            $('.reserve-confirm').addClass('active');
                            $(this).parents('.addship').removeClass('active');

                            $('#confirm-date').find('td').text(confirm_date);
                            $('#confirm-plan').find('td').text(confirm_plan);
                            $('#confirm-boat_num').find('td').text(confirm_boat_num);
                            $('#confirm-place').find('td').text(confirm_place);
                            $('#confirm-price').find('td').text(confirm_price);
                            $('#confirm-memo').find('td').text(confirm_memo);
                            var confirm_ship_num = Number(confirm_boat_num);
                            for (let i = 0; i < confirm_ship_num; i++) {
                            var confirm_pattern =  $('.addship' + (i)).find('.pattern').val();
                            $('#confirm-ships').find('td').append('<div class="inner d-flex">\
                            <span class="w-50 text-center">'+ confirm_pattern +' </span>\
                            </div>\
                            ');

                            }

                            }else{
                                alert('フォームを記入して下さい');
                            }

                    });
                }
              }else{

            // 以下本予約
            $('#wait-reserve').hide();
              for (let i = 0; i < boat_num; i++) {
                $('.reserve-wrapper').append('<div class="addship addship' + i +'">\
                <div class="text-right"><span class="current_num">'+ (i+1) +'</span>/<span class="total_num">' + boat_num + '</span>\
                </div></div>');
                $('.reserve2 .driver_form').clone().appendTo('.addship' + i);
                $('.reserve2 .pattern_form').clone().appendTo('.addship' + i);
                $('.addship' + i).append('<div class="row mb-3"><div class="col-md-2"></div><div class="col-md-10 d-flex">\
                <span class="previous previous' + i +' btn btn-success px-5">戻る</span>\
                <span class="next_ship next_ship' + i +' btn btn-primary px-5 mx-5">次の船へ</span>\
                </div></div>');
                $('.addship' + i).find('.driver').attr('name', 'driver'+ i);
                $('.addship' + i).find('.pattern').attr('name', 'pattern'+ i);
              }
              $('.reserve1').removeClass('active');
              $('.addship0').addClass('active');
              $('.next_ship').last().addClass('confirm').text('Confirm').removeClass('next_ship');
              // 船追化

                $('.next_ship').each( function( i, e ){
                    $(this).click(function() {
                        var ship = $(this).parents('.addship').find('.driver:checked').val();
                        var pattern = $(this).parents('.addship').find('.pattern').val();
                        if(!( ship == null ||
                            ship == "" ||
                            pattern == null ||
                            pattern == "" )){

                        $('.addship' + i).removeClass('active');
                        $('.addship' + (i+1)).addClass('active');$('.addship' + i + ' .driver:checked').val();
                        var nominated = $('.addship' + i + ' .driver:checked').val();
                        $('.addship').find('.driver[value="'+ nominated +'"]').prop('disabled', true).next().addClass('disabled').parents('.driver-list__item').addClass('disabled');
                    } else{
                        alert('フォームを記入してください');
                    }
                    });

                });

              //戻る
              $('.previous').each( function( i, e ){
                $(this).click(function() {
                    if($(this).parents('.addship').hasClass('addship0')){
                        $('.driver-list__item.plan_1').removeClass('not-ava');
                        $('.driver-list__item.plan_2').removeClass('not-ava');
                    }
                    $('.addship' + i).removeClass('active');
                    if($(this).parents('.addship').hasClass('addship0')){
                        $('.reserve1').addClass('active');
                        $('.addship').remove();
                    }else{
                    $('.addship' + (i-1)).addClass('active');
                    var nominated = $('.addship' + (i-1) + ' .driver:checked').val();
                    $('.addship').find('.driver[value="'+ nominated +'"]').prop('disabled', false).next().removeClass('disabled').parents('.driver-list__item').removeClass('disabled');
                    }
                });

                 });
            // 確認

                $('.confirm').on('click',function(){
                    let confirm_date = $('input[name="date"]').val();
                    let confirm_plan = $('#plan').val();
                    let confirm_boat_num = $('#boat_num').val();
                    let confirm_place = $('#place').val();
                    let confirm_price = $('#price').val();
                    let confirm_memo = $('#memo').val();
                    let confirm_patterns = $(this).parents('.addship').find('.pattern').val();
                    let confirm_drivers =  $(this).parents('.addship').find('.driver:checked').val();

                    if(!(
                        confirm_patterns == null ||
                        confirm_patterns == "" ||
                        confirm_drivers  == null ||
                        confirm_drivers == ""
                        )){
                        $('.reserve-confirm').addClass('active');
                        $(this).parents('.addship').removeClass('active');

                        $('#confirm-date').find('td').text(confirm_date);
                        $('#confirm-plan').find('td').text(confirm_plan);
                        $('#confirm-boat_num').find('td').text(confirm_boat_num);
                        $('#confirm-place').find('td').text(confirm_place);
                        $('#confirm-price').find('td').text(confirm_price);
                        $('#confirm-memo').find('td').text(confirm_memo);
                        var confirm_ship_num = Number(confirm_boat_num);
                        for (let i = 0; i < confirm_ship_num; i++) {
                        var confirm_driver =  $('.addship' + (i)).find('.driver:checked').val();
                        var confirm_pattern =  $('.addship' + (i)).find('.pattern').val();
                        $('#confirm-ships').find('td').append('<div class="inner d-flex">\
                        <span class="w-50 border-end text-center">'+ confirm_driver +' </span>\
                        <span class="w-50 text-center">'+ confirm_pattern +' </span>\
                        </div>\
                        ');

                        }

                        }else{
                            alert('フォームを記入してください');
                        }

                });
                }
            }
          })
          //通信が失敗したとき
          .fail((error) => {
            console.log(error.statusText);
          });


            }else{
                alert('フォームを記入して下さい。');
            }

        });


// 戻る
    $('#reserve-previous').on('click',function(){
        $('.reserve1').addClass('active');
        $('.reserve2').removeClass('active');
        $('.driver-list__item.plan_1').removeClass('not-ava');
        $('.driver-list__item.plan_2').removeClass('not-ava');
        $('.driver-list__item.disabled').find('input').prop('disabled', false)
       .next().removeClass('disabled').parents('.driver-list__item').removeClass('disabled');
       $('#pre-reserve').show();
       $('#wait-reserve').show();
    });



// 戻る2
$('#reserve-previous2').on('click',function(){
    $('.addship').last().addClass('active');
    $('.reserve-confirm').removeClass('active');
    $('#confirm-date').find('td').text("");
    $('#confirm-plan').find('td').text("");
    $('#confirm-bort_num').find('td').text("");
    $('#confirm-place').find('td').text("");
    $('#confirm-price').find('td').text("");
    $('#confirm-memo').find('td').text("");
    $('#confirm-ships').find('td .inner').remove();
});


// 本予約

$('#pre-reserve').on('click',function(){

    var pre_num = 0;

    let reserve_date = $('input[name="date"]').val();
    let reserve_plan = $('#plan').val();
    let reserve_boat_num = $('#boat_num').val();
    let reserve_place = $('#place').val();
    let reserve_price = $('#price').val();
    let reserve_memo = $('#memo').val();
    let user_id = $('#user_id').val();
    for (let i = 0; i < reserve_boat_num; i++) {
        var reserve_driver =  $('.addship' + (i)).find('.driver:checked').val();
        var reserve_pattern =  $('.addship' + (i)).find('.pattern').val();

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      //POST通信
      type: "post",
      //ここでデータの送信先URLを指定します。
      url: "/reserve/store",
      dataType: "json",
      data: {
        date: reserve_date,
        plan: reserve_plan,
        boat_num:reserve_boat_num,
        pattern: reserve_pattern,
        place: reserve_place,
        price: reserve_price,
        memo: reserve_memo,
        driver: reserve_driver,
        user_id: user_id,
      },

    })
      //通信が成功したとき
      .then((res) => {

        pre_num += res;
        if( i == (reserve_boat_num - 1)){
            if(pre_num == reserve_boat_num){
                alert('Reserve succeed');
                $('#reserve').trigger("click");
            }else{
                alert('Sorry reserve failed');
                $('#reserve').attr('name', 'delete');
                $('#reserve').trigger("click");
            }
        }
      })
      //通信が失敗したとき
      .fail((error) => {
        console.log(error.statusText);
      });
    }

});

// キャンセル待ち予約

$('#wait-reserve').on('click',function(){

    var pre_num = 0;

    let reserve_date = $('input[name="date"]').val();
    let reserve_plan = $('#plan').val();
    let reserve_boat_num = $('#boat_num').val();
    let reserve_place = $('#place').val();
    let reserve_price = $('#price').val();
    let reserve_memo = $('#memo').val();
    let user_id = $('#user_id').val();
    for (let i = 0; i < reserve_boat_num; i++) {
        var reserve_pattern =  $('.addship' + (i)).find('.pattern').val();

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      //POST通信
      type: "post",
      //ここでデータの送信先URLを指定します。
      url: "/reserve/waitStore",
      dataType: "json",
      data: {
        date: reserve_date,
        plan: reserve_plan,
        boat_num:reserve_boat_num,
        pattern: reserve_pattern,
        place: reserve_place,
        price: reserve_price,
        memo: reserve_memo,
        user_id: user_id,
      },

    })
      //通信が成功したとき
      .then((res) => {

        pre_num += res;
        if( i == (reserve_boat_num - 1)){
            if(pre_num == reserve_boat_num){
                alert('Wait reserve succeed');
                $('#reserve').attr('name', 'wait');
                $('#reserve').trigger("click");
            }else{
                alert('Sorry reserve failed');
                $('#reserve').attr('name', 'delete');
                $('#reserve').trigger("click");
            }
        }
      })
      //通信が失敗したとき
      .fail((error) => {
        console.log(error.statusText);
      });
    }

});

});

// 編集ページ

    //パターン変更
    $(function(){
        $('.pattern_edit').each( function( i, e ){
        $(this).on('click',function(){
            let pattern = $('.pattern').eq(i).val();
            let id = $('.reserve_id').eq(i).val();
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              //POST通信
              type: "post",
              //ここでデータの送信先URLを指定します。
              url: "/reserve/patternEdit",
              dataType: "json",
              data: {
                id: id,
                pattern: pattern,

              },

            })
              //通信が成功したとき
              .then((res) => {

                alert('変更できました');
              })
              //通信が失敗したとき
              .fail((error) => {
                console.log(error.statusText);
              });


        });


    });
    });
// モーダル
// 閉じる
$(function(){

    $('.ship-modal-close').on('click',function(){

       $('.reserve-modal').removeClass('active');
       $('.reserve1').addClass('active');
       $('.reserve2').removeClass('active');
       $('.editShip').removeClass('active');
       $('.reserve-confirm').removeClass('active');
       $('.driver-list__item.plan_1').removeClass('not-ava');
       $('.driver-list__item.plan_2').removeClass('not-ava');
       $('.driver-list__item.disabled').find('input').prop('disabled', false)
       .next().removeClass('disabled').parents('.driver-list__item').removeClass('disabled');
       $('.addship').remove();
       $('#confirm-date').find('td').text("");
       $('#confirm-plan').find('td').text("");
       $('#confirm-bort_num').find('td').text("");
       $('#confirm-place').find('td').text("");
       $('#confirm-price').find('td').text("");
       $('#confirm-memo').find('td').text("");
       $('#confirm-ships').find('td .inner').remove();
       $('#pre-reserve').show();
       $('#wait-reserve').show();
    });
});

    //ドライバー変更
    // editボタン
    $(function(){
        $('.driver_edit').each( function( i, e ){
        $(this).on('click',function(){

           let plan = $('#plan').val();
           let date = $('input[name="date"]').val();

           if(plan == "一部"){
            $('.driver-list__item.plan_2').addClass('not-ava');
           }else if(plan == "二部"){
            $('.driver-list__item.plan_1').addClass('not-ava');
           }

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              //POST通信
              type: "post",
              //ここでデータの送信先URLを指定します。
              url: "/driver/search",
              dataType: "json",
              data: {
                reserve_date: date,
                reserve_plan: plan,
              },

            })
              //通信が成功したとき
              .then((res) => {

                for (let i = 0; i < res.length; i++) {
                    if(res[i] == true){
                    $('.editShip .driver-list__item').eq(i).addClass('disabled').find('input').prop('disabled', true).next().addClass('disabled');

                    }
                  }
                  $('.reserve1').removeClass('active');
                  $('.reserve-modal').addClass('active');
                  $('.editShip').addClass('active');
                  $('.editShip').addClass('editShip' + i);
              })
              //通信が失敗したとき
              .fail((error) => {
                console.log(error.statusText);
              });


        });


    });
    });

    // 戻る
    $('#editShip-previous').on('click',function(){
        $('.reserve1').addClass('active');
        $('.reserve-modal').removeClass('active');
        $('.editShip').removeClass('active');
        $('.driver-list__item.plan_1').removeClass('not-ava');
        $('.driver-list__item.plan_2').removeClass('not-ava');
        $('.driver-list__item.disabled').find('input').prop('disabled', false)
       .next().removeClass('disabled').parents('.driver-list__item').removeClass('disabled');
    });

    // 船変更
    $('#editShip-edit').on('click',function(){
        var date = $('input[name="date"]').val();
        var plan = $('#plan').val();
        var driver =  $('.editShip').find('.driver:checked').val();
        var column_num = $('.reserve_id').length;
        for (let i = 0; i < column_num; i++){
            if($('.editShip').hasClass('editShip' + (i))){
            var id = $('.reserve_id').eq(i).val();
            }
        }
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              //POST通信
              type: "post",
              //ここでデータの送信先URLを指定します。
              url: "/reserve/driverEdit",
              dataType: "json",
              data: {
                id: id,
                driver: driver,
                date:date,
                plan:plan,

              },

            })
              //通信が成功したとき
              .then((res) => {
                if(res == 1){
                $('.ship-modal-close').trigger("click");
                alert('succeed');
                for (let i = 0; i < column_num; i++){
                    if($('.editShip').hasClass('editShip' + (i))){
                    $('.current_driver').eq(i).text(driver);
                    }
                }
                }
                else{
                alert('失敗しました。');
                }
              })
              //通信が失敗したとき
              .fail((error) => {
                console.log(error.statusText);
              });
    });

    // 船削除
    $(function(){
        $('.ship_del').each( function( i, e ){
        $(this).on('click',function(){
        var id = $('.reserve_id').eq(i).val();
        var plan = $('#plan').val();
        var date = $('input[name="date"]').val();
        var user_id = $('#user_id').val();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          //POST通信
          type: "post",
          //ここでデータの送信先URLを指定します。
          url: "/reserve/shipDel",
          dataType: "json",
          data: {
            id: id,
            plan: plan,
            date: date,
            user_id: user_id,
          },

        })
          //通信が成功したとき
          .then((res) => {
            // $('#boat_num').val(res);
            $('.each_ship').eq(i).remove();
            // $('.ship-modal-close').trigger("click");
            alert(res);

          })
          //通信が失敗したとき
          .fail((error) => {
            console.log(error.statusText);
            alert(error);
          });
    });
    });
    });

    // 船追加

    $(function(){
        $('#ship_add').on('click',function(){
            $('.reserve-modal').addClass('active');
        });
    });

    // 次へ

    $(function(){
    $('#ship_add-next').on('click',function(){
        let date = $('input[name="date"]').val();
        let plan = $('#plan').val();
        let boat_num = $('#boat_num').val();
        let place = $('#place').val();
        let price = $('#price').val();

            if(!( date == null ||
                date == "" ||
                plan == null ||
                plan == "" ||
                boat_num == null ||
                boat_num == "" ||
                place == null ||
                place == ""   ||
                price == null ||
                price == ""

                )){


           if(plan == "一部"){
            $('.driver-list__item.plan_2').addClass('not-ava');
            var driver_total = $('.driver-list__item.plan_1').length;
           }else if(plan == "二部"){
            $('.driver-list__item.plan_1').addClass('not-ava');
            var driver_total = $('.driver-list__item.plan_2').length;
           }

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              //POST通信
              type: "post",
              //ここでデータの送信先URLを指定します。
              url: "/driver/search",
              dataType: "json",
              data: {
                reserve_date: date,
                reserve_plan: plan,
              },

            })
              //通信が成功したとき
              .then((res) => {

                  for (let i = 0; i < res.length; i++) {
                    if(res[i] == true){
                    $('.reserve2 .driver-list__item').eq(i).addClass('disabled').find('input').prop('disabled', true).next().addClass('disabled');

                    }
                  }

                  var ava_driver_num =  $('.reserve2 .driver-list__item').not('.disabled, .not-ava').length;


                  if(boat_num > driver_total){
                    alert('予約できる船数を超えています');
                    $('.driver-list__item.plan_1').removeClass('not-ava');
                    $('.driver-list__item.plan_2').removeClass('not-ava');
                  }else{


                  if(boat_num > ava_driver_num ){
                    alert('予約できる船数を超えています');
                    $('.driver-list__item.plan_1').removeClass('not-ava');
                    $('.driver-list__item.plan_2').removeClass('not-ava');
                  }else{

                // 以下本予約

                  for (let i = 0; i < boat_num; i++) {
                    $('.reserve-wrapper').append('<div class="addship addship' + i +'">\
                    <div class="text-right"><span class="current_num">'+ (i+1) +'</span>/<span class="total_num">' + boat_num + '</span>\
                    </div></div>');
                    $('.reserve2 .driver_form').clone().appendTo('.addship' + i);
                    $('.reserve2 .pattern_form').clone().appendTo('.addship' + i);
                    $('.addship' + i).append('<div class="row mb-3"><div class="col-md-2"></div><div class="col-md-10 d-flex">\
                    <span class="previous previous' + i +' btn btn-success px-5">戻る</span>\
                    <span class="next_ship next_ship' + i +' btn btn-primary px-5 mx-5">次の船へ</span>\
                    </div></div>');
                    $('.addship' + i).find('.driver').attr('name', 'driver'+ i);
                    $('.addship' + i).find('.pattern').attr('name', 'pattern'+ i);
                  }
                  $('.reserve1').removeClass('active');
                  $('.addship0').addClass('active');
                  $('.next_ship').last().addClass('confirm').text('Confirm').removeClass('next_ship');
                  // 船追化

                    $('.next_ship').each( function( i, e ){
                        $(this).click(function() {
                            var ship = $(this).parents('.addship').find('.driver:checked').val();
                            var pattern = $(this).parents('.addship').find('.pattern').val();
                            if(!( ship == null ||
                                ship == "" ||
                                pattern == null ||
                                pattern == "" )){

                            $('.addship' + i).removeClass('active');
                            $('.addship' + (i+1)).addClass('active');$('.addship' + i + ' .driver:checked').val();
                            var nominated = $('.addship' + i + ' .driver:checked').val();
                            $('.addship').find('.driver[value="'+ nominated +'"]').prop('disabled', true).next().addClass('disabled').parents('.driver-list__item').addClass('disabled');
                        } else{
                            alert('フォームを記入してください');
                        }
                        });

                    });

                  //戻る
                  $('.previous').each( function( i, e ){
                    $(this).click(function() {
                        if($(this).parents('.addship').hasClass('addship0')){
                            $('.driver-list__item.plan_1').removeClass('not-ava');
                            $('.driver-list__item.plan_2').removeClass('not-ava');
                        }
                        $('.addship' + i).removeClass('active');
                        if($(this).parents('.addship').hasClass('addship0')){
                            $('.reserve1').addClass('active');
                            $('.addship').remove();
                        }else{
                        $('.addship' + (i-1)).addClass('active');
                        var nominated = $('.addship' + (i-1) + ' .driver:checked').val();
                        $('.addship').find('.driver[value="'+ nominated +'"]').prop('disabled', false).next().removeClass('disabled').parents('.driver-list__item').removeClass('disabled');
                        }
                    });

                     });
                // 確認

                    $('.confirm').on('click',function(){
                        let confirm_date = $('input[name="date"]').val();
                        let confirm_plan = $('#plan').val();
                        let confirm_boat_num = $('#boat_num').val();
                        let confirm_place = $('#place').val();
                        let confirm_price = $('#price').val();
                        let confirm_memo = $('#memo').val();
                        let confirm_patterns = $(this).parents('.addship').find('.pattern').val();
                        let confirm_drivers =  $(this).parents('.addship').find('.driver:checked').val();

                        if(!(
                            confirm_patterns == null ||
                            confirm_patterns == "" ||
                            confirm_drivers  == null ||
                            confirm_drivers == ""
                            )){
                            $('.reserve-confirm').addClass('active');
                            $(this).parents('.addship').removeClass('active');

                            var total_boat_num = Number(confirm_boat_num) + Number($('#def_boat-num').html());

                            $('#confirm-date').find('td').text(confirm_date);
                            $('#confirm-plan').find('td').text(confirm_plan);
                            $('#confirm-place').find('td').text(confirm_place);
                            $('#confirm-boat_num').find('td').text(total_boat_num);
                            $('#confirm-price').find('td').text(confirm_price);
                            $('#confirm-memo').find('td').text(confirm_memo);
                            var default_num = $('.each_ship').length;
                            for (let i = 0; i < default_num; i++) {
                            var default_driver =  $('.each_ship').eq(i).find('.current_driver').html();
                            var default_pattern =  $('.each_ship').eq(i).find('.pattern option:selected').text();
                            console.log(default_pattern);
                            $('#confirm-ships').find('td').append('<div class="inner d-flex">\
                            <span class="w-50 border-end text-center">'+ default_driver +' </span>\
                            <span class="w-50 text-center">'+ default_pattern +' </span>\
                            </div>\
                            ');
                            }
                            var confirm_ship_num = Number(confirm_boat_num);
                            for (let i = 0; i < confirm_ship_num; i++) {
                            var confirm_driver =  $('.addship' + (i)).find('.driver:checked').val();
                            var confirm_pattern =  $('.addship' + (i)).find('.pattern').val();
                            $('#confirm-ships').find('td').append('<div class="inner d-flex">\
                            <span class="w-50 border-end text-center">'+ confirm_driver +' </span>\
                            <span class="w-50 text-center">'+ confirm_pattern +' </span>\
                            </div>\
                            ');

                            }

                            }else{
                                alert('フォームを記入してください');
                            }

                    });
                    }
                }
              })
              //通信が失敗したとき
              .fail((error) => {
                console.log(error.statusText);
              });


                }else{
                    alert('フォームを記入してください');
                }

            });
            });

// キャンセル待ち編集


    // 船削除
    $(function(){
        $('.wait_ship_del').each( function( i, e ){
        $(this).on('click',function(){
        var id = $('.reserve_id').eq(i).val();
        var plan = $('#plan').val();
        var date = $('input[name="date"]').val();
        var user_id = $('#user_id').val();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          //POST通信
          type: "post",
          //ここでデータの送信先URLを指定します。
          url: "/reserve/waitShipDel",
          dataType: "json",
          data: {
            id: id,
            plan: plan,
            date: date,
            user_id: user_id,
          },

        })
          //通信が成功したとき
          .then((res) => {
            $('#boat_num').val(res);
            $('.each_ship').eq(i).remove();
            $('.ship-modal-close').trigger("click");
            alert('削除しました。');

          })
          //通信が失敗したとき
          .fail((error) => {
            console.log(error.statusText);
          });
    });
    });
    });

    // 船追加

    $(function(){
        $('#ship_add').on('click',function(){
            $('.reserve-modal').addClass('active');
        });
    });

    // 次へ

    $(function(){
    $('#wait-ship_add-next').on('click',function(){
        let date = $('input[name="date"]').val();
        let plan = $('#plan').val();
        let boat_num = $('#boat_num').val();
        let place = $('#place').val();
        let price = $('#price').val();

            if(!( date == null ||
                date == "" ||
                plan == null ||
                plan == "" ||
                boat_num == null ||
                boat_num == "" ||
                place == null ||
                place == ""   ||
                price == null ||
                price == ""

                )){


           if(plan == "一部"){
            $('.driver-list__item.plan_2').addClass('not-ava');
            var driver_total = $('.driver-list__item.plan_1').length;
           }else if(plan == "二部"){
            $('.driver-list__item.plan_1').addClass('not-ava');
            var driver_total = $('.driver-list__item.plan_2').length;
           }

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              //POST通信
              type: "post",
              //ここでデータの送信先URLを指定します。
              url: "/driver/search",
              dataType: "json",
              data: {
                reserve_date: date,
                reserve_plan: plan,
              },

            })
              //通信が成功したとき
              .then((res) => {

                  for (let i = 0; i < res.length; i++) {
                    if(res[i] == true){
                    $('.reserve2 .driver-list__item').eq(i).addClass('disabled').find('input').prop('disabled', true).next().addClass('disabled');

                    }
                  }

                  if(boat_num > driver_total){
                    alert('予約できる船数を超えています');
                    $('.driver-list__item.plan_1').removeClass('not-ava');
                    $('.driver-list__item.plan_2').removeClass('not-ava');
                  }else{

                  for (let i = 0; i < boat_num; i++) {
                    $('.reserve-wrapper').append('<div class="addship addship' + i +'">\
                    <div class="text-right"><span class="current_num">'+ (i+1) +'</span>/<span class="total_num">' + boat_num + '</span>\
                    </div></div>');
                    $('.reserve2 .pattern_form').clone().appendTo('.addship' + i);
                    $('.addship' + i).append('<div class="row mb-3"><div class="col-md-2"></div><div class="col-md-10 d-flex">\
                    <span class="previous previous' + i +' btn btn-success px-5">戻る</span>\
                    <span class="next_ship next_ship' + i +' btn btn-primary px-5 mx-5">次の船へ</span>\
                    </div></div>');
                    $('.addship' + i).find('.pattern').attr('name', 'pattern'+ i);
                  }
                  $('.reserve1').removeClass('active');
                  $('.addship0').addClass('active');
                  $('.next_ship').last().addClass('confirm').text('Confirm').removeClass('next_ship');
                  // 船追化

                    $('.next_ship').each( function( i, e ){
                        $(this).click(function() {

                            var pattern = $(this).parents('.addship').find('.pattern').val();
                            if(!(  pattern == null ||
                                   pattern == "" )){

                            $('.addship' + i).removeClass('active');

                        } else{
                            alert('フォームを記入してください');
                        }
                        });

                    });

                  //戻る
                  $('.previous').each( function( i, e ){
                    $(this).click(function() {
                        if($(this).parents('.addship').hasClass('addship0')){
                            $('.driver-list__item.plan_1').removeClass('not-ava');
                            $('.driver-list__item.plan_2').removeClass('not-ava');
                        }
                        $('.addship' + i).removeClass('active');
                        if($(this).parents('.addship').hasClass('addship0')){
                            $('.reserve1').addClass('active');
                            $('.addship').remove();
                        }else{
                        $('.addship' + (i-1)).addClass('active');
                        }
                    });

                     });
                // 確認

                    $('.confirm').on('click',function(){
                        let confirm_date = $('input[name="date"]').val();
                        let confirm_plan = $('#plan').val();
                        let confirm_boat_num = $('#boat_num').val();
                        let confirm_place = $('#place').val();
                        let confirm_price = $('#price').val();
                        let confirm_memo = $('#memo').val();
                        let confirm_patterns = $(this).parents('.addship').find('.pattern').val();


                        if(!(
                            confirm_patterns == null ||
                            confirm_patterns == ""
                            )){
                            $('.reserve-confirm').addClass('active');
                            $(this).parents('.addship').removeClass('active');

                            var total_boat_num = Number(confirm_boat_num) + Number($('#def_boat-num').html());

                            $('#confirm-date').find('td').text(confirm_date);
                            $('#confirm-plan').find('td').text(confirm_plan);
                            $('#confirm-place').find('td').text(confirm_place);
                            $('#confirm-boat_num').find('td').text(total_boat_num);
                            $('#confirm-price').find('td').text(confirm_price);
                            $('#confirm-memo').find('td').text(confirm_memo);
                            var default_num = $('.each_ship').length;
                            console.log(default_num);
                            for (let i = 0; i < default_num; i++) {
                            var default_pattern =  $('.each_ship').eq(i).find('.pattern option:selected').text();
                            console.log(default_pattern);
                            $('#confirm-ships').find('td').append('<div class="inner d-flex">\
                            <span class="w-50 text-center">'+ default_pattern +' </span>\
                            </div>\
                            ');
                            }
                            var confirm_ship_num = Number(confirm_boat_num);
                            for (let i = 0; i < confirm_ship_num; i++) {
                            var confirm_pattern =  $('.addship' + (i)).find('.pattern').val();
                            $('#confirm-ships').find('td').append('<div class="inner d-flex">\
                            <span class="w-50 text-center">'+ confirm_pattern +' </span>\
                            </div>\
                            ');

                            }

                            }else{
                                alert('フォームを記入してください');
                            }

                    });

                }
              })
              //通信が失敗したとき
              .fail((error) => {
                console.log(error.statusText);
              });


                }else{
                    alert('フォームを記入してください');
                }

            });
            });

// キャンセル待ち予約
$(function(){
$('#wait_add_ship').on('click',function(){

    var pre_num = 0;

    let reserve_date = $('input[name="date"]').val();
    let reserve_plan = $('#plan').val();
    let reserve_boat_num = $('#boat_num').val();
    let reserve_place = $('#place').val();
    let reserve_price = $('#price').val();
    let reserve_memo = $('#memo').val();
    let user_id = $('#user_id').val();
    for (let i = 0; i < reserve_boat_num; i++) {
        var reserve_pattern =  $('.addship' + (i)).find('.pattern').val();

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      //POST通信
      type: "post",
      //ここでデータの送信先URLを指定します。
      url: "/reserve/waitStore",
      dataType: "json",
      data: {
        date: reserve_date,
        plan: reserve_plan,
        boat_num:reserve_boat_num,
        pattern: reserve_pattern,
        place: reserve_place,
        price: reserve_price,
        memo: reserve_memo,
        user_id: user_id,
      },

    })
      //通信が成功したとき
      .then((res) => {

        pre_num += res;
        if( i == (reserve_boat_num - 1)){
            if(pre_num == reserve_boat_num){
                alert('キャンセル待ち予約完了');

                $('#reserve').trigger("click");
            }else{
                alert('予約できませんでした');
                $('#reserve').attr('name', 'delete');
                $('#reserve').trigger("click");
            }
        }
      })
      //通信が失敗したとき
      .fail((error) => {
        console.log(error.statusText);
      });
    }

});
});
