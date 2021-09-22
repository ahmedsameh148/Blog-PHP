<?php
require_once('../config.php');
require_once(BASE_PATH . '/logic/users.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/layout/header.php');
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$page_size = 10;
$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';

function getUrl($page, $q)
{
    return "/admin/filter_posts.php?page=$page&q=$q";
}

$users = getUsers($page_size, $page, null, $q);
$page_count = ceil($users['count'] / $page_size);
/*
$posts = ['data'=>[],'count'=>100,'order_field'=>'title','order_by'=>'asc']
*/

?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Filter Users</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Banner Ends Here -->
<section class="blog-posts">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="all-blog-posts">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="sidebar-item search">
                                <form id="search_form" name="gs" method="GET" action="">
                                    <input type="text" class="form-control" value="<?= isset($_REQUEST['q']) ? $_REQUEST['q'] : '' ?>" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
                                </form>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = ($page - 1) * $page_size+1;
                                foreach ($users['data'] as $user) {
                                    if(getUserId() == $user['id'])
                                        continue;
                                    echo "<tr>
                                            <td>$i</td>
                                            <td>{$user['name']}</td>
                                            <td>{$user['username']}</td>
                                            <td>{$user['email']}</td>
                                            <td>{$user['phone']}</td>
                                            <td>".(($user['type'] == 0) ? "User" : "Admin")."</td>
                                            <td>
                                                <a onclick='return confirm(\"Are you sure ?\")' href='deleteUser.php?id={$user['id']}' class='btn btn-danger'>Delete</a>
                                            </td>
                                            <td> 
                                                <a onclick='return confirm('Are you sure ?')' 
                                                    href='updateUserActivation.php?id={$user['id']}&value=".(($user['active'] == 1)?"0":"1").
                                                    "' class='btn btn-danger'>".(($user['active'] == 1) ? "Block" : "Unblock")."</a>
                                            </td>
                                            
                                        </tr>";

                                    $i++;
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-12">
                        <ul class="page-numbers">
                            <?php
                            $prevUrl = getUrl($page - 1, $q);
                            $nxtUrl = getUrl($page + 1, $q);

                            if ($page > 1) echo "<li><a href='{$prevUrl}'><i class='fa fa-angle-double-left'></i></a></li>";

                            for ($i = 1; $i <= $page_count; $i++) {
                                $url = getUrl($i, $q);
                                echo "<li class=" . ($i == $page ? "active" : "") . "><a href='{$url}'>{$i}</a></li>";
                            }

                            if ($page < $page_count) echo "<li><a href='{$nxtUrl}'><i class='fa fa-angle-double-right'></i></a></li>";
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once(BASE_PATH . '/layout/footer.php') ?>