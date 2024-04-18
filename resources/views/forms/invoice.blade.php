<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Invoice</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin.css') }}">
    <style>
        .logo {
            width: 250px;
            height: 120px;
        }

        .sections {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        strong {
            margin-right: 10px;
            position: relative;
        }

        strong+div {
            /* margin-top: 10px; */
            flex-grow: 1;
            border-bottom: 1px solid black;
        }

        /*  */

        @media print {
            .print-button {
                display: none;
            }

            .container {
                width: 100% !important;
                padding: 0 !important;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid" style="margin-bottom: 100px;">

        <div class="print-button  float-end">
            <button class="btn btn-warning text-white my-2" onclick="window.print()">Print</button>
        </div>

        <div class="row">
            <div class="col-12 border-bottom border-dark">
                <h1 class="text-center" style="letter-spacing: 4px;">OTTOMAN TOWER</h1>
            </div>
            <div class="col text-center">
                <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="">
            </div>
        </div>
        @foreach($applications as $ap)
        <div class="row g-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-7 sections">
                        <strong for="">Receipt #</strong>
                        <div>{{ $ap->id }}</div>
                    </div>
                    <div class="col-5 sections">
                        <strong for="">CC No .</strong>
                        <div>{{ $ap->customer->id }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 sections">
                        <strong for="">Received with thanks from Mr/Ms/Miss .</strong>
                        <div>{{ $ap->customer->name }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 sections">
                        <strong for="">Sum of Rupees :</strong>
                        <div>{{ $ap->total_amount }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-8 sections">
                        <strong for="">Cash / Cheque / Pay order Bank draft no.</strong>
                        <div>{{ $ap->bank_branch }}</div>
                    </div>
                    <div class="col-4 sections">
                        <strong for="">Date</strong>
                        <div>{{ $ap->date }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-6 sections">
                        <strong for="">Drawn on Bank</strong>
                        <div></div>
                    </div>
                    <div class="col-6 sections">
                        <strong for="">On Account Of:</strong>
                        <div>Flat Booking</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-3 sections">
                        <strong for="">Flat #</strong>
                        <div>{{ $ap->flate->room_number.$ap->flate->floor_number }}</div>
                    </div>
                    <div class="col-3 sections">
                        <strong for="">Size</strong>
                        <div>{{ $ap->flate->flate_size }}X{{ $ap->flate->flate_size }}</div>
                    </div>
                    <div class="col-2 sections">
                        <strong for="">Type</strong>
                        <div></div>
                    </div>
                    <div class="col-2 sections">
                        <strong for="">Block</strong>
                        <div>{{ $ap->flate->room_number }}</div>
                    </div>
                    <div class="col-2 sections">
                        <strong for="">Category</strong>
                        <div></div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5 ps-4">
                <div class="row">
                    <div class="col-3 sections">
                        <strong for=""><i>Rs</i> .</strong>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <br>
        <br>
        <br>
        <div class="row g-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-7 sections">
                        <strong for="">Receipt #</strong>
                        <div>{{ $ap->id }}</div>
                    </div>
                    <div class="col-5 sections">
                        <strong for="">CC No .</strong>
                        <div>{{ $ap->id }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 sections">
                        <strong for="">Received with thanks from Mr/Ms/Miss .</strong>
                        <div>{{ $ap->customer->name }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 sections">
                        <strong for="">Sum of Rupees :</strong>
                        <div>{{ $ap->total_amount }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-8 sections">
                        <strong for="">Cash / Cheque / Pay order Bank draft no.</strong>
                        <div>{{ $ap->bank_branch }}</div>
                    </div>
                    <div class="col-4 sections">
                        <strong for="">Date</strong>
                        <div>{{ $ap->date }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-6 sections">
                        <strong for="">Drawn on Bank</strong>
                        <div></div>
                    </div>
                    <div class="col-6 sections">
                        <strong for="">On Account Of:</strong>
                        <div>Flat Booking</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-3 sections">
                        <strong for="">Flat #</strong>
                        <div>{{ $ap->flate->room_number.$ap->flate->floor_number }}</div>
                    </div>
                    <div class="col-3 sections">
                        <strong for="">Size</strong>
                        <div>{{ $ap->flate->flate_size }}X{{ $ap->flate->flate_size }}</div>
                    </div>
                    <div class="col-2 sections">
                        <strong for="">Type</strong>
                        <div></div>
                    </div>
                    <div class="col-2 sections">
                        <strong for="">Block</strong>
                        <div>{{ $ap->flate->room_number }}</div>
                    </div>
                    <div class="col-2 sections">
                        <strong for="">Category</strong>
                        <div></div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5 ps-4">
                <div class="row">
                    <div class="col-3 sections">
                        <strong for=""><i>Rs</i> .</strong>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <br>
        <br>
        <br>
        <div class="row g-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-7 sections">
                        <strong for="">Receipt #</strong>
                        <div>{{ $ap->id }}</div>
                    </div>
                    <div class="col-5 sections">
                        <strong for="">CC No .</strong>
                        <div>{{ $ap->id }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 sections">
                        <strong for="">Received with thanks from Mr/Ms/Miss .</strong>
                        <div>{{ $ap->customer->name }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 sections">
                        <strong for="">Sum of Rupees :</strong>
                        <div>{{ $ap->total_amount }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-8 sections">
                        <strong for="">Cash / Cheque / Pay order Bank draft no.</strong>
                        <div>{{ $ap->bank_branch }}</div>
                    </div>
                    <div class="col-4 sections">
                        <strong for="">Date</strong>
                        <div>{{ $ap->date }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-6 sections">
                        <strong for="">Drawn on Bank</strong>
                        <div></div>
                    </div>
                    <div class="col-6 sections">
                        <strong for="">On Account Of:</strong>
                        <div>Flat Booking</div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-3 sections">
                        <strong for="">Flat #</strong>
                        <div>{{ $ap->flate->room_number.$ap->flate->floor_number }}</div>
                    </div>
                    <div class="col-3 sections">
                        <strong for="">Size</strong>
                        <div>{{ $ap->flate->flate_size }}X{{ $ap->flate->flate_size }}</div>
                    </div>
                    <div class="col-2 sections">
                        <strong for="">Type</strong>
                        <div></div>
                    </div>
                    <div class="col-2 sections">
                        <strong for="">Block</strong>
                        <div>{{ $ap->flate->room_number }}</div>
                    </div>
                    <div class="col-2 sections">
                        <strong for="">Category</strong>
                        <div></div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5 ps-4">
                <div class="row">
                    <div class="col-3 sections">
                        <strong for=""><i>Rs</i> .</strong>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
