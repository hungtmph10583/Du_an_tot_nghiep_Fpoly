// let carts = document.querySelector('.carts');
// let address = document.querySelector('.address');
// let truck = document.querySelector('.truck');
// let pay = document.querySelector('.pay');
// let bill = document.querySelector('.bill');

// let cartNext = document.getElementById('cart-next');
// let addressNext = document.getElementById('address-next');
// let truckNext = document.getElementById('truck-next');
// let payNext = document.getElementById('pay-next');

// var btnCART = document.getElementById('btn-cart');
// var btnADDR = document.getElementById('btn-address');
// var btnTRUK = document.getElementById('btn-truck');
// var btnPAY = document.getElementById('btn-pay');
// var btnBILL = document.getElementById('btn-bill');

// var currentLocation = window.location.pathname;

// document.addEventListener('click', function(event) {
//     var isClickInsideCARTNext = cartNext.contains(event.target);
//     var isClickInsideADDRNext = addressNext.contains(event.target);
//     var isClickInsideTRUKNext = truckNext.contains(event.target);
//     var isClickInsidePAYNext = payNext.contains(event.target);

//     var isClickInsideCART = btnCART.contains(event.target);
//     var isClickInsideADDR = btnADDR.contains(event.target);
//     var isClickInsideTRUK = btnTRUK.contains(event.target);
//     var isClickInsidePAY = btnPAY.contains(event.target);
//     var isClickInsideBILL = btnBILL.contains(event.target);

//     if (isClickInsideCARTNext) {
//         carts.classList.add('active');
//         address.classList.remove('active');
//         truck.classList.remove('active');
//         pay.classList.remove('active');
//         bill.classList.remove('active');
//         // 
//         btnCART.classList.add('active');
//         btnADDR.classList.remove('active');
//         btnTRUK.classList.remove('active');
//         btnPAY.classList.remove('active');
//         btnBILL.classList.remove('active');
//     }
//     // console.log(currentLocation);
//     if (isClickInsideCART) {
//         carts.classList.add('active');
//         address.classList.remove('active');
//         truck.classList.remove('active');
//         pay.classList.remove('active');
//         bill.classList.remove('active');
//         // 
//         btnCART.classList.add('active');
//         btnADDR.classList.remove('active');
//         btnTRUK.classList.remove('active');
//         btnPAY.classList.remove('active');
//         btnBILL.classList.remove('active');
//     }

//     if (isClickInsideADDR || isClickInsideCARTNext) {
//         address.classList.add('active');
//         truck.classList.remove('active');
//         pay.classList.remove('active');
//         bill.classList.remove('active');
//         carts.classList.remove('active');
//         // 
//         btnADDR.classList.add('active');
//         btnTRUK.classList.remove('active');
//         btnPAY.classList.remove('active');
//         btnBILL.classList.remove('active');
//         btnCART.classList.remove('active');
//     }

//     if (isClickInsideTRUK || isClickInsideADDRNext) {
//         truck.classList.add('active');
//         pay.classList.remove('active');
//         bill.classList.remove('active');
//         carts.classList.remove('active');
//         address.classList.remove('active');
//         // 
//         btnTRUK.classList.add('active');
//         btnPAY.classList.remove('active');
//         btnBILL.classList.remove('active');
//         btnCART.classList.remove('active');
//         btnADDR.classList.remove('active');
//     }

//     if (isClickInsidePAY || isClickInsideTRUKNext) {
//         pay.classList.add('active');
//         bill.classList.remove('active');
//         carts.classList.remove('active');
//         address.classList.remove('active');
//         truck.classList.remove('active');
//         // 
//         btnPAY.classList.add('active');
//         btnBILL.classList.remove('active');
//         btnCART.classList.remove('active');
//         btnADDR.classList.remove('active');
//         btnTRUK.classList.remove('active');
//     }

//     if (isClickInsideBILL || isClickInsidePAYNext) {
//         bill.classList.add('active');
//         carts.classList.remove('active');
//         address.classList.remove('active');
//         truck.classList.remove('active');
//         pay.classList.remove('active');
//         // 
//         btnBILL.classList.add('active');
//         btnCART.classList.remove('active');
//         btnADDR.classList.remove('active');
//         btnTRUK.classList.remove('active');
//         btnPAY.classList.remove('active');
//     }
// });



// // var end = currentLocation.length;

// // var start = currentLocation.lastIndexOf("\/");

// // var active = currentLocation.slice(14, end);
// // console.log(active);

// // let cartActive = document.querySelector('cart');

// // if (active == 'gio-hang.html') {
// //     cartActive.classList.add('active');
// // }

// // var string = "Chào mừng bạn đến với freetuts.net";
// // console.log(end);
// // console.log(currentLocation);
// // console.log("Vị trí xuất hiện chuỗi \ là: " + currentLocation.lastIndexOf("\/"));
// // console.log(currentLocation.slice(start, end));