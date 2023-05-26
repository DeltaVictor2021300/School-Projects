class client{ //client class with accessor and setter methods for each variable
    constructor(name, age, date, member, payment, sex){
        this.name = name;
        this.age = age;
        this.date = date;
        this.member = member;
        this.payment = payment;
        this.sex = sex;
    }

    getName(){
        return this.name;
    }

    getAge(){
        return this.age;
    }

    getDate(){
        return this.date;
    }

    getMember(){
        return this.member;
    }

    getPayment(){
        return this.payment;
    }

    getSex(){
        return this.sex;
    }

    changeName(newName){
        this.name = newName;
    }

    changeAge(newAge){
        this.age = newAge;
    }

    changeDate(newDate){
        this.date = newDate;
    }

    changePayment(newPayment){
        this.payment = newPayment;
    }

    changeSex(newSex){
        this.sex = newSex;
    }
}

function validate(event){ //validation script
    event.preventDefault()
    var valid = true;
    
    if ((clientInfo.name.value).length > 20){
        valid = false;
        document.querySelector("#nameError").innerText = "Name too large";
    }

    if ((clientInfo.name.value).length < 2){
        valid = false;
        document.querySelector("#nameError").innerText = "Name too small";
    }

    if (parseInt(clientInfo.age.value) > 100){
        valid = false;
        document.querySelector("#ageError").innerText = "invalid age";
    }

    if (parseInt(clientInfo.age.value) < 18){
        valid = false;
        document.querySelector("#ageError").innerText = "invalid age";
    }

    if(isNaN(parseInt(clientInfo.age.value))){
        valid = false;
        document.querySelector("#ageError").innerText = "invalid age";
    }

    if(Date.parse(clientInfo.date.value) < Date.now()){
        valid = false;
        document.querySelector("#dateError").innerText = "invalid date";
    }

    if(clientInfo.paymentMethod.value == ''){
        valid = false;
        document.querySelector("#paymentError").innerText = "invalid payment option"
    }

    if(clientInfo.sex.value == ''){
        valid = false;
        document.querySelector("#sexError").innerText = 'invalid sex'
    }

    if(valid){ //if valid, sends the values in the client class to local storage as well as the count of items. it then opens the summary
        var clientInformation = new client(clientInfo.name.value, clientInfo.age.value, clientInfo.date.value, clientInfo.isMember.checked, clientInfo.paymentMethod.value, clientInfo.sex.value);
        localStorage.setItem('name', clientInformation.getName());
        localStorage.setItem('age', clientInformation.getAge());
        localStorage.setItem('date', clientInformation.getDate());
        localStorage.setItem('payment', clientInformation.getPayment());
        localStorage.setItem('member', clientInformation.getMember());
        localStorage.setItem('sex', clientInformation.getSex());
        localStorage.setItem("bmw", bmwCount);
        localStorage.setItem("mini", miniCount);
        localStorage.setItem("van", vanCount);
        localStorage.setItem("tundra", tundraCount);
        window.open("summary.html");
    }

    return valid;
}

var value1 = 0;
var value2 = 0;
var value3 = 0;
var value4 = 0;
var subtotal1 = 0;
var subtotal2 = 0;
var subtotal3 = 0;
var subtotal4 = 0;
var request = new XMLHttpRequest(); //Json request
request.onreadystatechange = function(){
    if(request.readyState == 4){
        if(request.status === 200){
            var jsonResponse = JSON.parse(request.responseText); //if json file is recieved sets the gridbox to the values specified in the file
            document.querySelector("#image1").src = jsonResponse.car1.imgRef;
            document.querySelector("#name1").innerText = jsonResponse.car1.name;
            document.querySelector("#value1").innerText = jsonResponse.car1.value;
            document.querySelector("#image2").src = jsonResponse.car2.imgRef;
            document.querySelector("#name2").innerText = jsonResponse.car2.name;
            document.querySelector("#value2").innerText = jsonResponse.car2.value;
            document.querySelector("#image3").src = jsonResponse.car3.imgRef;
            document.querySelector("#name3").innerText = jsonResponse.car3.name;
            document.querySelector("#value3").innerText = jsonResponse.car3.value;
            document.querySelector("#image4").src = jsonResponse.car4.imgRef;
            document.querySelector("#name4").innerText = jsonResponse.car4.name;
            document.querySelector("#value4").innerText = jsonResponse.car4.value;
            value1 = jsonResponse.car1.value;
            value2 = jsonResponse.car2.value;
            value3 = jsonResponse.car3.value;
            value4 = jsonResponse.car4.value;
        }else {
            console.log("request Error");
        }
    }
}
request.open("GET", 'https://raw.githubusercontent.com/deev0013/PleaseWorkIAmLosingMyMInd/main/data.json');
request.send();

var total = 0;
var bmwCount = 0;
var miniCount = 0;
var vanCount = 0;
var tundraCount = 0;

//Events

clientInfo.addEventListener('submit', validate);

document.querySelector("#reset").addEventListener("click", function(){ //reset event
    document.querySelector("#nameError").innerText = "";
    document.querySelector("#ageError").innerText = "";
    document.querySelector("#dateError").innerText = "";
    document.querySelector("#paymentError").innerText = "";
    document.querySelector("#sexError").innerText = "";
    total = 0;
    bmwCount = 0;
    miniCount = 0;
    vanCount = 0;
    tundraCount = 0;
    subtotal1 = 0;
    subtotal2 = 0;
    subtotal3 = 0;
    subtotal4 = 0;
    document.querySelector("#subtotal1").innerText = '';
    document.querySelector("#subtotal2").innerText = '';
    document.querySelector("#subtotal3").innerText = '';
    document.querySelector("#subtotal4").innerText = '';
})

//on clicking a item event it updates the total text box, and also updates the subtotal, and adds 1 to the specific item count

document.querySelector("#image1").addEventListener("click", function(){ //item 1 event
    total += parseInt(value1);
    document.querySelector("#total").readOnly = false;
    document.querySelector("#total").value = total;
    document.querySelector("#total").readOnly = true;
    subtotal1 += parseInt(value1);
    document.querySelector("#subtotal1").innerText = subtotal1;
    bmwCount += 1;
});

document.querySelector("#image2").addEventListener("click", function(){ //item 2 event
    total += parseInt(value2);
    document.querySelector("#total").readOnly = false;
    document.querySelector("#total").value = total;
    document.querySelector("#total").readOnly = true;
    subtotal2 += parseInt(value2);
    document.querySelector("#subtotal2").innerText = subtotal2;
    miniCount += 1;
});

document.querySelector("#image3").addEventListener("click", function(){ //item 3 event
    total += parseInt(value3);
    document.querySelector("#total").readOnly = false;
    document.querySelector("#total").value = total;
    document.querySelector("#total").readOnly = true;
    subtotal3 += parseInt(value3);
    document.querySelector("#subtotal3").innerText = subtotal3;
    vanCount += 1;
});

document.querySelector("#image4").addEventListener("click", function(){ //item 4 event
    total += parseInt(value4);
    document.querySelector("#total").readOnly = false;
    document.querySelector("#total").value = total;
    document.querySelector("#total").readOnly = true;
    subtotal4 += parseInt(value4);
    document.querySelector("#subtotal4").innerText = subtotal4;
    tundraCount += 1;
});