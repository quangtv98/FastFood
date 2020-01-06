// // Chức năng chọn hết
// document.getElementById('action').onclick = function () 
// {
//     if(this.checked){
//         // Lấy danh sách checkbox
//         var checkboxes = document.getElementsByName('choose[]');

//         // Lặp và thiết lập checked
//         for (var i = 0; i < checkboxes.length; i++){
//             checkboxes[i].checked = true;
//         }
//         // Lấy danh sách checkbox
//         var checkboxes = document.getElementsByName('chooseGroup[]');

//         // Lặp và thiết lập checked
//         for (var i = 0; i < checkboxes.length; i++){
//             checkboxes[i].checked = true;
//         }
//     }
//     else{
//         // Lấy danh sách checkbox
//         var checkboxes = document.getElementsByName('choose[]');

//         // Lặp và thiết lập Uncheck
//         for (var i = 0; i < checkboxes.length; i++){
//             checkboxes[i].checked = false;
//         }
//     }
// };      

// chức năng chọn loại khuyến mãi
document.getElementById('radio1').onclick = function (obj) {
    var choose = document.getElementById('show_promotions');
    var message = document.getElementById('show_message');
    var unit = document.getElementById('show_unit');
    if(this.checked){
        $("#input-value").show("slow");
        $("#btn-choose").hide("slow");
        document.getElementById('value').disabled = false;
        choose.innerHTML = "Nhập vào giá trị khuyến mãi:";
        message.innerHTML = "Số tiền này sẽ trừ vào các sản phẩm được áp dụng khuyến mãi:";
        unit.innerHTML = "VND";
    }
}

document.getElementById('radio2').onclick = function (obj) {
    var choose = document.getElementById('show_promotions');
    var message = document.getElementById('show_message');
    var unit = document.getElementById('show_unit');
    if(this.checked){
        $("#input-value").show("slow");
        $("#btn-choose").hide("slow");
        document.getElementById('value').disabled = false;
        choose.innerHTML = "Nhập vào phần trăm khuyến mãi:";
        message.innerHTML = "Phần trăm này sẽ trừ vào các sản phẩm được áp dụng khuyến mãi:";
        unit.innerHTML = "%";
    }
}


document.getElementById('radio3').onclick = function (obj) {
    var choose = document.getElementById('show_promotions');
    var message = document.getElementById('show_message');
    document.getElementById('input-value').value = 0;
    document.getElementById('value').disabled = true;
    if(this.checked){
        $("#input-value").hide("slow");
        $("#btn-choose").show("slow");
    }
}