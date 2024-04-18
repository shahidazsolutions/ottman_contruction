<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Invoice</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin.css') }}">
    <style>
        .logo{
            width: 250px;
            height: 120px;
        }
        table , tr,th,td{
            border: 1px solid black;
        }
        tfoot{
            border: none;
        }

        tfoot tr,td{
            border: none;
        }
        .footer div{
            border-top: 2px solid black;
            width: 25%;
            text-align: center;
        }
        .print-button {
            display: block;
            text-align: center;
            margin-bottom: 20px;
        }
        @media print {
            .print-button {
                display: none;
            }
            .container{
                width: 100%!important;
                padding: 0!important;
            }
        }
    </style>
</head>
<body>

    <div class="container" style="margin-bottom: 100px;">


        <div class="print-button  float-end">
            <button class="btn btn-warning text-white my-2" onclick="window.print()">Print</button>
        </div>
        <div class="row">
            <div class="col-12 border-bottom border-dark">
                <h1 class="text-center" style="letter-spacing: 4px;">OTTOMAN CONTRUCTION</h1>
            </div>
            <div class="col text-center">
                <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="">
            </div>
            @foreach ($payments as $payment)

            <div class="invoice-detail">
                <div class="my-3">

                    <span class="fw-bold">{{ $type }} : {{ $payment->id }}</span>
                </div>

                <table class="table">

                    <tbody>
                        <tr>
                            <th>Amount Paid  : {{ formatAmount($payment->amount) }}</th>
                            <th colspan="2">Date  : {{ $payment->date }}</th>


                        </tr>
                        <tr>
                            <th colspan="3" class="text-center">Method Of Payment</th>
                        </tr>

                        <tr>
                            <th  colspan="3">Made of Payment : {{ $type }}</th>
                        </tr>
                        <tr>
                            <th>To  : {{ Str::ucfirst(($type=='Contractor Invoice')?$payment->getContractor->name:$payment->getSupplier->name) }}</th>
                            <th colspan="2">CNIC  : {{ Str::ucfirst(($type=='Contractor Invoice')?$payment->getContractor->nic:$payment->getSupplier->nic) }}</th>


                        </tr>
                        <tr>
                            <th colspan="3" style="height: 150px;">Note : {{ $payment->description }}</th>
                        </tr>

                        <tr>
                            <th colspan="" style="height: 100px;">Approved By : </th>
                            <th colspan="" style="height: 100px;">
                                        Paid By :
                            </th>
                            <th colspan="" style="height: 100px;">
                                Signature :
                            </th>

                        </tr>
                    </tbody>

                </table>
                <div style="margin-top: 80px;" class="footer d-flex justify-content-between px-4">

                    <div class="reciever-name " >
                            <span>Reciever's Name</span>
                    </div>
                    <div class="reciever-signature">
                        <span>Reciever's Signature</span>

                    </div>


                </div>
            </div>

            <hr>
            <div class="invoice-detail">
                <div class="my-3">

                    <span class="fw-bold">{{ $type }} : {{ $payment->id }}</span>
                </div>

                <table class="table">

                    <tbody>
                        <tr>
                            <th>Amount Paid  : {{ formatAmount($payment->amount) }}</th>
                            <th colspan="2">Date  : {{ $payment->date }}</th>


                        </tr>
                        <tr>
                            <th colspan="3" class="text-center">Method Of Payment</th>
                        </tr>

                        <tr>
                            <th  colspan="3">Made of Payment : {{ $type }}</th>
                        </tr>
                        <tr>
                            <th>To  : {{ Str::ucfirst(($type=='Contractor Invoice')?$payment->getContractor->name:$payment->getSupplier->name) }}</th>
                            <th colspan="2">CNIC  : {{ Str::ucfirst(($type=='Contractor Invoice')?$payment->getContractor->nic:$payment->getSupplier->nic) }}</th>


                        </tr>
                        <tr>
                            <th colspan="3" style="height: 150px;">Note : {{ $payment->description }}</th>
                        </tr>

                        <tr>
                            <th colspan="" style="height: 100px;">Approved By : </th>
                            <th colspan="" style="height: 100px;">
                                        Paid By :
                            </th>
                            <th colspan="" style="height: 100px;">
                                Signature :
                            </th>

                        </tr>
                    </tbody>

                </table>
                <div style="margin-top: 80px;" class="footer d-flex justify-content-between px-4">

                    <div class="reciever-name " >
                            <span>Reciever's Name</span>
                    </div>
                    <div class="reciever-signature">
                        <span>Reciever's Signature</span>

                    </div>


                </div>
            </div>



            <hr>
            <div class="invoice-detail">
                <div class="my-3">

                    <span class="fw-bold">{{ $type }} : {{ $payment->id }}</span>
                </div>

                <table class="table">

                    <tbody>
                        <tr>
                            <th>Amount Paid  : {{ formatAmount($payment->amount) }}</th>
                            <th colspan="2">Date  : {{ $payment->date }}</th>


                        </tr>
                        <tr>
                            <th colspan="3" class="text-center">Method Of Payment</th>
                        </tr>

                        <tr>
                            <th  colspan="3">Made of Payment : {{ $type }}</th>
                        </tr>
                        <tr>
                            <th>To  : {{ Str::ucfirst(($type=='Contractor Invoice')?$payment->getContractor->name:$payment->getSupplier->name) }}</th>
                            <th colspan="2">CNIC  : {{ Str::ucfirst(($type=='Contractor Invoice')?$payment->getContractor->nic:$payment->getSupplier->nic) }}</th>


                        </tr>
                        <tr>
                            <th colspan="3" style="height: 150px;">Note : {{ $payment->description }}</th>
                        </tr>

                        <tr>
                            <th colspan="" style="height: 100px;">Approved By : </th>
                            <th colspan="" style="height: 100px;">
                                        Paid By :
                            </th>
                            <th colspan="" style="height: 100px;">
                                Signature :
                            </th>

                        </tr>
                    </tbody>

                </table>
                <div style="margin-top: 80px;" class="footer d-flex justify-content-between px-4">

                    <div class="reciever-name " >
                            <span>Reciever's Name</span>
                    </div>
                    <div class="reciever-signature">
                        <span>Reciever's Signature</span>

                    </div>


                </div>
            </div>
            @endforeach
        </div>
    </div>
<script>
    //  window.onafterprint = function() {
    //         var printButton = document.querySelector('.print-button');
    //         printButton.style.display = 'none';
    //     };
    window.print();
</script>
</body>
</html>
