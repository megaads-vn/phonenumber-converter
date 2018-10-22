<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <style>
            .loader {
                float: left;
                margin-left: 10px;
                margin-top: 5px;
                border: 4px solid #f3f3f3;
                border-radius: 50%;
                border-top: 4px solid #3498db;
                width: 25px;
                height: 25px;
                -webkit-animation: spin 2s linear infinite; /* Safari */
                animation: spin 2s linear infinite;
            }

            /* Safari */
            @-webkit-keyframes spin {
                0% { -webkit-transform: rotate(0deg); }
                100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
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
                            <?php if (isset($properties) && count($properties) > 0) {
                                ?>
                                <table class="table">
                                    <tr>
                                        <th>#</th>
                                        <th>Table</th>
                                        <th>Convert column</th>
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
                                            <td>
                                                <?php
                                                foreach($value as $item) {
                                                    ?>
                                                    <span><?= $item ?> </span>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td style="width: 200px;">
                                                <button data-table="<?= $key ?>" class="btn btn-default js-converting" style="float: left;">Convert</button>
                                                <div class="loader hidden" id="js-loader-<?= $key ?>"></div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                                <?php
                            } else {
                                ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>Warning!</strong>
                                    Config file config/phone_number_converter.php is required!
                                </div>
                                <?php
                            }?>
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
        $("#js-loader-" + table).removeClass("hidden");
        var url = '/package/phonenumber-converter-service';
        var data = {
                "table" : table
        };
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response) {
                if (response.status == 'successfuly') {
                    $("#js-loader-" + table).addClass("hidden");
                } else {
                    alert(response.message);
                }
            }
        });
    });
</script>
