@extends('layouts/main')



@section('content')



    <div class="row main-row" style="margin: 0;">
        <div class="col-12 col-md-12 col-sm-12 col-xs-12" 
            style="height: 400px;">
            <img src="{{ asset('images/students.jpg') }}" 
            alt="students" class="std-img">
        </div>

        <div class="col-12 col-md-12  col-sm-12 col-xs-12">
            <table class="table" style="margin-top: 0px; ">

                <thead class="thead-light">

                    <tr>
                        <th scope="col">index</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Desc</th>
                        <th scope="col"> </th>
                        <th scope="col"> <button type="button" class="add-btn create-btn"
                                data-toggle="modal">Add</button></th>
                    </tr>
                </thead>
                <tbody class="table_body">


                    @foreach ($students as $student)
                        <tr>
                            <th scope="row">{{ $student->index_num }}</th>
                            <td>{{ $student->first_name }}</td>
                            <td>{{ $student->last_name }}</td>
                            <td>{{ $student->age }}</td>
                            <td>{{ $student->description }}</td>
                            <td>
                                <button type="button" data-id="{{ $student->id }}" class="button-ed  edit-btn"><i
                                        class="bi bi-pencil-square"></i>
                                </button>
                            </td>

                            <td>
                                <button type="button" class="button-ed delete-btn" data-id="{{ $student->id }}"><i
                                        class="bi bi-trash3-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @include('layouts/modal')

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            datastore();

            dataEdit();

            dataDelete();

        });


        function datastore() {
            // create modal
            $(document).on('click', '.create-btn', function() {
                let content = getModalContent();
                modaltoggle(content);
            });
            // store
            $(document).on('click', '.save', function(e) {
                e.preventDefault();

                const form = $(this).closest('form');

                formData = form.serializeArray();

                formValues = setformdata(formData);

                let url = `${baseURL}/store`;
                let type = 'post';
                let data = {
                    index: formValues.index,
                    first: formValues.first,
                    last: formValues.last,
                    age: formValues.age,
                    description: formValues.desc,
                    _token: csrfToken
                };

                ajaxRequeststore(url, type, data, function(response) {
                    let msg = response.msg;
                    let student = response.student;
                    console.log(response);
                    console.log();

                    addAndClose(student);
                });

            });
        }

        function dataEdit() {
            // edit modal
            $(document).on('click', '.edit-btn', function() {
                let studentId = $(this).attr('data-id');
                let url = `${baseURL}/edit/${studentId}`;


                let payload = {
                    _token: csrfToken
                };
                ajaxRequestedit(url, "POST", payload, function(data) {

                    console.log(data);
                    let id = data.id;
                    let index = data.index_num;
                    let first = data.first_name;
                    let last = data.last_name;
                    let age = data.age;
                    let description = data.description;

                    let content = getModalContentupdate(id, index, first, last, age,
                        description);
                    modaltoggle(content);



                });

                $(this).addClass('delete-me');

            });

            // update
            $(document).on('click', '.update', function(e) {
                e.preventDefault();

                const form = $(this).closest('form');

                formData = form.serializeArray();

                let id = $(this).attr('data-id');

                formValues = setformdata(formData);

                let url = `${baseURL}/update`;
                let type = 'POST';
                let data = {
                    id: id,
                    index: formValues.index,
                    first: formValues.first,
                    last: formValues.last,
                    age: formValues.age,
                    description: formValues.desc,
                    _token: csrfToken
                };
                ajaxRequeststore(url, type, data, function(response) {
                    let msg = response.msg;
                    let student = response.student;
                    console.log(msg);
                    addAndClose(student);
                });

                $('.delete-me').closest('tr').remove();


            });

        }

        function dataDelete() {
            // delete
            $(document).on('click', '.delete-btn', function() {
                content = ` <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    <img src="{{ asset('images/clear.png') }}" style="width:100px; " class="clear-img">
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-danger modal-delete">delete</button>
                                    </div>`;

                modaltoggle(content);
                let id = $(this).attr('data-id');
                $('.modal-delete').attr('data-id', id);
                $(this).addClass('delete-me');
            });

            $(document).on('click', '.modal-delete', function() {
                let id = $(this).attr('data-id');
                let url = `${baseURL}/delete/${id}`;
                let payload = {
                    _token: csrfToken
                };
                ajaxRequestedit(url, "POST", payload, function(response) {});
                $('.delete-me').closest('tr').remove();
                $('.close').click();
            });
        }


        // common

        function addAndClose(student) {
            $('.table_body').prepend(`
                                                    <tr>
                                                        <th scope="row">${student.index_num}</th>
                                                        <td>${student.first_name}</td>
                                                        <td>${student.last_name}</td>
                                                        <td>${student.age}</td>
                                                        <td>${student.description}</td>
                                                        <td>
                                                            <button type="button" data-id="${student.id}" 
                                                            class="button-ed  edit-btn"><i
                                                                    class="bi bi-pencil-square"></i>
                                                            </button>
                                                        </td>

                                                        <td>
                                                            <button type="button"  class="button-ed delete-btn"  
                                                            data-id="${student.id}"><i class="bi bi-trash3-fill"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                `);
            $('.close').click();
        }

        function setformdata(formData) {
            let index_number = formData[1].value;
            let first_name = formData[2].value;
            let last_name = formData[3].value;
            let age = formData[4].value;
            let description = formData[5].value;
            return {
                'index': index_number,
                'first': first_name,
                'last': last_name,
                'age': age,
                'desc': description,
            };
        }

        function modaltoggle(content) {
            $('#staticBackdrop').modal('toggle');
            $('.modal-content').html(content);
        }

        function ajaxRequeststore(url, type, data, cb) {
            $.ajax({
                url: url,
                type: type,
                data: data,
                success: function(data, status) {
                    console.log(data);
                    
                    cb(data);
                    
                },
                error:function(xhr, ajaxOptions, thrownError){
                    console.log("error-msg : ", xhr['responseJSON']['message']);

                    $('.err-msg').text( xhr['responseJSON']['message']);

                }

            });
        }

        function ajaxRequestedit(url, type, data, cb) {
            $.ajax({
                url: url,
                type: type,
                dataType: "json",
                data: data,
                success: function(data, status) {
                    cb(data);

                },
                error:function(xhr, ajaxOptions, thrownError){
                    console.log("error-msg : ", xhr['responseJSON']['message']);

                    $('.err-msg').text( xhr['responseJSON']['message']);

                }

            });
        }

        function getModalContentupdate(id, index, first, last, age, description) {


            return `
                
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Index</label>
                            <input type="text" class="form-control" name="index" placeholder="Index Num" value="${index}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name</label>
                            <input type="text" class="form-control" name="first" placeholder="First Name" value="${first}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Last Name</label>
                            <input type="text" class="form-control" name="last" placeholder="Last Name" value="${last}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Age</label>
                            <input type="Number" class="form-control" name="age" placeholder="Age" value="${age}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <input type="text" class="form-control" name="description" placeholder="Description" value="${description}">
                        </div>
                </div>
                
                <small class="err-msg" style="color:red; margin-left:1em; font-weight:bold; opacity:0.5;"></small>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary update" data-id="${id}">Save</button>
                </div>
            </form>

            `;



        }

        function getModalContent() {
            return `
                
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="store_form">
                <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Index</label>
                            <input type="text" class="form-control" id="index" name="index"  placeholder="Index Num">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name</label>
                            <input type="text" class="form-control" id="first" name="first" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Last Name</label>
                            <input type="text" class="form-control" id="last" name="last" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Age</label>
                            <input type="Number" class="form-control" id="age" name="age" placeholder="Age">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                        </div>
                       
                </div>
                
                        <small class="err-msg" style="color:red; margin-left:1em; font-weight:bold; opacity:0.5;"></small>
            

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save">Save</button>
                </div>
            </form>

            `;


        };

    </script>
@endsection
