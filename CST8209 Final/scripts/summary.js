//gets values from local storage and puts them in the lists
document.querySelector("#name").innerText = "name: "+localStorage.getItem('name');
document.querySelector("#age").innerText = "age: "+localStorage.getItem('age');
document.querySelector("#date").innerText = "date: "+localStorage.getItem('date');
document.querySelector("#payment").innerText = "payment: "+localStorage.getItem('payment');
document.querySelector("#member").innerText = "is Member: "+localStorage.getItem('member');
document.querySelector("#sex").innerText = "sex: "+localStorage.getItem('sex');

document.querySelector("#bmw").innerText = localStorage.getItem('bmw')+" BMW";
document.querySelector("#mini").innerText = localStorage.getItem('mini')+" Mini Cooper";
document.querySelector("#van").innerText = localStorage.getItem('van')+" Van";
document.querySelector("#tundra").innerText = localStorage.getItem('tundra')+" tundra";