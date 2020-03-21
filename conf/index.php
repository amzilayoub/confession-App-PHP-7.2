<?php
    session_start();
    require 'admin/ini.php';
    likeAndID();
    $footerStyle = 'width: calc(100% - 168px);left: -168px;'
?>
<!-- START ASIDE BAR -->
      <span class="scrollUp"><i class="fa fa-arrow-up" aria-hidden="true"></i></span>
      <div class="categories">
        <span><i class="fa fa-bars" aria-hidden="true"></i></span>
        <div class="allCategories">
            <div><a href="index.php" class="activeCategory">كل الاعترافات</a></div>
            <div><a href="?cat=dream">عن حلم</a></div>
            <div><a href="?cat=fantasy">في الخيال</a></div>
            <div><a href="?cat=firstExperience">أول تجربة</a></div>
            <div><a href="?cat=regret">ندم</a></div>
            <div><a href="?cat=pain">ألم</a></div>
            <div><a href="?cat=randomFel">مشاعر مبعثرة</a></div>
            <div><a href="?cat=real">حقيقة</a></div>
            <div><a href="?cat=hardExp">تجربة قاسية</a></div>
            <div><a href="?cat=other">أخرى</a></div>
        </div>
      </div>
      <!-- END ASIDE BAR -->
      <!-- START MAIN content -->
      <section class="confessionPosts">
                <?php
                $category = array('dream','fantasy','firstExperience','regret','pain','randomFel','real','hardExp','other');
                    if (isset($_GET['cat']) && !empty($_GET['cat']) && in_array($_GET['cat'], $category)) {
                        getPost('WHERE Category = ?', array(strip_tags(trim($_GET['cat']))));
                    } else {
                        getPost();
                    }
                ?>
      </section>
      <!-- START FULL POST -->
      <section class="fullPost" id="fullPost">
        <span><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i></span>
        <div class="confPost" data-id='0'>
            <h6></h6>
            <p></p>
            <div class="SocialIcon">
                <a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-comment" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="comment">
            <form method="POST" action="index.php">
                <textarea name="myComment" placeholder="اترك تعليقا ,,,"></textarea>
                <input type="submit" name="send" value="اضافة">
            </form>
            <div>
            </div>
        </div>
      </section>
      <!-- END FULL POST -->
      <!-- START ADD POST -->
      <section class="addPost">
        <div class="layer"></div>
        <div class="theForm">
              <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <span><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i></span>
                <div class="selectBox">
                    <label>الصنف</label>
                    <select name="postCategory">
                        <option value="...">...</option>
                        <option value="dream">حلم</option>
                        <option value="fantasy">خيال</option>
                        <option value="firstExperience">أول تجربة</option>
                        <option value="regret">ندم</option>
                        <option value="pain">ألم</option>
                        <option value="randomFel">مشاعر مبعثرة</option>
                        <option value="real">حقيقة</option>
                        <option value="hardExp">تجربة فاسية</option>
                        <option value="other">أخرى</option>
                    </select>
                </div>
                <div class="inputs">
                    <textarea name="thePost"></textarea>
                    <input type="submit" value="أضافة ">
                </div>
              </form>
        </div>
      </section>
      <!-- END ADD POST -->
      <!-- START SHARE POST SECTION  -->
      <section class="sharePost" style="display: none;">
        <div class="layer"></div>
        <div class="buttons">
            <span><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i></span>
            <div class="socialMedia">
                <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=Hello world yes we can" data-size="large" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')">
                    <i class="fa fa-twitter" aria-hidden="true"></i></i>
                </a>
                <a class="facebook-share-button" href="https://www.facebook.com/sharer/sharer.php?app_id=556142121486313&sdk=joey&u=URL&display=popup&ref=plugin&src=share_button" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a class="whatsapp-share-button" href="https://api.whatsapp.com/send?phone=whatsappphonenumber&text=urlencodedtext" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
            </div>
        </div>
      </section>
      <!-- END SHARE POST SECTION  -->
      <!-- END MAIN content -->
<?php
    require 'includes/templates/footer.php';