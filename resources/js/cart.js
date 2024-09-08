(function($e)
{
    $('.item-quantity').on('change',function(e)
    {
        $.ajax({
            url: "/cart/" + $(this).data('id'), //data-id
            method:'put',
            data:{
                quantity:$(this).val(),
                _token:csrf_token,
                
            }
        });
    });
    $('.remove-item').on('click',function(e)
    {
        $.ajax({
            url: "/cart/" + $(this).data('id'), //data-id
            method:'delete',
            data:{
                _token:csrf_token, },
                success: response=> {
                    $(`#${id}`).remove();
               
            }
        });
    });
})(jQuery);

// (function($)
// {
//     $('.item-quantity').on('change', function(e)
//     {
//         $.ajax({
//             url: "/cart/" + $(this).data('id'), // تأكد من أن المسار صحيح ويحتوي على "/"
//             method: "put",
//             data: {
//                 quantity: $(this).val(),
//                 _token: csrf_token, // جلب csrf_token من المتغير الذي تم تعريفه في الأعلى
//             },
//             success: function(response) {
//                 console.log('Quantity updated successfully:', response);
//                 // هنا يمكنك تحديث الواجهة أو عرض رسالة نجاح للمستخدم
//             },
//             error: function(error) {
//                 console.error('Error updating quantity:', error);
//                 // هنا يمكنك عرض رسالة خطأ للمستخدم
//             }
//         });
//     });
// })(jQuery);
