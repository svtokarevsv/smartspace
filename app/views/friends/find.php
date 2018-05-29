<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
$current_user=$_SESSION['current_user'];
?>

    <!-- Begin page content -->
    <div class="row col-md-9">
        <div class="col-md-12 ">
            <div class="row">
                <div class="col-md-12">
                    <!-- friend feature options-->
                    <div class="m-t-xs btn-group pull-right mb2">
                        <a  href="<?=ROOT_URI?>friends" class="btn btn-md btn-white "><i class="fa fa-fw fa-users "></i> Friends</a>
                        <a  href="<?=ROOT_URI?>friends/requests" class="btn btn-md btn-white "><i class="fa fas fa-user-plus "></i> Friend Requests</a>
                        <a  href="" class="btn btn-md btn-white "><i class="fa fas fa-search-plus"></i>Find Friends</a>
                    </div>

                </div>
            </div>
            <div class="col-xs-8 mb-5 input-group groups-list__search-container">
                <!-- search bar for searching friends-->
                <form id="search-form">
                     <span class="input-group-btn">
                    <input type="text" class="form-control" id="search_term" placeholder="Search...">
                    <button class="btn btn-azure btn-file">Search
                    </button>
                </span>
                </form>
            </div>
            <!-- error container -->
            <div id="errors_container"></div>
            <!-- search results-->
            <div id="search_container" style="display: flex; -ms-flex-wrap: wrap;  flex-wrap: wrap;">
            </div>
            <div class="loader" id="loader"></div>

        </div>
    </div>

    <script src="<?= ROOT_URI; ?>js/pages/friend-find.js"></script>
<?php
//include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>