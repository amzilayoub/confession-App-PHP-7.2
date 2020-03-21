/*jslint browser: true*/
/*global document,window, $*/
$(document).ready(function () {
    'use strict';
    
    var pathName = location.href,
    searchCat = pathName.search('cat='),
    category = pathName.substring(searchCat);
    var time = 1;
    $(window).scroll(function () {
        //LOAD ELEMENT ON SCROLL
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 100) {
            $.ajax({
                method: 'GET',
                url: 'actions/posts.php?' + category,
                data: {
                    time: time
                },
                success: function (msg) {
                    $('.confessionPosts').append(msg);
                    time+=10;
                }
            });
        //SHOW SCROLL TOP BUTTON
        } else if ($(window).scrollTop() > 150) {
            $('.scrollUp').fadeIn(500);
        } else {
            $('.scrollUp').fadeOut(500);
        }
    });
    //ADD CLASS ACTIVE CATEGORY FOR THE a ELEMENT
    $('.categories a[href="?'+ category +'"]').addClass('activeCategory').parent().siblings('div').children('a').removeClass('activeCategory');
    //HEADER HEIGHT
    function headerHeight() {
        if ($(window).height() >= 420) {
            $('header').height($(window).height());
        } else {
            $('header').height(600);
        }
    }
    headerHeight();
    $(window).resize(function () {
        headerHeight();
    });
    //SHOW CATEGORIES
    $('.categories > span i').click(function () {
        $('.categories').toggleClass('showCategories');
    });
    //SHOW FULL POST
    $('.confessionPosts .confPost p').click(function () {
        var fullPost = $(this).parent().data('id'),
            postID = $(this).parent('.confPost').data('id'),
            numLikes = $(this).next().find('.fa-heart').html(),
            numComment = $(this).next().find('.fa-comment').html(),
            likesClass = $(this).next().find('.fa-heart').attr('class'),
            category = $(this).prev().html(),
            theClass = $(this).prev().attr('class');
        $('.fullPost').fadeIn();
        $('.fullPost .confPost').attr('data-id',postID);
        $('body').css('overflow', 'hidden');
        $.ajax({
            method: 'POST',
            url: 'actions/fullPost.php',
            data: {
                postID : fullPost
            },
            success: function (data) {
                $('.fullPost .confPost p').html(data);
                $('.fullPost .confPost h6').html(category);
                $('.fullPost .confPost h6').attr('class', theClass);
                $('.fullPost .confPost .fa-heart').html(numLikes);
                $('.fullPost .confPost .fa-comment').html(numComment);
                $('.fullPost .confPost .fa-heart').attr('class', likesClass);
            }
        });
    });
    //ADD LIKE TO POST FROM FULLPOST PAGE
    $('.fullPost .fa-heart').click(function () {
        var postID = $(this).closest('.confPost').data('id'),
            likes = parseInt($(this).text());
        if($(this).hasClass('unlike')) {
            $('.confessionPosts .confPost[data-id=' + postID + ']').find('.fa-heart').removeClass('unlike');
            $('.confessionPosts .confPost[data-id=' + postID + ']').find('.fa-heart').addClass('like');
            likes -= 1;
        } else {
            $('.confessionPosts .confPost[data-id=' + postID + ']').find('.fa-heart').addClass('unlike');
            $('.confessionPosts .confPost[data-id=' + postID + ']').find('.fa-heart').removeClass('like');
            likes += 1;
        }
        $('.confessionPosts .confPost[data-id=' + postID + ']').find('.fa-heart').text(likes);

    });
    //ADD LIKE
    $('.SocialIcon .fa-heart').click(function (e) {
        var thisHeart = $(this),
            addLike = 0,
            postID = $(this).closest('.confPost').data('id');
        if ($(this).hasClass('like')) {
            addLike = parseInt($(this).text()) + 1;
            $.ajax({
                type: 'POST',
                url: 'actions/addLike.php?postID=' + postID,
                data: {
                    newLikes : addLike
                },
                success: function () {
                    thisHeart.text(addLike);
                    thisHeart.removeClass('like').addClass('unlike');
                }
            });
        } else {
            addLike = parseInt($(this).text()) - 1;
            $.ajax({
                type: 'POST',
                url: 'actions/addLike.php?postID=' + postID,
                data: {
                    newLikes : addLike,
                    action : 'unlike'
                },
                success: function () {
                    thisHeart.text(addLike);
                    thisHeart.removeClass('unlike').addClass('like');
                }
            });
        }
    });
    //SHOW COMMENT
    $('.fullPost .fa-comment').click(function () {
        $('.fullPost .confPost').toggleClass('confPostWithComment');
        $('.fullPost').toggleClass('fullpostWithComment');
        $('.fullPost .comment').toggleClass('showComment');
    });
    $('.confessionPosts .fa-comment').click(function () {
        $('.fullPost .confPost').toggleClass('confPostWithComment');
        $('.fullPost').toggleClass('fullpostWithComment');
        $('.fullPost .comment').toggleClass('showComment');
        var postID = $(this).parent().closest('.confPost').data('id');
        var indexOfPara = $('.confessionPosts .confPost').index($(this).closest('.confPost'));
        $('.confessionPosts .confPost p').eq(indexOfPara).click();
        $.ajax({
            method : 'GET',
            url : 'actions/comment.php',
            data : {
                postID : postID,
                getComment : 'yes'
            },
            success : function (msg) {
                $('.comment > div').html(msg);
            }
        });
    });
    //SHOW FULL POST IN POST.PHP
    $('.pagePost .confPost').addClass('confPostWithComment');
    $('.pagePost').addClass('fullpostWithComment');
    $('.pagePost .comment').addClass('showComment');
    var postID = $('.confPost').data('id');
        $.ajax({
            method : 'GET',
            url : 'actions/comment.php',
            data : {
                postID : postID,
                getComment : 'yes'
            },
            success : function (msg) {
                $('.pagePost .comment > div').html(msg);
            }
        });
        $.ajax({
            method: 'POST',
            url: 'actions/fullPost.php',
            data: {
                postID : postID
            },
            success: function (data) {
                $('.fullPost .confPost p').html(data);
            }
        });
    //HIDE FULLE POST
    $('.fullPost > span i').click(function () {
        $('.fullPost').fadeOut(500, function () {
            $('body').css('overflow', 'auto');
            $('.fullPost .confPost').removeClass('confPostWithComment');
            $('.fullPost').removeClass('fullpostWithComment');
            $('.fullPost .comment').removeClass('showComment');
        });
    });

    //ADD COMMENT
    $('.comment input').click(function (e) {
        e.preventDefault();
        var textArea = $('.comment textarea'),
            postID = $(this).closest('.comment').siblings('.confPost').attr('data-id'),
            commentNum = parseInt($(' .fullPost .confPost[data-id='+ postID +'] .fa-comment').text());
        if (textArea.val().length != 0) {
            $.ajax({
                method: 'POST',
                url: 'actions/comment.php?postID=' + postID,
                data:{
                    theComment : textArea.val(),
                    addComment : 'yes'
                },
                success: function (msg) {
                    if(msg.length == 0){
                        $('.comment > div').prepend('<h6>' + textArea.val() +'</h6>');
                    textArea.val('');
                        $('.confPost[data-id='+ postID +'] .fa-comment').text(++commentNum)
                    } else {
                        $('body').append(msg);
                        $('.alert').fadeIn(500).delay(1500).fadeOut(500);
                    }
                }
            });
        } else {
            $('body').append('<div style="display: none;" class="alert alert-danger container alertForm" role="alert">من فضلك اكتب شيئا في التعليق</div>');
            $('.alert').fadeIn(500).delay(1500).fadeOut(500);
        }
    });

    //SHOW & HIDE ADD POST
    $('.navbar .addConf, .addPost .theForm span i, .addPost .layer').click(function () {
        $('.addPost').fadeToggle(500);
    });
    //ADD POST
    $('.addPost .inputs input').click(function (e) {
        var category = ['dream','fantasy','firstExperience','regret','pain','randomFel','real','hardExp','other'],
            error = '',
            paragraph = $('.addPost .inputs textarea').val(),
            paraCategory = $('.addPost .selectBox select').val();
        e.preventDefault();
        if ($.type(paragraph) == 'string' && $.type(paraCategory) == 'string' && $.inArray(paraCategory,category) >= 0) {
            if (paragraph.length >= 100) {
                $('.addPost .inputs input').attr('disabled', '');
                 $.ajax({
                    method: 'POST',
                    url: 'actions/addPost.php',
                    data: {
                        paragraph: paragraph,
                        paraCategory : paraCategory
                    },
                    success: function (error) {
                        if (error.length == 0) {
                            $('body').append('<div style="display: none;" class="alert alert-success" role="alert">تم اضافة الاعتراف بنجاح</div>')
                            $('.alert').fadeIn(500).delay(1500).fadeOut(500);
                            window.setTimeout(function () {
                                location.reload();
                            }, 2500);
                        } else {
                            $('body').append('<div style="display: none;" class="alert alert-danger container alertForm" role="alert">'+ error +'</div>');
                            $('.alert').fadeIn(500).delay(3000).fadeOut(500);
                        }
                    }
                });
            } else {
                error = 'يجب ان تكون على الأقضل 100 حرف';
            }
        } else {
            error = 'من فضلك اختر الصنف';
        }
        if (error.length > 0) {
            $('body').append('<div style="display: none;" class="alert alert-danger container alertForm" role="alert">'+ error +'</div>');
            $('.alert').fadeIn(500).delay(3000).fadeOut(500);
        }
    });




    //SHARE BUTTON
    $('.fa-share-alt, .sharePost .buttons > span, .sharePost .layer').click(function () {
        var postID = $(this).parents('.confPost').attr('data-id'),
            href = 'http://localhost/conf/post.php?id=' + postID;
        $('.twitter-share-button').attr('href','https://twitter.com/intent/tweet?url='+ href +'&text=&hashtags=اعترافات,اعتراف');
        $('.facebook-share-button').attr('href','https://www.facebook.com/sharer/sharer.php?app_id=556142121486313&sdk=joey&u='+ href +'&display=popup&ref=plugin&src=share_button')
        $('.whatsapp-share-button').attr('href','https://api.whatsapp.com/send?phone=whatsappphonenumber&text=' + href);
        $('.sharePost').fadeToggle(500);
    });


    //SCROLL TO TOP
    $('.scrollUp').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
    });
});