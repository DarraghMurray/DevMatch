<?php 
            if(isset($_GET['logIn'])) {
                if($_GET['logIn'] === 'fail') {
                    if(isset($_GET['error'])) {
                        echo("<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Your log-in failed! </strong>" . $_GET['error'] .
                                "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>");
                    } else {
                        echo("<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <strong>Your log-in failed</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>");
                    }
                }
            }
?>