$(document).ready(function() {
    $("textarea").on("blur", function() {
        var id = $(this).attr('id');
        var desc = $(this).val();
        // console.log(id);

        $.ajax({
            type: "POST",
            url: "update.php",
            data: {id:id, desc:desc},
            cache: false
        })
    });

    $("input").on("blur", function() {
        var id = $(this).attr('id');
        var title = $(this).val();
        // console.log(id);

        $.ajax({
            type:"POST",
            url:"update.php",
            data: {id:id, title:title},
            cache: false
        })
    });
})