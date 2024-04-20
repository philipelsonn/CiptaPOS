<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        .columnformats{
            text-align: left !important;
            padding-left: 2vw !important;
        }

    </style>
</head>
<body class="d-flex flex-column min-vh-100 bg-light bg-opacity-25">
    @yield('content')
    <script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable thead th').addClass('columnformats');
            $('#myTable').DataTable({
                columnDefs: [
                    {className: "columnformats", targets: "_all"},
                    {orderable: false, targets: -1 }
                ]
            });

            $('#transactionTable thead th').addClass('columnformats');
            $('#transactionTable').DataTable({
                columnDefs: [
                    {className: "columnformats", targets: "_all"},
                    {orderable: false, targets: -1 }
                ],
                "order": [[0, "desc"]]
            });

            var toastMessage = "{{ Session::get('toast_message') }}";
            if (toastMessage) {
                Toastify({
                    text: toastMessage,
                    duration: 3000,
                    backgroundColor: "linear-gradient(to right, #FF5733, #FFC300)",
                    close: true,
                    gravity: "top", 
                    position: "right"
                }).showToast();
            }
        } );
    </script>
</body>
</html>
