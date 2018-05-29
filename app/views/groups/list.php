<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
<div class="col-md-9 groups">
    <div class="row">
        <div id="errors_container"></div>
        <div class="panel panel-default groups-list">
            <div class="panel-heading">
                <h3 class="panel-title">Search groups</h3>
            </div>
            <div class="col-xs-8 mb-5 input-group groups-list__search-container">
                <form id="search-form">
                     <span class="input-group-btn">
                    <input type="text" class="form-control" id="search_term" placeholder="Search...">
                    <button class="btn btn-azure btn-file">Search
                    </button>
                </span>
                </form>
            </div>
            <div id="errors_container"></div>
            <div class="panel-body row" id="groups-list__container">
            </div>
            <div class="loader" id="loader"></div>
        </div>
    </div>
</div>
<script src="<?= ROOT_URI; ?>js/pages/groups-list.js"></script>
<?php
//include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
