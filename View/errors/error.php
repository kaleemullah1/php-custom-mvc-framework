<div class="d-flex align-items-center justify-content-center vh-100 text-white">
    <div class="text-center">
        <h1 class="display-1 fw-bold text-white">500</h1>
        <p class="fs-3"></p>
        <p class="lead">
            Internal server error
        </p>
        <?php if(APP_ENV == 'dev'){ ?>
            <div class="row ml-5 mr-5 pl-5 pr-5">
                <h3 class="text-white">Stack Trace</h3>
            </div>
        <div class="row ml-5 mr-5 pl-5 pr-5">
            <span>Message : &nbsp;</span>
            <?php if(!empty($message)){
                echo $message;
            } ?>
        </div>
        <div class="row ml-5 mr-5 pl-5 pr-5 mw-100">
            <?php
            if(!empty($trace)){
                echo json_encode($trace);
            }
            ?>
        </div>
        <?php } ?>
    </div>
</div>