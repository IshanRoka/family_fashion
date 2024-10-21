<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        :root {
            --main-color: #f2f4f7;
            --border-radius: 1rem;
            --padding-main: 0.8rem;
            --margin-main: 0 0 1rem 0;
            --paragraph-size: 1rem;
            --main-size: 1rem;
            --font-bold: 600;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            border: none;
            outline: none;
            list-style: none;
            text-decoration: none;
        }

        body {
            height: 100vh;
            width: 100vw;
            background-color: var(--main-color);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main {
            display: flex;
            flex-direction: column;
            width: 595px;
            min-height: 550px;
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
            border-radius: var(--border-radius);
        }

        .title {
            display: flex;
            justify-content: space-between;
            background-color: var(--main-color);
            align-items: center;
            padding: var(--padding-main);
            border-radius: var(--border-radius);
            margin: var(--margin-main);
        }

        p,
        span {
            font-size: var(--main-size);
            font-weight: var(--font-bold);
        }

        .toFrom {
            display: flex;
            justify-content: space-between;
            margin: var(--margin-main);
            border-radius: var(--border-radius);
        }

        .toFrom .to,
        .from {
            background: var(--main-color);
            padding: var(--padding-main);
            border-radius: var(--border-radius);
        }

        table {
            background-color: var(--main-color);
            padding: var(--padding-main);
            border-radius: var(--border-radius);
            margin: var(--margin-main);
        }

        .footer {
            background-color: var(--main-color);
            padding: var(--padding-main);
            border-radius: var(--border-radius);
            margin: var(--margin-main);
        }

        table th {
            border-bottom: 0.4rem solid white;
            padding: 1.5rem 0;
            text-align: center;
        }

        table td {
            text-align: center;
        }

        .subTotal,
        .tax,
        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 4rem;
            padding: var(--padding-main);
            background: var(--main-color);
            margin: var(--margin-main);
            border-radius: var(--border-radius);
        }

        .footer p {
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    @php
        $sn = 1;
        $total = 0;
    @endphp

    <div class="main">
        <div class="title">
            <div class="left">
                <p>Invoice :</p>
                <span>#AB2324-01</span>
            </div>
            <div class="right">
                <p>Date:</p>
                @if ($firstOrder)
                    <span>{{ \Carbon\Carbon::parse($firstOrder['created_at'])->format('d-m-Y H:i:s') }}</span>
                @endif
            </div>
        </div>
        <div class="toFrom">
            <div class="to">
                <p>To:</p>
                <span>Ishan Roka</span>
            </div>
            <div class="from">
                <p>From:</p>
                <span>Family Fashio</span>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderData as $order)
                    @php
                        $price = number_format($order['total_price'] / $order['qty'], 2);
                        $tax = $price * 0.13;
                    @endphp
                    <tr>
                        <td>{{ $sn++ }}</td>
                        <td>{{ $order['product_name'] }}</td>
                        <td>{{ $order['qty'] }}</td>
                        <td>Rs {{ $price }}</td>
                        <td>Rs {{ number_format($order['total_price'], 2) }}</td>
                    </tr>
                    @php
                        $total += $order['total_price'];
                        $subTotal = $total + $tax;
                    @endphp
                @endforeach
            </tbody>
        </table>


        <div class="subTotal">
            <p>Sub Total:</p>
            <span>Rs {{ number_format($total, 2) }}</span>
        </div>
        <div class="tax">
            <p>Tax(13%):</p>
            <span>Rs{{ $tax }}</span>
        </div>
        <div class="total">
            <p>Total Amount:</p>
            <span>Rs {{ $subTotal }}</span>
        </div>
        <div class="footer">
            <p>Thank you for the business!</p>
        </div>
    </div>
</body>

</html>
