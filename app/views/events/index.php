<?php
include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
include VIEWS_PATH . DS . '_shared' . DS . 'left_sidebar.php';
?>




    <!-- Begin page content -->
    <!-- time line events-->
    <div class="col-md-6">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-8 input-group groups-list__search-container">
                    <form id="search-form">
                        <span class="input-group-btn">
                            <input type="text" class="form-control" id="search_term_events" placeholder="Search...">
                            <button class="btn btn-azure btn-file">Search</button>
                        </span>
                    </form>
                </div>
                <!--Trigger modal-->
                <button type="button" data-toggle="modal" data-target="#create" class="btn btn-azure"
                        style="margin-bottom: 10px">Create Event
                </button>

            </div>

            <!--Modal-->
            <div id="events" class="col-xs-12 all_events_list"></div>
            <div class="loader" id="loader"></div>
        </div>
    </div><!-- clo-md-6 -->
    <!-- end time line events-->


    <!-- Toggle modal CREATE-->

    <div class="modal fade" id="create" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Event</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="create_event_form" method="post"
                          enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="new_event_name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="new_event_name" name="new_event_name"
                                       placeholder="Event name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_event_location"
                                   class="col-sm-3 control-label">Location</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="new_event_location"
                                       name="new_event_location" placeholder="Address" required>
                            </div>
                            <a class="col-sm-1 input-group" id="open_map_modal" style="height: 34px;
    display: flex;
    align-items: center;
    padding-right: 0;
    margin-right: 15px;">
                                <span class="btn-default fa fa-map-marker"></span>
                            </a>
                        </div>

                        <div class="form-group">
                            <label for="new_event_start" class="col-sm-3 control-label">Start date/time</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="new_event_date_start"
                                       name="new_event_date_start" placeholder="Date" required>
                            </div>
                            <div class="col-sm-4">
                                <input type="time" class="form-control" id="new_event_time_start"
                                       name="new_event_time_start" placeholder="Time" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_event_end" class="col-sm-3 control-label">End date/time</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="new_event_date_end"
                                       name="new_event_date_end" placeholder="Date" required>
                            </div>
                            <div class="col-sm-4">
                                <input type="time" class="form-control" id="new_event_time_end"
                                       name="new_event_time_end" placeholder="Time" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_event_description" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="new_event_description"
                                          placeholder="Event description..."
                                          name="new_event_description" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="event_image"><a><i style="pointer-events: none;"
                                                                                          class="fa fa-image"></i></a></label>
                            <div class="col-sm-8">
                                <span id="show_image_path" style="color: #2dc3e8;"></span>
                                <input type="file" id="event_image" name="event_image" required>
                                <p class="help-block">Only jpeg,jpg and png formats supported</p>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="create_event" class="btn btn-blue" data-dismiss="modal">Create</button>
                </div>

            </div>
        </div>
    </div>



<!--Toggle modal MAPS-->
    <div class="modal fade" id="maps_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choose location</h4>
                </div>

                <div class="modal-body" id="g_map" style="height: 70vh;">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>



    <!-- Toggle modal EDIT-->

    <div class="modal fade" id="edit" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Event</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" id="edit_event_form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="edit_event_id">
                        <div class="form-group">
                            <label for="edit_event_name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_event_name" name="edit_event_name"
                                       placeholder="Event name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_event_location" class="col-sm-3 control-label">Location</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_event_location"
                                       name="edit_event_location" placeholder="Address" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_event_start" class="col-sm-3 control-label">Start date/time</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="edit_event_start" name="edit_event_start"
                                       placeholder="Date" required>
                            </div>
                            <div class="col-sm-4">
                                <input type="time" class="form-control" id="edit_event_time_start"
                                       name="edit_event_time_start" placeholder="Time" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_event_end" class="col-sm-3 control-label">End date/time</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="edit_event_end" name="edit_event_end"
                                       placeholder="Date" required>
                            </div>
                            <div class="col-sm-4">
                                <input type="time" class="form-control" id="edit_event_time_end"
                                       name="edit_event_time_end" placeholder="Time" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_event_description" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="edit_event_description"
                                          placeholder="Event description..."
                                          name="edit_event_description" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="edit_event_image"><a><i
                                            style="pointer-events: none;"
                                            class="fa fa-image"></i></a></label>
                            <div class="col-sm-8">
                                <span id="show_image_path" style="color: #2dc3e8;"></span>
                                <input type="file" id="edit_event_image" name="edit_event_image" required>
                                <p class="help-block">Only jpeg,jpg and png formats supported</p>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="edit_event" class="btn btn-blue" data-dismiss="modal">Update</button>
                </div>

            </div>
        </div>
    </div>


    <!-- Toggle modal DELETE-->
    <div class="modal fade" id="delete" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Event</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" id="delete_event_form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="delete_event_id"/>

                        <h3>Are you sure you want to delete this event?</h3>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="delete_event" class="btn btn-blue" data-dismiss="modal">Delete</button>
                </div>

            </div>
        </div>
    </div>


    <script src="<?= ROOT_URI; ?>js/pages/events.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_JLVj60zN9-7tKNmNem4Khpc3hlFhhMw"
            type="text/javascript"></script>
    <script src="<?= ROOT_URI; ?>js/pages/events-google-maps.js"></script>

<?php
include VIEWS_PATH . DS . '_shared' . DS . 'right_sidebar.php';
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php'
?>