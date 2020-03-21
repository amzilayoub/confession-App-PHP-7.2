<?php
    //GET POSTS
    function getPost($cond = '',$condValue = array(),$limit = 0){
        global $connect;
        $stmt = $connect->prepare("SELECT * FROM posts ". $cond ." ORDER BY Date_Add DESC LIMIT ". $limit .", 12");
        $stmt->execute($condValue);
        $rows = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            foreach ($rows as $row) {
                $categoryName = '';
                switch ($row['Category']) {
                    case 'dream':
                        $categoryName = 'حلم';
                        break;
                    case 'fantasy':
                        $categoryName = 'خيال';
                        break;
                    case 'firstExperience':
                        $categoryName = 'تجربة أولى';
                        break;
                    case 'regret':
                        $categoryName = 'ندم';
                        break;
                    case 'pain':
                        $categoryName = 'ألم';
                        break;
                    case 'randomFel':
                        $categoryName = 'مشاعر مبعثرة';
                        break;
                    case 'real':
                        $categoryName = 'حقيقة';
                        break;
                    case 'hardExp':
                        $categoryName = 'تجربة قاسية';
                        break;
                    case 'other':
                        $categoryName = 'اخرى';
                        break;
                }
                $post = '<div id='. $row['ID'] .' class="confPost" data-id='. $row['ID'] .'>' .
                            '<h6 class='. $row['Category'] .'>' . $categoryName . '</h6>' .
                            '<p>' . substr($row['Post'], 0,100) . '...' . '</p>' .
                            '<div class="SocialIcon">';
                            $likeIt = FALSE;
                            foreach ($_SESSION['likesinfo'] as $array) {
                                if ($array['Post_ID'] == $row['ID']) {
                                    $likeIt = TRUE;
                                    break;
                                }
                            }
                        $counts = $connect->prepare('SELECT
                                                        (SELECT COUNT(ID) FROM likes WHERE Post_ID = ?) AS likesCount,
                                                        (SELECT COUNT(ID) FROM comments WHERE Post_ID = ?) AS commentsCount');
                        $counts->execute(array($row['ID'],$row['ID']));
                        $theNumber = $counts->fetch();
                        if ($likeIt) {
                            $post .= '<a><i class="fa fa-heart unlike" aria-hidden="true">' . $theNumber['likesCount'] . '</i></a>';
                        } else {
                            $post .= '<a><i class="fa fa-heart like" aria-hidden="true">' . $theNumber['likesCount'] . '</i></a>';
                        }

                        $post .= '<a><i class="fa fa-comment" aria-hidden="true">' . $theNumber['commentsCount'] . '</i></a>' .
                        '<a><i class="fa fa-share-alt" aria-hidden="true">' . $row['Shares'] . '</i></a>' .
                    '</div>' .
                '</div>';
                echo $post;
            }
        }
    }


    //GET LIKE UNFO AND USER ID
    function likeAndID(){
        global $connect;
        $stmt = $connect->prepare('SELECT * FROM users WHERE Username = ? AND Password = ?');
        $stmt->execute(array(strip_tags(trim($_SESSION['user'])),strip_tags(trim($_SESSION['password']))));
        $row = $stmt->fetch();
        $_SESSION['id'] = $row['ID'];
        if ($stmt->rowCount() > 0) {
            $stmt = $connect->prepare('SELECT Post_ID ,User_ID FROM likes WHERE User_ID = ?');
            $stmt->execute(array($row['ID']));
            $_SESSION['likesinfo'] = $stmt->fetchAll();
        } else {
            $_SESSION['likesinfo'] = [];
        }
    }
?>