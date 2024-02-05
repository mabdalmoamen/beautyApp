<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        html {
            font-family: sans-serif;
            width: 700px!important;
            margin: auto!important;;
        }

        table {
            border-collapse: collapse;
            border: 2px solid rgb(200,200,200);
            font-size: 0.8rem;
            width: 700px!important;

        }

        td, th {
            border: 1px solid rgb(190,190,190);
            padding: 10px 20px;
        }

        th {
            background-color: rgb(235,235,235);
        }

        td {
            text-align: center;
        }

        tr:nth-child(even) td {
            background-color: rgb(250,250,250);
        }

        tr:nth-child(odd) td {
            background-color: rgb(245,245,245);
        }

        caption {
            padding: 10px;
        }

    </style>
</head>

<body>
<h1> {{$details['body']}}</h1>

<table>
    <caption>
        {{$details['title']}}
    </caption>

    <tbody>

    <tr>
        <th scope="col">اجمالي جميع الفواتير</th>
        <td>{{$details['total']}}</td>

    </tr>

    <tr>
        <th scope="col">عدد جميع الفواتير</th>
        <td>{{$details['count']}}</td>

    </tr>

    <tr>
        <th scope="col">اجمالي المدفوع كاش</th>
        <td>{{$details['Cash']}}</td>

    </tr>

    <tr>
        <th scope="col">عدد المدفوع كاش</th>
        <td>{{$details['CashCount']}}</td>

    </tr>

    <tr>
        <th scope="col">اجمالي المدفوع شبكة</th>
        <td>{{$details['Card']}}</td>

    </tr>

    <tr>
        <th scope="col">عدد المدفوع شبكة</th>
        <td>{{$details['CardCount']}}</td>

    </tr>

    <tr>
        <th scope="col">اجمالي المدفوع اجل</th>
        <td>{{$details['Later']}}</td>
    </tr>

    <tr>
        <th scope="col">عدد المدفوع اجل</th>
        <td>{{$details['LaterCount']}}</td>


    </tr>

    <tr>


    </tr>

    </tbody>
</table>
</body>

</html>
