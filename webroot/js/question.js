/**
 * Javascript for a question view page, enables the up/downvote buttons
 */
$(document).ready(function() {
   
   $('.upvote').click(function() {
       var postId = $(this).attr('data-postid');
       $.post('/questions/vote.json', {
           postId: postId,
           direction: 'up'
       }, handleVoteResponse, 'json');
   });
   
   $('.downvote').click(function() {
       var postId = $(this).attr('data-postid');
       $.post('/questions/vote.json', {
           postId: postId,
           direction: 'down'
       }, handleVoteResponse, 'json');
   });
   
   var handleVoteResponse = function (data) {
       if (data.response.status === 0) {
           return false;
       }
       var postId = data.response.postId;
       $('#votes-'+postId).text(data.response.newVoteCount);
       $('.user-'+data.response.userId+'-rep').text(data.response.newUserRep);
       
       switch (data.response.newVoteDirection) {
            case 'up':
                $('#upvote-'+postId).attr('src', '/img/arrow_up_orange.png');
                $('#upvote-'+postId).addClass('upvoted');
                $('#downvote-'+postId).attr('src', '/img/arrow_down.png');
                $('#downvote-'+postId).removeClass('downvoted');
                break;
            case 'down':
                $('#upvote-'+postId).attr('src', '/img/arrow_up.png');
                $('#upvote-'+postId).removeClass('upvoted');
                $('#downvote-'+postId).attr('src', '/img/arrow_down_orange.png');
                $('#downvote-'+postId).addClass('downvoted');
                break;
            case 'none':
                $('#upvote-'+postId).attr('src', '/img/arrow_up.png');
                $('#upvote-'+postId).removeClass('upvoted');
                $('#downvote-'+postId).attr('src', '/img/arrow_down.png');  
                $('#downvote-'+postId).removeClass('downvoted');
                break;
       }
       
       
   }
    
});

