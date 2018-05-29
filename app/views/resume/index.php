
<!-- Header and Left Sidebar -->
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
use App\lib\Session;

?>



<!-- Main Content-->

    <div class="col-md-9">
        <div class="widget">
            <div class="widget-header">
                <h1 class="widget-caption">Resume</h1>
            </div>
            <div class="widget-body bordered-top  bordered-sky">
                <div class="row mb2">
                    <div><?php Session::flash(); ?></div>
                </div>

                <div class="row mb1">
                    <div class="col-md-12">
                        <?php foreach($data['display_keywords'] as $k): ?>
                           <h5 class="row-title mr1"><i class="fa fa-tag"></i> <?= $k['keyword'] ?></h5>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="row mb1">
                    <div class="col-md-12">
                        <div class="mb1 pull-right">
                            <?= $data['display_resume_link']?>
                        </div>
                    </div>
                </div>

                <div class="row mb3">
                    <div class="col-md-12 mb3">
                        <?= $data['display_resume']?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <a href="<?=ROOT_URI?>resume/edit">
                            <button type="button" class="btn btn-default col-md-4 pull-right"><i class="fa fa-edit"></i>Edit</button>
                        </a>
                    </div>
                </div>

            </div> <!-- end of widget body-->
        </div><!-- end of widget -->
    </div><!-- end  main contents -->
    
<!-- End of Main Container -->


<!-- Footer and Right sidebar -->
<?php
// include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>






