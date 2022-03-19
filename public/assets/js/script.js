$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //  gate Pass In


    $('#container_form').submit(function(e){
        e.preventDefault();
        var html = '';
        var data = '';
            $.ajax({
                type: "POST",
                url: '/'+$('#preview_url').val(),
                data: $('#container_form').serialize(),
                success: function (response) {
                    if(response.error > 0){
                        swal({
                            title: 'error',
                            text: response.message[0],
                            icon: "error",
                            buttons: true,
                          })
                    }else{
                        data = response.message;
                        html +='<div style="border: 1px solid #00000059;padding:5px">\
                            <h5>Inward Information</h5>\
                            <div class="row">\
                                <div class="col-3"><b>Shipping Line</b> : '+response.message.shipping+'</div>\
                                <div class="col-3"><b>Depot</b> : '+response.message.depot+'</div>\
                                <div class="col-3"><b>Consignee Party</b> : '+response.message.consignee+'</div>\
                                <div class="col-3"><b>Place</b> : '+response.message.place+'</div>\
                                <div class="col-3"><b>Vessel/Voy</b> : '+response.message.vessel+'</div>\
                                <div class="col-3"><b>Transporter</b> : '+response.message.transpoter+'</div>\
                                <div class="col-3"><b>Vehicle #</b> : '+response.message.vehicle+'</div>\
                                <div class="col-3"><b>Booking/Remark</b> : '+response.message.booking+'</div>\
                                <div class="col-3"><b>Port From</b> : '+response.message.port+'</div>\
                                <div class="col-3"><b>CHA</b> : '+response.message.cha+'</div>\
                                <div class="col-3"><b>Driver Name</b> : '+response.message.driver+'</div>\
                                <div class="col-3"><b>Driver Contact</b> : '+response.message.driver_phone+'</div>\
                            </div>\
                        </div>\
                        <div class="mt-3" style="border: 1px solid #00000059;padding:5px">\
                            <h5>Container 1</h5>\
                            <div class="row">\
                                <div class="col-3"><b>Container No.</b> : '+response.message.container_no[0]+'</div>\
                                <div class="col-3"><b>Size</b> : '+response.message.size[0]+'</div>\
                                <div class="col-3"><b>Type</b> : '+response.message.type[0]+'</div>\
                                <div class="col-3"><b>Status</b> : '+response.message.sstatus[0]+'</div>\
                                <div class="col-3"><b>Max Gross WT.</b> : '+response.message.gross[0]+'</div>\
                                <div class="col-3"><b>Tare WT.</b> : '+response.message.tare[0]+'</div>\
                                <div class="col-3"><b>MFG Date</b> : '+response.message.mfg[0]+'</div>\
                                <div class="col-3"><b>CSC Date</b> : '+response.message.csc[0]+'</div>\
                                <div class="col-3"><b>PAYLOAD</b> : '+response.message.payload[0]+'</div>\
                                <div class="col-3"><b>IMPORT DO No.</b> : '+response.message.import[0]+'</div>\
                                <div class="col-3"><b>Grade</b> : '+response.message.grade[0]+'</div>\
                                <div class="col-12"><b>Container In Remark</b> : '+response.message.container_remark[0]+'</div>\
                            </div>\
                        </div>';
                        if(response.message.container_no[1] !== null){
                            html +='<div class="mt-3" style="border: 1px solid #00000059;padding:5px">\
                                        <h5>Container 2</h5>\
                                        <div class="row">\
                                        <div class="col-3"><b>Container No.</b> : '+response.message.container_no[1]+'</div>\
                                        <div class="col-3"><b>Size</b> : '+response.message.size[1]+'</div>\
                                        <div class="col-3"><b>Type</b> : '+response.message.type[1]+'</div>\
                                        <div class="col-3"><b>Status</b> : '+response.message.sstatus[1]+'</div>\
                                        <div class="col-3"><b>Max Gross WT.</b> : '+response.message.gross[1]+'</div>\
                                        <div class="col-3"><b>Tare WT.</b> : '+response.message.tare[1]+'</div>\
                                        <div class="col-3"><b>MFG Date</b> : '+response.message.mfg[1]+'</div>\
                                        <div class="col-3"><b>CSC Date</b> : '+response.message.csc[1]+'</div>\
                                        <div class="col-3"><b>PAYLOAD</b> : '+response.message.payload[1]+'</div>\
                                        <div class="col-3"><b>IMPORT DO No.</b> : '+response.message.import[1]+'</div>\
                                        <div class="col-3"><b>Grade</b> : '+response.message.grade[1]+'</div>\
                                        <div class="col-12"><b>Container In Remark</b> : '+response.message.container_remark[1]+'</div>\
                                        </div>\
                                    </div>';
                        }
                        $('#model_body').html(html);
                        $('.modal').modal('show');
                    }
                }
            })
            
    })
    $('#container_save').click(function(){
        $('.modal').modal('hide');
        // swal({
        //     title: 'Are You Sure ?',
        //     icon: "war",
        //     button: 'Download',
        //   })
        //   .then((willDelete) => {
        //     if (willDelete) {
        //         window.open("/download-gate-pass-reciept/"+result.related, "_blank");
        //     }
        //   });
        $.ajax({
            type: "POST",
            url: '/'+$('#upload_url').val(),
            data: $('#container_form').serialize(),
            success: function (result) {
                console.log(result);
                if(result.error == 0){
                    $('input').val('');
                    $('select').val('');
                  console.log(result.related);
                  swal({
                    title: result.message[0],
                    text: "To Download The Gate Pass Click On Download",
                    icon: "success",
                    button: 'Download',
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                        window.open("/download-gate-pass-reciept/"+result.related, "_blank");
                        window.location.replace("/gate-pass");
                    }else{
                        window.location.replace("/gate-pass");
                    }
                  });
              }else{
                    console.log(result.error);
                  console.log(result.message);
                  swal("error", result.message[0], "error");
              }
            }
        })
    })
    //  End of gate pass in

    $('#container_form_other').submit(function(e){
        e.preventDefault();
        swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: '/'+$('#upload_url').val(),
                    data: $('#container_form_other').serialize(),
                    success: function (response) {
                        if(response.error == 0){
                              $('input').val('');
                              $('select').val('');
                              swal({
                                title: response.message[0],
                                icon: "success",
                                buttons: true,
                                dangerMode: true,
                              })
                        }else{
                            console.log(response.message);
                            swal("error", response.message[0], "error");
                        }
                    }
                });
            }
          });
    })


    $('#customCheck6').change(function() {
        if($('#customCheck6').is(':checked')){
            $('#consignee').val($('#vessel').val());
        }else{
            $('#consignee').val('');
        }
    });

    var currentDate = new Date();
      $('.disableFuturedate').datepicker({
      format: 'dd/mm/yyyy',
      autoclose:true,
      endDate: "currentDate",
      maxDate: currentDate
      }).on('changeDate', function (ev) {
         $(this).datepicker('hide');
      });
      $('.disableFuturedate').keyup(function () {
         if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9^-]/g, '');
         }
      });

    //   $('#container_register').click(function(){
    //       var start = $('#start_date').val();
    //         var end = $('#end_date').val();
    //         var shipping = $('#shipping').val();
    //         var status = $('#sstatus').val();
    //         $('.table').DataTable({
    //             "ajax":{
    //                 "url":"/container_register_fetch",
    //                 "dataSrc":""
    //             },
    //             "columns" : [
    //                 {"data" : "id"}
    //             ]
    //           })  
    //     })
    $('#multi_sheet_export').click(function(){
        var shipping = $('#shipping').val();
        var start = $('#start_date').val();
        var end = $('#end_date').val();
        if(shipping !== "" && start !== "" && end !== ""){
            $.ajax({
                type: "POST",
                url: "/multi-sheets",
                success: function (response) {
                    alert(response);
                }
            });
        }else{
            alert('please select all fields to get excel sheets');
        }
    })

    $('#store_total_tues').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
          if($('#store_total_tues').val() !== ""){
            $.ajax({
                type: "post",
                url: "/store-tues-value",
                data: {
                    tues:$('#store_total_tues').val()
                },
                success: function (response) {
                    alert(response);
                }
            });
          }else{
              alert('please fill the tues first');
          }
        }
      });
      $('#container_form').bind("keypress", function(e) {
        if (e.keyCode == 13) {               
          e.preventDefault();
          return false;
        }
      });

      $("#edi_report").click(function() {
        var postData = {};
        postData['content'] = {};
        postData['start_date'] = $("#start_date").val();
        postData['end_date'] = $("#start_date").val();
        postData['shipping'] = $("#shipping").val();
        postData['check_table'] = $("#check_table").val();
        var table = $("tbody");
        var i = 0;
        table.find('tr').each(function (i, el) {
            var $tds = $(this).find('td');
            postData['content'][i] = {};
            postData['content'][i]['container'] = $tds.eq(0).text();
            postData['content'][i]['status'] = $tds.eq(4).text();
            postData['content'][i]['transporter'] = $tds.eq(8).text();
            postData['content'][i]['location'] = $tds.eq(5).text();
            postData['content'][i]['port'] = $tds.eq(3).text();
            i++;
        });





        // postData['content'][0] = {};
        // postData['content'][0]['container'] = 1;
        // postData['content'][0]['status'] = 12;
        // postData['content'][0]['transporter'] = 13;
        // postData['content'][0]['location'] = 21;
        // postData['content'][0]['port'] = 41;
        
        $.post("/edi_report",{postData},function(res){
            download(res);
        });
        function download(filename) {
        var element = document.createElement('a');
        element.setAttribute('href','data:text/plain;charset=utf-8, '+ encodeURIComponent(filename));
        element.setAttribute('download', "edi_report.edi");
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
        }
    });
})
    
function someFunction(currentValue) {    
    console.log(currentValue);    
}    

        