<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Congratulations! Your Order #{{$mailData->order_id}} Has Been Completed! ✅</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&family=Raleway:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        p {
            font-family: "Montserrat", sans-serif;
            font-size: 16px;
            line-height: 1.5;
        }
        b {
            font-weight: 600;
        }
        h1 {
            font-family: "Montserrat", sans-serif;
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e3e3e3;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Congratulations! Your Order #{{$mailData->order_id}} Has Been Completed! ✅</h1>
        <p>
            <div style="border-bottom: 1px solid #e3e3e3; padding-bottom:10px; margin-bottom:10px; border-top: 1px solid #e3e3e3; padding-top:10px; margin-top:10px">Order ID: <span style="float: right">#{{$mailData->order_id}}</span></div>
            @if ($mailData->input_value)
            <div style="border-bottom: 1px solid #e3e3e3; padding-bottom:10px; margin-bottom:10px">{{$mailData->input_name}}: <span style="float: right">{{$mailData->input_value}}</span></div>
            @endif
            <div style="border-bottom: 1px solid #e3e3e3; padding-bottom:10px; margin-bottom:10px">Amount: <span style="float: right">{{$mailData->service_price}}</span></div>
            <div style="border-bottom: 1px solid #e3e3e3; padding-bottom:10px; margin-bottom:10px">Order Status: <span style="float: right">{{$mailData->order_status}}</span></div>
        </p>
        <p>{{$mailData->service_comments}}</p>
    </div>

    <div class="footer">
        <p><a href="{{route('customer_order_history')}}">Order History</a> | <a href="{{route('customer_dashboard')}}">My Dashboard</a> | <a href="{{route('customer_statement')}}">My Statement</a></p>
        <p>&copy; 2025 {{$siteTitle}}. All Rights Reserved.</p>
    </div>
</body>
</html>
