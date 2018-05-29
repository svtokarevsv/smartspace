<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>
<div class="col-md-6 location">
    <div class="row">
        <div id="errors_container"></div>
        <div class="panel panel-default groups-list">
            <div class="panel-heading">
                <h3 class="panel-title">Location management</h3>
            </div>
            <div class="panel-body row">
                <div class="col-md-6">
                    <p class="bold">Your last location was near:</p>
                    <p id="current_user_location"></p>
                    <button class="btn btn-primary location__update-btn">
                        Update my location
                    </button>
                </div>
                <div class="col-md-6">
                    <form id="location-search-form">
                        <div class="input-group-btn search-btn-container">
                            <input type="text" class="form-control" name="search_friend" id="search_friend"
                                   placeholder="Find friend's location..."/>
                        </div>
                    </form>
                    <p id="friend_location"></p>
                </div>

                <div class="location__map" id="map">

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBplw50QM2_usK_S8O8c5ERYDHmZqMSmE4"
        defer></script>
<script src="<?= ROOT_URI; ?>js/pages/location.js" defer></script>

<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>
