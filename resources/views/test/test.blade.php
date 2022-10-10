<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="base_url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body class="antialiased">


    <div class="row mt-5">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form method="post" action="{{ url('/addimg') }}" enctype="multipart/form-data">
                @csrf
                <small class="err-msg" style="color:red; font-weight:bold; opacity:0.5;"></small>
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="name" class="form-control" id="name"
                        aria-describedby="emailHelp">

                </div>
                <div class="form-group">
                    <label for="img">Image</label>
                    <input type="file" name="image_link" class="form-control" id="image">
                </div>

                <button type="button" class="btn btn-primary submit-btn">Submit</button>
                @isset($msg)
                    {{ $msg }}
                @endisset
            </form>

        </div>
        <div class="col-md-4"></div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>
    <script>
        $(document).on("click", ".submit-btn", function(e) {
            e.preventDefault()
            let formData = new FormData();
            let img = $('#image')[0].files;
            let name = $('#name').val();
            if (img.length > 0) {
                formData.append("image", img[0]);
                formData.append("name", name);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/addimg') }}",
                    type: "post",
                    cache: false,
                    async: true,
                    encType: 'multipart/form-data',
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(res) {
                        console.log(res);
                    },
                });

            } else {
                $(".err-msg").text("select an image");
            }
        });
    </script>
</body>

</html>
