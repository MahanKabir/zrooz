<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>



<div class="table-responsive">
    <table class="table table-bordered">

        <tbody>
        <?php
            $i = 0;
            echo "<tr>";
        ?>
        @foreach($serials as $serial)
            @if($serial->check == 1)
                <td>{{ $serial->serial }}</td>
            @endif
            <?php
                $i++;
                if ($i == 3){
                    $i = 0;
                    echo "</tr><tr>";
                }
            ?>
        @endforeach

        </tbody>
    </table>
</div>
</body>
</html>
