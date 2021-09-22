/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 06.07.2021, 11:29
 */

// $(document).ready(function() {
//     $('[data-toggle="tooltip"]').tooltip();
// });

$('.print-button').on('click', function () {
    let w = window.open();
    let printAreaId = $(this).data('print-area')
    let printArea = $('#' + printAreaId);
    w.document.write(printArea.html());
    w.print();
    w.close();
});