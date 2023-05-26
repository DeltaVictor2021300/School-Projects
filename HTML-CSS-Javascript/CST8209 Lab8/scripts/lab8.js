$(document).ready(function( ) {
    $("h1").text("Lab08");

    $("#header").html("<h3>Working with jQuery</h3>");

    $("input[type='button']").each(function(){
        $(this).addClass("btn-background");
    });

    $("#buttons").each(function(){
        $(this).addClass("red-border");
    });

    $("p").each(function(){
        $(this).addClass("blue");
    });

    $("#first").on("click", function(){
        $("p:first").addClass("green-border");
    });

    $("#last").on("click", function(){
        $("p:last").addClass("orange-border");
    });

    $("#prev").on("click", function(){
        $("#para3").prev().addClass("purple-border");
    });

    $("#next").on("click", function(){
        $("#para2").next().addClass("yellow-border");
    });

    $("#remove").on("click", function(){
        $("#footer").remove();
    })
});