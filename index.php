<?php
include("content.php");

headerContent("");
?>
    <div class="container">
        <div class="row">
            <!-- start content -->
            <form class="col s12" action="app/CodeSpecification.class.php" method="GET">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title"><b>Infor Table Name</b>
                                    <i class="material-icons right">more_vert</i></span>
                        <div class="input-field col s12">
                            <label for="tableName">Table name:</label>
                            <input id="tableName" type="text" name="tableName" required/>
                        </div><!-- /.col-lg-6 -->
                        <p>&nbsp;</p>
                    </div><!-- /.card-content -->
                    <div class="card-action">
                        <button type="submit" class="btn #0091ea light-blue accent-4"><i class="material-icons right">arrow_forward</i>Next</button>
                    </div>
                </div><!-- /.row -->

            </form>
            <p>&nbsp;</p>
        </div>
    </div>
<?php
footerContent("");