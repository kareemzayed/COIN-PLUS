<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ __('Receipt Voucher') }} - {{ $receipt_voucher->customar_name }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ getFile('icon', $general->favicon, true) }}">
    <style>
        :root {
            --main-color: #000334;
            --sec-color: #cbceff;
        }

        * {
            margin: 0px;
            padding: 0px;
        }

        @media (max-width: 992px) {
            body {
                width: 100% !important;
                display: flex;
            }
        }

        body {
            width: 900px;
            position: absolute;
            left: 50%;
            text-align: center;
            transform: translate(-50%);
        }

        .no-print {
            width: 50%;
            margin: 0 auto;
            position: fixed;
            bottom: 50px;
            left: 25%;
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 12px;
        }

        .no-print:hover {
            background-color: #45a049;
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        .sanad-form {
            border: 3px solid #E3E3E3;
        }

        .sanad-form.customer-copy {
            margin-top: 50px;
            margin-bottom: 50px;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='120'><text x='20' y='120' font-family='Arial' font-size='18' fill='rgba(128, 128, 128, 0.5)' transform='rotate(-45 20,120)'>@lang("Customer Copy, Private Copy")</text></svg>");
            background-repeat: repeat;
        }

        .container {
            margin: auto 65px;
        }

        header {
            position: relative;
            display: flex;
            flex-direction: row-reverse;
        }

        header .sec-color {
            width: 90px;
            height: 25px;
            position: relative;
            border: 1px solid var(--sec-color);
            background: var(--sec-color);
            margin-left: 10px;
        }

        header .main-color {
            width: 350px;
            height: 25px;
            position: relative;
            border: 1px solid var(--main-color);
            background: var(--main-color);
        }

        .sanad .title {
            width: fit-content;
            margin: 40px auto;
            margin-left: 130px;
        }

        .sanad .content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .sanad .content .title h3 {
            font-size: 38px;
            margin-bottom: 0;
            margin-top: 80px;
            color: var(--main-color);
            text-transform: uppercase;
        }

        .sanad .content .title h4 {
            font-size: 20px;
            margin: 0;
            color: var(--main-color);
            text-transform: uppercase;
        }

        .sanad .content .title hr {
            width: 100%;
            height: 2px;
            border-color: var(--main-color);
            background: var(--main-color);
        }

        .sanad .content .forms {
            display: flex;
            margin-top: 85px;
            margin-left: -180px;
        }

        .sanad .content a {
            display: flex;
            margin-top: 85px;
            margin-left: 60px;
        }

        .sanad .content form {
            display: flex;
            flex-direction: column;
        }

        .sanad .content .sr {
            margin-left: -80px;
            margin-right: 50px;
        }

        .sanad .content .sr input[type='text'] {
            text-align: center;
        }

        .sanad .content input[type='text'] {
            padding: 6px 0px;
            border: 1px solid #BECBCB;
            background: #E8F7FE;
            outline: 0;
        }

        div .forms .w-80 {
            width: 80%;
        }

        div .forms .w-25 {
            width: 25%;
        }

        .date .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 50px;
            margin-top: 60px;
        }

        .date .container .milady p {
            font-size: 18px;
        }

        .date .container .number h3 {
            font-size: 30px;
            color: #92585f;
            font-weight: 800;
        }

        .date .container .higry p {
            font-size: 18px;
        }

        .forms .container {
            display: block;
        }

        .forms .container .form-1 {
            display: flex;
            align-items: center;
            flex-direction: row-reverse;
            justify-content: space-between;
            margin: 10px 0px;
        }

        .forms .container .form-1 form {
            display: flex;
        }

        .forms .container .form-1 form input[type='text'] {
            width: 502px;
            border: 0;
            border-bottom: 1px dotted #000800;
            outline: 0;
        }

        div .container .ar {
            text-align: center;
            font-size: 17px;
        }

        .forms .container .form-2 {
            display: flex;
            align-items: center;
            margin: 10px 0px;
            flex-direction: row-reverse;
            justify-content: space-between;
        }

        .forms .container .form-2 form {
            display: flex;
        }

        .forms .container .form-2 form input[type='text'] {
            width: 642px;
            border: 0;
            border-bottom: 1px dotted #000800;
            outline: 0;
        }

        .forms .container .form-3 {
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-direction: row-reverse;
            margin: 10px 0px;

        }

        .forms .container .form-3 form {
            display: flex;
        }

        .forms .container .form-3 form input[type='text'] {
            width: 232px;
            border: 0;
            border-bottom: 1px dotted #000800;
            outline: 0;
        }

        .forms .container .form-4 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: row-reverse;
            margin: 10px 0px;
        }

        .forms .container .form-4 form {
            display: flex;
        }

        .forms .container .form-4 form input[type='text'] {
            width: 658px;
            border: 0;
            border-bottom: 1px dotted #000800;
            outline: 0;
        }

        .forms .container .form-5 {
            display: flex;
            align-items: center;
            flex-direction: row-reverse;
            margin: 10px 0px;
        }

        .forms .container .form-5 form {
            display: flex;
        }

        .forms .container .form-5 form input[type='text'] {
            width: 762px;
            border: 0;
            border-bottom: 1px dotted #000800;
            outline: 0;
        }

        .forms .container .form-6 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: row-reverse;
            margin-top: 30px;
            margin: 10px 0px;
        }

        .forms .container .form-6 form {
            display: flex;
        }

        .forms .container .form-6 form input[type='text'] {
            width: 192px;
            border: 0;
            border-bottom: 1px dotted #000800;
            outline: 0;
        }

        footer .main-color {
            width: 100%;
            height: 25px;
            position: relative;
            border: 1px solid var(--main-color);
            background: var(--main-color);
            margin-top: 100px;
        }
    </style>
    <title>سند قبض</title>
</head>

<body>
    <div class="overflow">
        <div class="sanad-form customer-copy">
            <header>
                <div class="sec-color"></div>
                <div class="main-color"></div>
            </header>
            <div class="sanad">
                <div class="content">
                    <a>
                        <img src="{{ getFile('icon', $general->favicon_dr) }}" style="width: 150px;" />
                    </a>
                    <div class="title">
                        <h3>
                            ســـــند قبـــــض
                        </h3>
                        <h4>
                            receipt voucher
                        </h4>
                        <hr>
                    </div>
                    <div class="forms">
                        <form class="sr" action=""> {{ optional($receipt_voucher->currency)->code }}
                            <label for="money">
                                <input class="w-80" type="text"
                                    value="{{ number_format($receipt_voucher->amount, 2) }}">
                            </label>
                        </form>
                    </div>
                </div>
            </div>
            <div class="date">
                <div class="container">
                    <div class="milady">
                        <p>
                            الموافق {{ date(' d / m / Y ', strtotime($receipt_voucher->created_at)) }}م
                        </p>
                    </div>
                    <div class="number">
                        <h3>
                            {{ $receipt_voucher->receipt_num }}
                        </h3>
                    </div>
                    <div class="higry">
                        <p>
                            التاريخ &nbsp; &nbsp; / &nbsp; &nbsp; / &nbsp; &nbsp;14 هـ
                        </p>
                    </div>
                </div>
            </div>
            <div class="forms">
                <div class="container">
                    <div class="form-1">
                        <p>
                            :إستلمنا من السيد / السادة
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->customar_name }}">
                        </form>
                        <p>
                            Received From Mrs:
                        </p>
                    </div>
                    <div class="form-2">
                        <p>
                            :مبلغ و قدره
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->amount_in_words }}">
                        </form>
                        <p>
                            Amount:
                        </p>
                    </div>
                    <div class="form-3">
                        <p>
                            :نقداً / شيك رقم
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->check_no }}">
                        </form>
                        <p style="margin-left: 15px;">
                            Cash / Cheque No
                        </p>
                        <p>
                            على بنك
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->bank }}">
                        </form>
                        <p>
                            Bank:
                        </p>
                    </div>
                    <div class="form-4">
                        <p>
                            :وذلك مقابل
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->exchange_for }}">
                        </form>
                        <p>
                            Being:
                        </p>
                    </div>
                    <div class="form-5">
                        <form action="">
                            <input class="ar" type="text" name="" id="">
                        </form>
                    </div>
                    <div class="form-6">
                        <p>
                            :المحاسب
                        </p>
                        <form action="">
                            <input class="ar" type="text" name="" id="">
                        </form>
                        <p style="margin-left: 150px;">
                            Accountant
                        </p>
                        <p>
                            المستلم
                        </p>
                        <form action="">
                            <input class="ar" type="text" name="" id="">
                        </form>
                        <p>
                            Receiver:
                        </p>
                    </div>
                </div>
            </div>
            <footer>
                <div class="main-color"></div>
            </footer>
        </div>
        <div class="sanad-form">
            <header>
                <div class="sec-color"></div>
                <div class="main-color"></div>
            </header>
            <div class="sanad">
                <div class="content">
                    <a>
                        <img src="{{ getFile('icon', $general->favicon_dr) }}" style="width: 150px;" />
                    </a>
                    <div class="title">
                        <h3>
                            ســـــند قبـــــض
                        </h3>
                        <h4>
                            receipt voucher
                        </h4>
                        <hr>
                    </div>
                    <div class="forms">
                        <form class="sr" action=""> {{ optional($receipt_voucher->currency)->code }}
                            <label for="money">
                                <input class="w-80" type="text"
                                    value="{{ number_format($receipt_voucher->amount, 2) }}">
                            </label>
                        </form>
                    </div>
                </div>
            </div>
            <div class="date">
                <div class="container">
                    <div class="milady">
                        <p>
                            الموافق {{ date(' d / m / Y ', strtotime($receipt_voucher->created_at)) }}م
                        </p>
                    </div>
                    <div class="number">
                        <h3>
                            {{ $receipt_voucher->receipt_num }}
                        </h3>
                    </div>
                    <div class="higry">
                        <p>
                            التاريخ &nbsp; &nbsp; / &nbsp; &nbsp; / &nbsp; &nbsp;14 هـ
                        </p>
                    </div>
                </div>
            </div>
            <div class="forms">
                <div class="container">
                    <div class="form-1">
                        <p>
                            :إستلمنا من السيد / السادة
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->customar_name }}">
                        </form>
                        <p>
                            Received From Mrs:
                        </p>
                    </div>
                    <div class="form-2">
                        <p>
                            :مبلغ و قدره
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->amount_in_words }}">
                        </form>
                        <p>
                            Amount:
                        </p>
                    </div>
                    <div class="form-3">
                        <p>
                            :نقداً / شيك رقم
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->check_no }}">
                        </form>
                        <p style="margin-left: 15px;">
                            Cash / Cheque No
                        </p>
                        <p>
                            على بنك
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->bank }}">
                        </form>
                        <p>
                            Bank:
                        </p>
                    </div>
                    <div class="form-4">
                        <p>
                            :وذلك مقابل
                        </p>
                        <form action="">
                            <input class="ar" type="text" value="{{ $receipt_voucher->exchange_for }}">
                        </form>
                        <p>
                            Being:
                        </p>
                    </div>
                    <div class="form-5">
                        <form action="">
                            <input class="ar" type="text" name="" id="">
                        </form>
                    </div>
                    <div class="form-6">
                        <p>
                            :المحاسب
                        </p>
                        <form action="">
                            <input class="ar" type="text" name="" id="">
                        </form>
                        <p style="margin-left: 150px;">
                            Accountant
                        </p>
                        <p>
                            المستلم
                        </p>
                        <form action="">
                            <input class="ar" type="text" name="" id="">
                        </form>
                        <p>
                            Receiver:
                        </p>
                    </div>
                </div>
            </div>
            <footer>
                <div class="main-color"></div>
            </footer>
        </div>
    </div>
    <button class="no-print" onclick="printDocument()">@lang('Print')</button>
    <script>
        function printDocument() {
            window.print();
        }
    </script>
</body>

</html>
