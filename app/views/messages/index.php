<?php include VIEWS_PATH . DS . '_shared' . DS . 'header.php';
?>
    <link href="<?= ROOT_URI ?>css/messages.css" rel="stylesheet">

    <div class="col-xs-12" style="margin-top: -30px">
        <!--    <input type="text" name="color" id="color" value="" />-->
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <!-- search bar for searching friends-->
                <form id="search-form">
                <span class="input-group-btn search-btn-container">
                    <input type="text" class="form-control" name="search_contact" id="search_contact"
                           placeholder="Find people by name or email..."/>
                </span>
                </form>
            </div>
        </div>
        <div class="contacts">

            <div class="col-xs-4 bg-white ">
                <div class="row contacts__row ">
                    <header class="contacts__header">
                        <h2>Your contacts</h2>
                    </header>
                    <ul class="friend-list" id="friend_list">
                    </ul>
                </div>
                <!-- member list -->

            </div>
            <div class="col-xs-8 bg-white ">
                <div class="row contacts__row">
                    <div class="chat-message">
                        <header class="chat-message__header" id="chat-message__header">

                        </header>
                        <ul class="chat contacts__message-container" id="messages_list">
                            <li class="text-center">Just pick a contact or find one to start conversation!</li>
                        </ul>
                    </div>
                    <div class="chat-box bg-white">
                        <form action="" class="chat-form" id="chat-form">
                            <input type="hidden" id="contact_id" name="contact_id" value="">
                            <div class="input-group">
                                <input class="form-control border no-shadow no-rounded" name="message"
                                       placeholder="Type your message here">
                                <span class="input-group-btn">
                <button class="btn btn-success no-rounded">Send</button>
              </span>
                            </div><!-- /input-group -->
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <script src="<?= ROOT_URI; ?>js/pages/messages.js"></script>
<?php
include VIEWS_PATH . DS . '_shared' . DS . 'footer.php';


