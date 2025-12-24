$("#yojanaIdFinance").on('change', function(){
    var yojanaId = $(this).val();
    var tableHtml = $("#tableHtml");
    $.ajax({
        type : 'POST',
        url  : 'financeReport',
        data : {yojanaId:yojanaId},
        success:function(data){
            console.log(data);
            // if(data == 'noRecord'){
            //     $("#noRecord").html("<div class='card-body' style='text-align:center'><img src='img/no-records.png'></div>");
            // } else {
                tableHtml.html(data);
            // }
        }
    })
})


$("#taluka").on("change", function(){
    var taluka = $(this).val();
    var yojanaHtml = $("#yojanaHtml");
    var submit = $("#submit");
    submit.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
    submit.prop('disabled', true);
    yojanaHtml.html("Please Wait");
    $.ajax({
        type : 'POST',
        url  : 'villagesAjax',
        data : {talukaYojana:taluka},
        success:function(data){
            yojanaHtml.html(data);
            submit.html('Submit');
            submit.prop('disabled', false);
        }
    });
});


/*$("#village").on("change", function(){
    var village = $(this).val();
    var yojanaName = $("#yojanaName").val();
    console.log(village);
    // if(yojanaName == "पाणी पुरवठा योजना"){
        yojanaName.val("पाणी पुरवठा योजना "+village)
    // }
})*/

/*var count = 2;
$("#remove").hide();
var suspected = Number(20);
$("#add").on("click", function on() {

    if (count <= 20) {

        var type = $('#element').val();

        $("#textboxDiv").append("<div class='row'><div class='col-md-4'><div class='form-group'><label for='docName'>Sub Work </label><select class='form-control' name='subWork[]'> <?php $query = mysqli_query($con, 'SELECT * FROM subWorkMaster'); while($result = mysqli_fetch_assoc($query)){ ?><option value='<?php echo $result['id'] ?>'><?php echo $result['subWork'] ?></option><?php } ?></select></div></div><div class='col-md-6'><div class='form-group'><label>Remark </label><input type='text' onkeyup='referred()' class='form-control' required name='remark" + count + "' id='remark'></div></div><div class='col-md-2'><div class='form-group'><label>Amount</label><input type='number' name='amount[]' class='form-control' step='0.01' /></div></div>");
        count = count + 1;
        $("#remove").show();
        if (count - 1 == suspected) {
            $("#add").hide();
        } else {
            $("#add").show();
        }
    }


});

$("#remove").on("click", function () {

    if (count > 2) {
        $("#textboxDiv").children().last().remove();
        count = count - 1;
        $("#add").show();
        if (count == 2) {
            $("#remove").hide();
        }
    } else {
        $("#remove").hide();
    }

});*/