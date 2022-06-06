<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <title>Commission Calculator!</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Commission Calculator!</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="mt-3" enctype="multipart/form-data" action="{{route('commission-calculator.calculate')}}" method="post">
                    @csrf
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="customFile" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <button type="submit" role="button" id="calculate" class="btn btn-primary">Calculate</button>
                    @if(isset($transactions) && $transactions)
                    <div id="result" class="mt-3 border rounded p-2">
                        <table class="table table-bordered">
                            <tr>
                                <td>Transaction#</td>
                                <td>Date</td>
                                <td>User ID</td>
                                <td>User Type</td>
                                <td>Operation Type</td>
                                <td>Amount</td>
                                <td>Currency</td>
                                <td>Charge</td>
                            </tr>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{$transaction->transaction_id}}</td>
                                        <td>{{$transaction->operation_date->format('Y-m-d')}}</td>
                                        <td>{{$transaction->user_identification}}</td>
                                        <td>{{$transaction->user_type}}</td>
                                        <td>{{$transaction->operation_type}}</td>
                                        <td>{{$transaction->operation_amount}}</td>
                                        <td>{{$transaction->operation_currency}}</td>
                                        <td>{{$transaction->commission_amount}}</td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                    @endif
                </form>
            </div>
        </div>

    </div>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>
