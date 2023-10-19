@extends('welcome')
@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-4 offset-4">
                <div class="mt-2  msg"></div>
                <form id="data">
                    <div class="form-group">
                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" name="country" id="country">
                                    <option selected> :: Country ::</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" name="state" id="state">
                                    <option selected> :: State ::</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" name="city" id="city">
                                    <option selected> :: City ::</option>
                                </select>
                            </div>
                            <input type="hidden" class="form-control" name="add_data" id="hidden_data" value="add_data">
                            <input type="hidden" class="form-control" name="user_id" id="user_id" value="">

                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-success " type="submit" id="form_data">Add</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="container data_table">
        <div class="row">
            <div class="col- offset-2">
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Sno</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table_body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            if ($('.msg').val() != null) {
                setInterval(() => {
                    $('.msg').text(null);
                }, 1000);
            }

            fetch_country_data();
            show_data();

            function fetch_country_data() {
                $.ajax({
                    type: "GET",
                    url: "{{ asset('country_data') }}",
                    dataType: "json",
                    success: function(response) {
                        var newdata = JSON.parse(response.data);
                        newdata.forEach(element => {
                            $('#country').append(
                                '<option value="' + element.id +
                                '" class="country_value"data-name="' +element.country_name + '">' +element.country_name +
                                '</option>'
                            );
                        });
                    },
                    error: function() {
                        console.log('sldf');
                    }
                });
            }

            $('#country').on('change', function(e) {
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "country_id/" + id,
                    success: function(response) {
                        $('#state').html('');
                        $('#state').append(
                            '<option selected> ::Select State::</option>'
                        );
                        response.states.forEach(state => {
                            // console.log(state.state_name);

                            $('#state').append(
                                '<option value="' + state.id +
                                '" class="state_value"data-name="' + state
                                .state_name + '">' + state.state_name +
                                '</option>'
                            );
                        });
                    },
                    error: function(err) {
                        console.log(err.response);
                    }
                });
            });

            $('#state').on('change', function(e) {
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "state_id/" + id,
                    success: function(response) {
                        $('#city').html('');
                        $('#city').append(
                            '<option selected> ::Select City::</option>'
                        );
                        response.cities.forEach(city => {
                            $('#city').append(
                                '<option value="' + city.id +
                                '" class="city_value" data-name="' + city
                                .city_name + '"> ' + city.city_name +
                                ' </option> '
                            );
                        });
                    }
                });
            });

            $("#data").submit(function(e) {
                e.preventDefault();
                var countries = $('.country_value').data("name");
                // console.log(countries); yahn pai issue hora is waja sai country change ni hora hai 
                // return 0; mainai try kiya pr samjh ni ara hai
                var state = $('.state_value').data("name");
                
                var city = $('.city_value').data("name");
                var data = $('#data').serialize() + "&country_name=" + country + "&state_name=" + state +
                    "&city_name=" + city;
                $.ajax({
                    type: "POST",
                    url: "form_data",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('.form-control').val(null);
                        $('#form_data').text("Add");
                        $('#hidden_data').val("add_data");
                        $('#country').append(
                            '<option selected> ::Select Country::</option>'
                        );
                        $('#state').append(
                            '<option selected> ::Select State::</option>'
                        );
                        $('#city').append(
                            '<option selected> ::Select City::</option>'
                        );
                        console.log(response.msg);
                        $('.table_body').empty();
                        $('.msg').text(response.msg);
                        show_data();
                    }
                });
            });

            function show_data() {
                var count = 0;
                $.ajax({
                    type: "GET",
                    url: "show_data",
                    success: function(response) {

                        response.data.forEach(element => {
                            count++;
                            $('.table_body').append(
                                '<tr>\
                                                            <td>' + count + '</td>\
                                                            <td>' + element.fullname + '</td>\
                                                            <td>' + element.email + '</td>\
                                                            <td>' + element.password + '</td>\
                                                            <td>' + element.country_name + '</td>\
                                                            <td>' + element.state_name + '</td>\
                                                            <td>' + element.city_name + '</td>\
                                                            <td> <button class="btn btn-warning btn-sm update" data-id="' +
                                element
                                .id +
                                '" data-name="' + element.fullname + '">Update</button> </td>\
                                                            <td> <button class="btn btn-danger btn-sm delete" data-id="' +
                                element
                                .id +
                                '" data-name="' + element.fullname + '">Delete</button> </td>\
                                                        </tr>'
                            );
                        });

                    }
                });
            }
            $('.table_body').on('click', '.delete', function() {
                var name = $(this).data('name');
                var id = $(this).data('id');
                var confirmation = confirm("Are You Sure You Want To Delete " + name);
                if (confirmation) {
                    $.ajax({
                        type: "GET",
                        url: "delete/" + id,
                        success: function(response) {
                            $('tbody').empty();
                            show_data();
                            $('.msg').text(response.msg);
                        }
                    });
                }
            });
            $('tbody').on('click', '.update', function() {
                var name = $(this).data('name');
                var id = $(this).data('id');
                var confirmation = confirm("Are You Sure You Want To Update " + name);
                if (confirmation) {
                    $.ajax({
                        type: "get",
                        url: "update/" + id,
                        success: function(response) {
                            $('.msg').text(null);
                            $('.data_table').empty();
                            $('#hidden_data').val("update_form");
                            $('#form_data').text("Update");
                            $('#user_id').val(response.id);
                            $('#fullname').val(response.fullname);
                            $('#email').val(response.email);
                            $('#password').val(response.password);
                            // $('#country').append(
                            //     '<option selected class="update_country" value="' + response
                            //     .country + '" data-country="' + response.country_name +
                            //     '">' + response.country_name + '</option>'
                            // );
                            // $('#state').append(
                            //     '<option selected class="update_state" value="' + response
                            //     .state + '" data-state="' + response.country_state + '">' +
                            //     response.state_name + '</option>'

                            // );
                            // $('#city').append(
                            //     '<option selected class="update_city" value="' + response
                            //     .city + '" data-city="' + response.country_city + '">' +
                            //     response.city_name + '</option>'

                            // );
                        }
                    });
                }
            });
        });
    </script>
@endsection
