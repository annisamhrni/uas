<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <title>CRUD API Data Pasien</title>
    </head>
    <body>
        <?php
        include '../../views/layout/header.php';
        ?>
        <div class="container">
            <div id="message">
            </div>
            <h1 class="mt-4 mb-4 text-center text-danger">Data Pasien CRUD</h1>
            <span id="message"></span>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-sm-9">Data Pasien</div>
                        <div class="col col-sm-3">
                            <button type="button" id="add_data" class="btn btn-success btn-sm float-end">Add</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="sample_data">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Kontak</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" id="action_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="sample_form">
                        <div class="modal-header">
                            <h5 class="modal-texttitle" id="dynamic_modal_title"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" />
                                <span id="name_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" id="tgl_lahir" min="1945-01-01" max="" class="form-control" />
                                <span id="tgl_lahir_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <!-- <label class="form-label">Jenis Kelamin</label>
                                <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" />
                                <span id="jenis_kelamin_error" class="text-danger"></span> -->
                                <select name="jenis_kelamin" id="jenis_kelamin">
                                    <option value=""hidden></option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control" />
                                <span id="alamat_error" class="text-danger"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kontak</label>
                                <input type="number" name="kontak" id="kontak" class="form-control" />
                                <span id="kontak_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="id" />
                            <input type="hidden" name="action" id="action" value="Add" />
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="action_button">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function() {
            showAll();
            $('#add_data').click(function(){

                $('#dynamic_modal_title').text('Add Data');

                $('#sample_form')[0].reset();

                $('#action').val('Add');

                $('#action_button').text('Add');

                $('.text-danger').text('');

                $('#action_modal').modal('show');

            });

            $('#sample_form').on('submit', function(event){

                event.preventDefault();
                
                if($('#action').val() == "Add"){
                    var formData = {
                        'name'          : $('#name').val(),
                        'tgl_lahir'         : $('#tgl_lahir').val(),
                        'jenis_kelamin'   : $('#jenis_kelamin').val(),
                        'alamat'           : $('#alamat').val(),
                        'kontak'           : $('#kontak').val(),
                    }
                    $.ajax({
                        url:"http://localhost/uas/api/pasien/create.php",
                        method:"POST",
                        data: JSON.stringify(formData),
                        success:function(data){
                            $('#action_button').attr('disabled', false);
                            $('#message').html('<div class="alert alert-success">'+data.message+'</div>');
                            $('#action_modal').modal('hide');
                            $('#sample_data').DataTable().destroy();
                            showAll();
                        },
                        error: function(err) {
                            console.log(err);
                    }
                });
                }else if($('#action').val() == "Update"){
                    var formData = {
                        'id'                : $('#id').val(),
                        'name'              : $('#name').val(),
                        'tgl_lahir'         : $('#tgl_lahir').val(),
                        'jenis_kelamin'     : $('#jenis_kelamin').val(),
                        'alamat'            : $('#alamat').val(),
                        'kontak'            : $('#kontak').val(),
                    }
                    $.ajax({
                        url:"http://localhost/uas/api/pasien/update.php",
                        method:"PUT",
                        data: JSON.stringify(formData),
                        success:function(data){
                            $('#action_button').attr('disabled', false);
                            $('#message').html('<div class="alert alert-success">'+data.message+'</div>');
                            $('#action_modal').modal('hide');
                            $('#sample_data').DataTable().destroy();
                            showAll();
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }
                
            });
        });

        function showAll() {
            $.ajax({
                    type: "GET",
                    contentType: "application/json",
                    url: "http://localhost/uas/api/pasien/read.php",
                    success: function(response) { 
                        // console.log(response);
                        var json = response.body;
                        
                        var dataSet=[];
                        for (var i = 0; i < json.length; i++) {
                            var sub_array = {
                                'name' : json[i].name,
                                'tgl_lahir' : json[i].tgl_lahir,
                                'jenis_kelamin' : json[i].jenis_kelamin,
                                'alamat' : json[i].alamat,
                                'kontak' : json[i].kontak,
                                'action' : '<button onclick="showOne('+json[i].id+')" class="btn btn-sm btn-warning">Edit</button>'+
                                            '<button onclick="deleteOne('+json[i].id+')" class="btn btn-sm btn-danger">Delete</button>'  
                            };
                            dataSet.push(sub_array);
                        }
                        $('#sample_data').DataTable({
                            data: dataSet,
                            columns : [
                                { data : "name" },
                                { data : "tgl_lahir" },
                                { data : "alamat" },
                                { data : "jenis_kelamin" },
                                { data : "kontak" },
                                { data : "action" }
                            ]
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
            });
        } 
        function showOne(id) {
            $('#dynamic_modal_title').text('Edit Data');

            $('#sample_form')[0].reset();

            $('#action').val('Update');

            $('#action_button').text('Update');

            $('.text-danger').text('');

            $('#action_modal').modal('show');

            $.ajax({
                    type: "GET",
                    contentType: "application/json",
                    url: "http://localhost/uas/api/pasien/read.php?id="+id,
                    success: function(response) { 
                        $('#id').val(response.id);
                        $('#name').val(response.name);
                        $('#tgl_lahir').val(response.tgl_lahir);
                        $('#jenis_kelamin').val(response.jenis_kelamin);
                        $('#alamat').val(response.alamat);
                        $('#kontak').val(response.kontak);
                        
                    },
                    error: function(err) {
                        console.log(err);
                    }
            });


        }
        function deleteOne(id) {
            alert('Yakin untuk hapus data ?');
            $.ajax({
                url:"http://localhost/uas/api/pasien/delete.php",
                method:"DELETE",
                data: JSON.stringify({"id" : id}),
                success:function(data){
                    $('#action_button').attr('disabled', false);
                    $('#message').html('<div class="alert alert-success">'+data+'</div>');
                    $('#action_modal').modal('hide');
                    $('#sample_data').DataTable().destroy();
                    showAll();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>
    </body>
</html>
