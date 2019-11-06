<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$file_name}}</title>

    <style type="text/css">
        /* * {
            font-family: Verdana, Arial, sans-serif;
        } */

        body { font-family: "dejavu sans", serif; }
        
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }
    </style>

</head>
<body>
<table width="100%" style="border-bottom: 2px solid #ccc">
    <tr>
        <td valign="top" align="center"><img src="https://mirado-mebel.ru/images/logo.png" alt="" width="150"/></td>
    </tr>
</table>
<table width="100%">
    <tr align="center">
        <h4 align="center">Как и договаривались, направляю Вам коммерческое предложение c расчётом стоимости материалов</h4>
        <h1 align="center">
            Здравствуйте {{$name}}
        </h1>
    </tr>
</table>
@foreach( $commerces as $commerce)
    <h3>{{$commerce->name}}</h3>
    @if( $commerce->positions )
        <table width="100%" bgcolor="#bbb">
            <thead style="background-color: #ccc;">
                <tr>
                    <th>Наименование</th>
                    <th>Материалы</th>
                    <th>Количество</th>
                    <th>Цена</th>
                </tr>
            </thead>
            <tbody>
                @php $final_price = 0; @endphp
                @foreach($commerce->positions as $position)
                    @php $final_price += $position->price * $rate * $position->count; @endphp
                    <tr  bgcolor="#fff">
                        <td>@php echo($position->category_name) @endphp</td>
                        <td>@php echo($position->position_name)@endphp</td>
                        <td align="right">@php echo($position->count)@endphp</td>
                        <td align="right">@php echo($position->price * $rate * $position->count)@endphp</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td align="right">Итого</td>
                    <td align="right">@php echo($final_price); @endphp</td>
                </tr>
            </tfoot>
        </table>
    @endif
@endforeach
<br />
<br />
<br />
<table width="100%" style="background-color: rgb(60, 59, 59);padding: 10px;">
    <tr>
                <td valign="middle" align="left"><img src="https://mirado-mebel.ru/img/logo.png" alt="img" width="150"/></td>
        <td valign="middle" align="right">
            <p style="color: #fff;">Г.МОСКВА, ПЕРЕУЛОК КАПРАНОВА 3, ОФИС 104. <br />
                INFO@MIRADO-MEBEL.RU <br />
                +7 (495) 777-79-44 <br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>