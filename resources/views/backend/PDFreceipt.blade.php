<html>

<head>
    <title>
        Receipt_{{ $payment_record->ref_no . '_' . $student_record->surname . ' ' . $student_record->middlename . ' ' . $student_record->lastname }}
    </title>
    <link rel="stylesheet" type="text/css" href="{{ public_path('backend/dist/css/print.css') }}" />

    {{-- <link rel="stylesheet" type="text/css" href="{{ public_path('assets/css/receipt.css') }}" /> --}}
</head>

<body>
    <div class="container">
        <div id="print" xmlns:margin-top="http://www.w3.org/1999/xhtml">
            {{--  School Details --}}
            <table width="100%">
                <tr>

                    <td>
                        <strong><span
                                style="color: #1b0c80; font-size: 25px;">{{ strtoupper($appSettings->name) }}</span></strong><br />
                        <strong><span
                                style="color: #000; font-size: 15px;"><i>{{ ucwords($appSettings->address) }}</i></span></strong>
                        <br /> <br />

                        <span style="color: #000; font-weight: bold; font-size: 25px;"> PAYMENT RECEIPT</span>
                    </td>
                </tr>
            </table>

            {{-- Background Logo --}}
            <div style="position: relative;  text-align: center; ">
                <img src="{{ public_path($appSettings->logo) }}"
                    style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.1; margin-left: auto;margin-right: auto; left: 0; right: 0;" />
            </div>

            {{-- Receipt No --}}
            <div class="bold arial"
                style="text-align: center; float:right; width: 200px; padding: 5px; margin-right:30px">
                <div style="padding: 10px 20px; width: 200px; background-color: lightcyan;">
                    <span style="font-size: 16px;">Receipt Reference No.</span>
                </div>
                <div style="padding: 10px 20px; width: 200px; background-color: lightyellow;">
                    <span style="font-size: 25px;">{{ $payment_record->ref_no }}</span>
                </div>
            </div>

            <div style="clear: both"></div>

            {{-- Student Info --}}
            <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
                <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">STUDENT
                    INFORMATION</span>
            </div>

            {{-- Photo --}}
            <div style="margin: 15px;">
                <img style="width: 100px; height: 100px; float: left;"
                    src="{{ public_path($student_record->photo) }}"
                    alt="...">
            </div>

            <div style="float: left; margin-left: 20px">
                <table style="font-size: 16px" class="td-left" cellspacing="5" cellpadding="5">
                    <tr>
                        <td class="bold">NAME:</td>
                        <td>{{ $student_record->surname . ' ' . $student_record->middlename . ' ' . $student_record->lastname }}
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">ADM_NO:</td>
                        <td>{{ $student_record->admno }}</td>
                    </tr>
                    <tr>
                        <td class="bold">CLASS:</td>
                        <td>{{ $student_record->class->name }}</td>
                    </tr>
                </table>
            </div>
            <div class="clear"></div>

            {{-- Payment Info --}}
            <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
                <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">PAYMENT
                    INFORMATION</span>
            </div>

            <table class="td-left" style="font-size: 16px" cellspacing="2" cellpadding="2">
                <tr>
                    <td class="bold">REFERENCE:</td>
                    <td>{{ $payment->ref_no }}</td>
                    <td class="bold">TITLE:</td>
                    <td>{{ $payment->title }}</td>
                </tr>
                <tr>
                    <td class="bold">AMOUNT:</td>
                    <td>{{ $payment->amount }}</td>
                    <td class="bold">DESCRIPTION:</td>
                    <td>{{ $payment->description }}</td>
                </tr>
            </table>

            {{-- Payment Desc --}}
            <div style="margin-top:5px; display: block; background-color: rgba(92, 172, 237, 0.12); padding: 5px; ">
                <span style="font-weight:bold; font-size: 20px; color: #000; padding-left: 10px">DESCRIPTION</span>
            </div>

            <table class="td-left" style="font-size: 16px" width="100%" cellspacing="2" cellpadding="2">
                <thead>
                    <tr>
                        <td class="bold">Date</td>
                        <td class="bold">Amount Paid <del style="text-decoration-style: double">N</del></td>
                        <td class="bold">Balance <del style="text-decoration-style: double">N</del></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receipts as $receipt)
                        <tr>
                            <td>{{ date('D\, j F\, Y', strtotime($receipt->created_at)) }}</td>
                            <td>{{ $receipt->amount_paid }}</td>
                            <td>{{ $receipt->balance }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>
            <div class="bold arial"
                style="text-align: center; float:right; width: 200px; padding: 5px; margin-right:30px">
                <div style="padding: 10px 20px; width: 200px; background-color: lightcyan;">
                    <span style="font-size: 16px;">{{ $payment_record->paid ? 'PAYMENT STATUS' : 'TOTAL DUE' }}</span>
                </div>
                <div style="padding: 10px 20px; width: 200px; background-color: lightyellow;">
                    <span
                        style="font-size: 25px;">{{ $payment_record->paid ? 'CLEARED' : $payment_record->balance }}</span>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>