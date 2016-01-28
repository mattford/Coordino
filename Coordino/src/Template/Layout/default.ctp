<?php
    $session = $this->request->session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=$pageTitle !== '' ? $pageTitle . ' | ' : '';?>Coordino</title>
    <?=$this->Html->css('screen.css');?>
    <?=$this->Html->css('prettify.css');?>
    <?=$this->Html->script('prettify/prettify.js');?>
    <?=$this->Html->css('skin.css');?>
    <!--[if IE]>
    <style type="text/css">
        .wrapper {
            zoom: 1;     /* triggers hasLayout */
        }  /* Only IE can see inside the conditional comment
	    and read this CSS rule. Don't ever use a normal HTML
	    comment inside the CC or it will close prematurely. */
    </style>
    <![endif]-->

    <!--[if lte IE 6]><link rel="stylesheet" href="stylesheets/lib/ie.css" type="text/css" media="screen" charset="utf-8"><![endif]-->
</head>
<body onload="prettyPrint()">

<div id="page">

<div class="wrapper" id="header">
    <div class="wrapper">
        <div id="top_actions" class="top_actions">
            <?php
            echo $this->Form->create('Post', array('action' => 'display'));
            echo $this->Form->text('needle', array('value' => 'search', 'onclick' => 'this.value=""'));
            echo $this->Form->end();
            ?>
            <ul class="tabs">
                <?php if($session->check('Auth.User.id')) { ?>
                    <li>
                        <?=$this->Html->link(
                            $session->read('Auth.User.username'),
                            '/users/' . $session->read('Auth.User.public_key') . '/' . $session->read('Auth.User.username')
                        );
                        ?>
                    </li>
                <?php } ?>
                <?php if(!$session->check('Auth.User.id')) { ?>
                    <li>
                        <?=$this->Html->link(
                            __('login',true),
                            array('controller' => 'users', 'action' => 'login')
                        );
                        ?>
                    </li>
                <?php } ?>
                <?php if(!$session->check('Auth.User.id') || $session->read('Auth.User.registered') == 0) { ?>
                    <li>
                        <?=$this->Html->link(
                            __('register',true),
                            array('controller' => 'users', 'action' => 'register')
                        );
                        ?>
                    </li>
                <?php } ?>
                <li>
                    <?=$this->Html->link(
                        __('about',true),
                        array('controller' => 'pages', 'action' => 'display', 'about')
                    );
                    ?>
                </li>
                <?php if($session->read('Auth.User.id')) { ?>
                    <li>
                        <?=$this->Html->link(
                            __('settings',true),
                            '/users/settings/' . $session->read('Auth.User.public_key')
                        );
                        ?>
                    </li>
                <?php } ?>
                <li>
                    <a href='#'><?php __('change language'); ?></a>
                    <ul>
                        <li><?=$this->Html->link(__('english',true),'/lang/eng')?></li>
                        <li><?=$this->Html->link(__('spanish',true),'/lang/esp')?></li>
                        <li><?=$this->Html->link(__('french',true),'/lang/fre')?></li>
                        <li><?=$this->Html->link(__('chinese',true),'/lang/chi')?></li>
                    </ul>
                </li>
                <?php if($session->check('Auth.User.id') && $session->read('Auth.User.permission') != '') { ?>
                    <li>
                        <?=$this->Html->link(
                            __('admin',true),
                            array('controller' => 'users', 'action' => 'admin')
                        );
                        ?>
                        <ul>
                            <li>
                                <?=$this->Html->link(
                                    ucfirst(__('settings',true)),
                                    array('controller' => 'users', 'action' => 'admin')
                                );
                                ?>
                            </li>
                            <li>
                                <?=$this->Html->link(
                                    ucfirst(__('Flagged Posts',true)),
                                    array('controller' => 'users', 'action' => 'flagged')
                                );
                                ?>
                            </li>
                            <li>
                                <?=$this->Html->link(
                                    ucfirst(__('User Management',true)),
                                    array('controller' => 'users', 'action' => 'admin_list')
                                );
                                ?>
                            </li>
                            <li>
                                <?=$this->Html->link(
                                    ucfirst(__('Blacklist',true)),
                                    array('controller' => 'users', 'action' => 'list_blacklist')
                                );
                                ?>
                            </li>
                            <li>
                                <?=$this->Html->link(
                                    ucfirst(__('Remote Settings',true)),
                                    array('controller' => 'users', 'action' => 'remote_settings')
                                );
                                ?>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if($session->check('Auth.User.id') && $session->read('Auth.User.registered') == 1) { ?>
                    <li>
                        <?=$this->Html->link(
                            __('logout',true),
                            array('controller' => 'users', 'action' => 'logout')
                        );
                        ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="wrapper">
        <a href="/"><?php echo $this->Html->image('logo.png', array('alt' => 'Logo', 'id' => 'logo')); ?></a>

        <ul class="tabs">
            <li>
                <?=$this->Html->link(__('Questions',true),'/');?>
            </li>
            <li><?=$this->Html->link(__('Tags',true),'/tags');?></li>
            <li><?=$this->Html->link(__('Unsolved',true),'/questions/unanswered');?></li>
            <li><?=$this->Html->link(__('Users',true),'/users');?></li>
        </ul>
        <ul class="tabs" style="float: right;">
            <li>
                <?=$this->Html->link(
                    __('Ask a question',true),
                    array('controller' => 'posts', 'action' => 'ask')
                );
                ?>
            </li>
        </ul>
    </div>

</div>

<div id="body" class="wrapper">
    <?= $this->Flash->render(); ?>
    <div id="content" class="wrapper">
        <?=$this->fetch('content');?>
    </div>
    <div id="sidebar" class="wrapper">

        <?php
        if(!empty($widgets)) {
            foreach($widgets as $widget) {
                ?>
                <div class="widget_box wrapper">
                    <?php if(!empty($widget['Widget']['title'])) {?>
                        <h3><?=$widget['Widget']['title'];?></h3>
                    <?php } ?>
                    <?=$widget['Widget']['content'];?>
                    <?php if(isset($admin) && $admin) { ?>
                        <a href="/widgets/edit/<?=$widget['Widget']['id'];?>" title="Edit this Widget"><?php __('edit'); ?></a>	|
                        <a href="/widgets/delete/<?=$widget['Widget']['id'];?>" title="Delete Widget"><?php __('del'); ?></a>
                    <?php } ?>
                </div>
            <?php
            }
        }

        if(isset($admin) && $admin):
            ?>
            <a href="/widgets/add<?php echo $_SERVER['REQUEST_URI']; ?>">
                <img src="/img/icons/plugin_edit.png" alt="Edit"/><?php __('add widgets to this page'); ?>.
            </a>
        <?php endif; ?>

    </div>
</div>


<div id="footer" class="wrapper">
    <div class="left">
        <ul class="tabs">
            <li>
                <?=$this->Html->link(__('home',true),'/');?></li>
            <li>
                <?=$this->Html->link(__('ask a question',true),'/questions/ask');?></li>

            <li>
                <?=$this->Html->link(__('about',true),'/about');?></li>
        </ul>

    </div>
    <?php
    echo $this->element('coordino');
    ?>
</div>


</div>

</body>
</html>