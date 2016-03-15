<link rel="stylesheet" href="stylesheets/print.css" type="text/css" media="print" charset="utf-8">
<!--[if lte IE 6]><link rel="stylesheet" href="stylesheets/lib/ie.css" type="text/css" media="screen" charset="utf-8"><![endif]-->
<?php echo $this->Html->script(array(
    'jquery/jquery.js',
    'jquery/jquery.tabs.js',
    'jquery/jquery.ui-1.7.2.js',
    'jquery/ui.core.js'
));
?>

<script type="text/javascript">
    $(function() { $("#tabs").tabs(); });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tabs div').hide(); // Hide all divs
        $('#tabs div:first').show(); // Show the first div
        $('#tabs ul li').addClass('inactive'); // set all links to inactive
        $('#tabs ul li:first').removeClass('inactive'); //remove inactive class from first link...
        $('#tabs ul li:first').addClass('active'); // ...and set the class of the first link to active
        $('#tabs ul li a').click(function(){ //When any link is clicked
            $('#tabs ul li').removeClass('active'); // Remove active class from all links
            $('#tabs ul li').removeClass('inactive');
            $('#tabs ul li').addClass('inactive'); // set all links to inactive
            $(this).parent().removeClass('inactive'); //remove inactive class from the link that was clicke
            $(this).parent().addClass('active'); //Set clicked link class to active
            var currentTab = $(this).attr('href'); // Set variable currentTab to value of href attribute of clicked link
            $('#tabs div').hide(); // Hide all divs
            $(currentTab).show(); // Show div with id equal to variable currentTab
            return false;
        });
    });
</script>
<div id="userAvatar">
    <div id="image">
        <?php if($user->has('image')): ?>
            <?= $this->Html->image($user->image, ['width' => 75, 'height' => 75]); ?>
        <?php else: ?>
            <?= $this->Html->image('answerAvatar.png', ['width'=>75, 'height' => 75]); ?>
        <?php endif; ?>
    </div>
</div>
<div id="userInfo">
    <?php if($user->has('info') && !empty($user->info)): ?>
        <?= $user->info; ?>
    <?php else: ?>
       <?= $user->username; ?> has not added any information about themselves yet!
    <?php endif; ?>
</div>
<div id="tabs" style="margin-top: 0px;">
    <ul>
        <li>
            <a href="#tab-1">
                <h3>stats</h3>
            </a>
        </li>
        <li>
            <a href="#tab-2">
                <h3>recent</h3>
            </a>
        </li>
        <li>
            <a href="#tab-3">
                <h3>Q</h3>
            </a>
        </li>
        <li>
            <a href="#tab-4">
                <h3>A</h3>
            </a>
        </li>
    </ul>

    <div class="tabPanel" id="tab-1">
        <h3>user information:</h3>
        <table style="float: left; display: inline;">
            <tr>
                <td>name</td>
                <td><?= $user->username; ?></td>
            </tr>
            <tr>
                <td>joined</td>
                <td><?=$user->joined->timeAgoInWords();?></td>
            </tr>
            <tr>
                <td>reputation</td>
                <td><?=$user->reputation;?></td>
            </tr>
        </table>

    </div>

    <div class="tabPanel" id="tab-2">
        <!-- recent activity displayed here -->
        <h3>recent activity:</h3>
        <?php if ($user->has('recent')) : ?>
        <table>
            <?php foreach($user->recent as $recent): ?>
                <tr>
                    <td>
                        <?php if ($recent->timestamp->isToday()): ?>
                            today
                        <?php elseif ($recent->timestamp->wasYesterday()) : ?>
                            yesterday
                        <?php else: ?>
                            <?= $recent->timestamp->niceShort(); ?>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($post->type == "answered" && $post->status == "open"): ?>
                            <span style="color:#0000ff;">replied</span>
                        <?php elseif ($recent->type == "answered" && $post->status == "correct"): ?>
                            <span style="color:#00aa00;">solved</span>
                        <?php elseif ($recent->type == "commented"): ?>
                            commented
                        <?php elseif ($recent->type == "asked"): ?>
                            <span style="color:#ffaa00;">asked</span>
                        <?php elseif ($recent->type == "edited") : ?>
                            <span style="color:#9999ff">edited</span>
                        <?php elseif ($recent->type == "edited") : ?>
                            edited
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if($recent->type == 'asked' || $recent->type == 'edited'): ?>
                            <?= $this->Html->link($recent->post->title, ['controller'=>'posts', 'view', $recent->post->id]) ?>
                        <?php elseif($recent->type == 'commented'): ?>
                            <?php if(isset($recent[$key]['Pad'])) : ?>
                                <a href="/questions/<?= $recent[$key]['Pad']['Post']['public_key'] ?>/<?= $recent[$key]['Pad']['Post']['url_title'] ?>">
                                    <?= $recent[$key]['Pad']['Post']['title'] ?>
                                </a>
                            <?php elseif(isset($recent[$key]['Real'])) : ?>
                                <a href="/questions/<?= $recent[$key]['Real']['Post']['public_key'] ?>/<?=$recent[$key]['Real']['Post']['url_title']?>">
                                    <?= $recent[$key]['Real']['Post']['title'] ?>
                                </a>

                            <?php endif; ?>
                        <?php  else : ?>
                            <a href="/questions/<?= $recent[$key]['Pad']['Post']['public_key'] ?>/<?= $recent[$key]['Pad']['Post']['url_title'] ?>">
                                <?= $recent[$key]['Pad']['Post']['title'] ?>
                            </a>
                        <?php endif; ?>


                        <?php  if($recent->type == 'edited'): ?>
                            <?php if(isset($recent[$key]['Pad'])) { ?>
                                <a href="/questions/<?= $recent[$key]['Pad']['Post']['public_key'] ?>/<?= $recent[$key]['Pad']['Post']['url_title'] ?>">
                                    <?= $recent[$key]['Pad']['Post']['title'] ?>
                                </a>
                            <?php }else { ?>
                                <a href="/questions/<?=$recent[$key]['Post']['public_key'];?>/<?=$recent[$key]['Post']['url_title'];?>">
                                    <?=$recent[$key]['Post']['title'];?>
                                </a>
                            <?php } ?>
                        <?php elseif(isset($recent[$key]['Pad'])) : ?>
                            <a href="/questions/<?=$recent[$key]['Pad']['Post']['public_key'];?>/<?=$recent[$key]['Pad']['Post']['url_title'];?>">
                                <?=$recent[$key]['Pad']['Post']['title'];?>
                            </a>
                        <?php else : ?>
                            <a href="/questions/<?=$recent[$key]['Post']['public_key'];?>/<?=$recent[$key]['Post']['url_title'];?>">
                                <?=$recent[$key]['Post']['title'];?>
                            </a>
                        <?php endif ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>

    </div><!-- end recent tab -->

    <div class="tabPanel" id="tab-3">
        <h3>questions asked:</h3>
        <?php foreach($user->recent_asked as $recent) { ?>
            <p>
                <?= $this->Html->link($recent->title, ['controller' => 'posts', 'action' => 'view', $recent->id]); ?>         
            </p>
        <?php } ?>
    </div><!-- end questions tab -->

    <div class="tabPanel" id="tab-4">
        <h3>replies given:</h3>
        <?php foreach($user->recent_answered as $recent): ?>
            <p>
                <?php if($recent[$key]['History']['type'] == 'answered') : ?>
                    <?= $this->Html->link($recent->title, ['controller' => 'posts', 'action' => 'view', $recent->id]); ?>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
    </div><!-- end answers tab -->

    <div class="tabPanel" id="tab-5">
        <h3>tags assigned:</h3>
        <p>content for tags tab</p>
    </div>
</div><!-- end tabs-->