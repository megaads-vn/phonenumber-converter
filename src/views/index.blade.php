<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-2 col-md-2">
                </div>
                <div class="col-xs-6 col-md-8">
                    <div class="page-header">
                        <h1>Phone number converter</h1>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Converting list</div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>Table</th>
                                    <th></th>
                                </tr>
                                <?php
                                $i = 0;
                                foreach ($properties as $key => $value) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $key ?></td>
                                        <td><button data-table="<?= $key ?>" class="btn btn-default js-converting">Convert</button></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(".js-converting").click(function(e) {
        var table = $(this).attr("data-table");
        var url = '/service/phonenumber-converter';
        var data = {
                "table" : table
        };
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response) {
                console.log(response);
            }
        });
    });
</script>
