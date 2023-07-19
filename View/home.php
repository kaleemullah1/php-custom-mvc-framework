<div class="container">

    <div class="row col d-flex justify-content-center">
        <section class="pb-4 mt-4 pt-4 w-75">
            <div class="bg-white border rounded-3">
                <div class="row mb-4 mt-4">
                    <div class="col d-flex justify-content-center">
                        <h3>Hi There! <?php echo $greetings ?></h3>
                    </div>
                </div>

                <div class="row mb-1 mt-1" <?php echo empty($error)?'style="display:none;"':''; ?>>
                    <div class="col d-flex justify-content-center">
                        <?php if(is_array($error)){
                            foreach ($error as $e){
                                ?>
                                <div class="alert alert-danger w-75" role="alert">
                                    <?php echo $e; ?>
                                </div>
                                <?php
                            }
                        }else{
                            ?>
                            <div class="alert alert-danger w-75" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <section class="w-100 p-4 d-flex justify-content-center pb-4">


                </section>
            </div>
        </section>
    </div>
</div>