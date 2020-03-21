<?php
    session_start();
    $noFooter = '';
     if (isset($_GET['id']) && is_numeric($_GET['id'])) {
     	require 'admin/ini.php';
     	likeAndID();
        ?>
        <!-- START SHARE POST SECTION  -->
          <section class="sharePost" style="display: none;">
            <div class="layer"></div>
            <div class="buttons">
                <span><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i></span>
                <div class="socialMedia">
                    <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=Hello world yes we can" data-size="large" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a class="facebook-share-button" href="https://www.facebook.com/sharer/sharer.php?app_id=556142121486313&sdk=joey&u=URL&display=popup&ref=plugin&src=share_button" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a class="whatsapp-share-button" href="https://api.whatsapp.com/send?phone=whatsappphonenumber&text=urlencodedtext" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                </div>
            </div>
          </section>
      <!-- END SHARE POST SECTION  -->
        <?php
        echo '<section class="fullPost pagePost" style="display:block;">';
        getPost('WHERE ID = ?', array($_GET['id'])) . '</section>';
        echo '<div class="comment">
            <form method="POST" action="index.php">
                <textarea name="myComment" placeholder="اترك تعليقا ,,,"></textarea>
                <input type="submit" name="send" value="اضافة">
            </form>
            <div>
            </div>
        </div>';
        require 'includes/templates/footer.php';
    } else {
    	header("location: index.php");
    	exit();
    }