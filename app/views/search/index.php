<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
    <div class="col-md-9 search">
        <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Search</h3>
                </div>
                <div class="panel-body">
                    <div class="col-xs-8 mb-5 input-group groups-list__search-container">
                        <form id="search-form">
                             <span class="input-group-btn">
                                <input type="text" class="form-control" id="search_term" name="search_term"
                                       value="<?=$_GET['search']??'' ?>"
                                       placeholder="Search...">
                                <button class="btn btn-azure btn-file">
                                    Search
                                </button>
                             </span>
                        </form>
                    </div>
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="search__nav">
                            <li role="presentation" class="active">
                                <a href="#people" aria-controls="people" role="tab" data-toggle="tab">
                                    People
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#groups" aria-controls="groups" role="tab" data-toggle="tab">
                                    Groups
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#events" aria-controls="events" role="tab" data-toggle="tab">
                                    Events
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#jobs" aria-controls="jobs" role="tab" data-toggle="tab">
                                    Jobs
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content clearfix">
                            <div role="tabpanel" class="tab-pane active search__tab" id="people">
                            </div>
                            <div role="tabpanel" class="tab-pane search__tab" id="groups">...</div>
                            <div role="tabpanel" class="tab-pane search__tab" id="events">...</div>
                            <div role="tabpanel" class="tab-pane search__tab" id="jobs">...</div>
                        </div>
                        <div class="loader" id="loader"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= ROOT_URI; ?>js/pages/search.js"></script>

<?php
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>